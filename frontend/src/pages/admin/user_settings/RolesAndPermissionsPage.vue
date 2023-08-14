<template>
  <q-page class="admin admin--page">
    <admin-page-title :admin-page-title="currentRouteTitle(router.currentRoute.value.meta)" />

    <admin-page-description
      :admin-route-name="currentRouteName(router.currentRoute.value.name)"
      :admin-application-name="applicationName"
      :admin-page-description="currentRouteDescription(router.currentRoute.value.meta)"
    />

    <admin-page-container :admin-route-name="currentRouteName(router.currentRoute.value.name)">
      <template v-slot:admin-content>
        <admin-page-container-table
          :advance-filter-record="true"
          :applied-filters="appliedFilters && appliedFilters.length ? appliedFilters : []"
          :columns="TableColumns"
          :create-new-record="true"
          :delete-record-button="true"
          :edit-record-button="true"
          :filters="getAllFilters"
          :fullscreen-button="true"
          :loading="loadData"
          :rows="getAllRecords.data"
          :show-record-button="true"
          :rows-per-page-options="[10, 20, 50, 100, 0]"
          :top-left-slot="true"
          :top-right-slot="true"
          :top-row-slot="true"
          @action-method-dialog="actionMethodDialog"
          @filter-record="filterRecord"
          @clear-filter="clearFilter"
        />
      </template>
    </admin-page-container>

    <admin-page-container-dialog
      v-if="displayActionDialog"
      :action-name="actionName"
      :display-action-dialog="displayActionDialog"
      :record-id="selectedRecordId"
      @closeDialog="() => displayActionDialog = false"
      @handle-action-method="handleActionMethod"
    >
      <template v-slot:record-details>
        <div class="admin-section__container-dialog-content">
          <p v-for="(record, index) in getSingleRecord" :key="index" class="q-mb-none">
            <template v-if="index.toString() !== 'bg_color' && index.toString() !== 'text_color'">
              <span class="text-bold">{{ displayLabel(index) }}</span>:
              <q-badge
                v-if="index.toString() === 'slug' && record"
                :style="'background-color: #' + getSingleRecord.bg_color + '; color: #' + getSingleRecord.text_color"
                :label="record.toString()"
              />
              <q-badge
                v-else-if="index.toString() === 'is_active' && record"
                :color="(record as unknown as boolean) === true ? 'positive' : 'negative'"
                text-color="black"
                :label="record.toString()"
              />
              <span v-else>
                {{ record ?? '—' }}
              </span>
            </template>
          </p>
        </div>
      </template>
    </admin-page-container-dialog>
  </q-page>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useRouter } from 'vue-router';
import { ref, onMounted, computed, Ref } from 'vue';
import { useI18n } from 'vue-i18n';

// Import generic components, libraries and interfaces
import AdminPageTitle from 'src/components/AdminPageTitle.vue';
import AdminPageDescription from 'src/components/AdminPageDescription.vue';
import AdminPageContainer from 'src/components/AdminPageContainer.vue';
import AdminPageContainerTable from 'src/components/AdminPageContainerTable.vue';
import AdminPageContainerDialog from 'src/components/AdminPageContainerDialog.vue';
import TableColumns from 'src/columns/rolesAndPermissionColumns';
import { displayLabel } from 'src/library/TextOperations';
import { notificationSystem } from 'src/library/NotificationSystem/NotificationSystem';
import { DialogType } from 'src/types/DialogType';
import { FilterInterface } from 'src/interfaces/ApiResponseInterface';
import { applicationName } from 'src/composables/CopyrightInfo';
import {
  currentRouteName,
  currentRouteTitle,
  currentRouteDescription
} from 'src/composables/RouteInfo';
import { readFilterFromLocalStorage } from 'src/library/FilterToLocalStorage/ReadFilterFromLocalStorage';
import { updateFilterToStore } from 'src/library/FilterToLocalStorage/UpdateFilterToStore';

// Import Pinia's related utilities
import { useUserRoleStore } from 'src/stores/admin/userSettings/userRoles';

// Instantiate the pinia store
const userRoleStore = useUserRoleStore();

// Defined the translation variable
const { t } = useI18n({});

// Get current route title and route name
const router = useRouter();

// Load table data
const loadData = ref(false)

// Fetch all user roles and permissions
const getAllRecords = computed(() => userRoleStore.getAllRecords);

// Get all filters
const getAllFilters = computed(() => {
  appliedFilters = readFilterFromLocalStorage.value(userRoleStore.$id)

  if (appliedFilters && appliedFilters.length) {
    return updateFilterToStore.value(userRoleStore.getAllFilters, appliedFilters)
  } else {
    return userRoleStore.getAllFilters
  }
})

// Display the action name & dialog
const actionName: Ref<DialogType | undefined> = ref(undefined)
const displayActionDialog = ref(false)

// Fetch single user details
const getSingleRecord = computed(() => userRoleStore.getSingleRecord);

async function filterRecord(appliedFilters: Pick<FilterInterface, 'key' | 'value'>[]) {
  loadData.value = true
  await userRoleStore.getRecords(appliedFilters).then(() => {
    loadData.value = false
  })
}

async function clearFilter(filterKey: string) {
  loadData.value = true
  const savedSearch: string | null = localStorage.getItem(`${userRoleStore.$id}-filters`)
  appliedFilters = []
  if (savedSearch && savedSearch !== null) {
    const existingSearchQuery: Record<string, string | number | null> = JSON.parse(savedSearch);
    if (existingSearchQuery.hasOwnProperty(filterKey)) {
      if (Object.keys(existingSearchQuery).length > 1) {
        delete existingSearchQuery[filterKey]
        localStorage.setItem(`${userRoleStore.$id}-filters`, JSON.stringify(existingSearchQuery));
      } else {
        localStorage.removeItem(`${userRoleStore.$id}-filters`);
      }
      await userRoleStore.getRecords().then(() => {
        loadData.value = false
      })
    }
  } else {
    loadData.value = false
    const notificationTitle = t('admin.generic.notification_info_title')
    const notificationMessage = t('admin.generic.no_filters_applied', {
      resourceName: t(currentRouteTitle.value(router.currentRoute.value.meta) as string)
    })
    notificationSystem(notificationTitle, notificationMessage, 'info', 'bottom', true)
  }
}

/**
 * Perform an action (show, edit, or delete) on a
 * specific record with the given record ID.
 * @param action - The type of action to perform
 * on the record. It can be 'show', 'edit', or 'delete'.
 * @param recordId - The ID of the record on
 * which the action will be performed.
 * @returns - A promise that resolves when
 * the action is completed or rejects if an error occurs.
 */
async function actionMethodDialog(action: DialogType, recordId?: number) {
  loadData.value = true
  if (action === 'create') {
    loadData.value = false
    actionName.value = action
    displayActionDialog.value = true
  } else if (action === 'advanced-filters') {
    loadData.value = false
    actionName.value = action
    displayActionDialog.value = true
  } else {
    const isInvalidRecordId = !recordId || typeof recordId !== 'number' || recordId === null || recordId === undefined;
    if (isInvalidRecordId) {
      const notificationTitle = t('admin.generic.notification_warning_title');
      const notificationMessage = t('admin.generic.notification_warning_message', { recordId: `${recordId}` });
      console.log(
        `The operation could not be performed. Invalid record id: ${recordId}!`
      );
      loadData.value = false
      notificationSystem(notificationTitle, notificationMessage, 'warning', 'bottom', true)
    } else {
      userRoleStore.findRecord(recordId).then(() => {
        loadData.value = false
        actionName.value = action
        getSingleRecord.value
        displayActionDialog.value = true
      })
    }
  }
}

/**
 * Computed property to get the 'id'
 * of the selected record from 'getSingleRecord' array.
 * @returns The 'id' of the selected record if available,
 * or null if the array is empty.
 */
const selectedRecordId = computed(() => {
  const recordId = getSingleRecord.value && Object.keys(getSingleRecord.value).length > 0 ? getSingleRecord.value.id : null;
  return recordId
});

/**
 * Performs an action based on the provided DialogType.
 * Example: If the action is 'create' than 'createRecord'
 * will be called from the pinia store.
 * @param action - The type of action to be performed
 * ('create', 'edit', 'delete').
 */
function handleActionMethod(action: DialogType) {
  displayActionDialog.value = false
  loadData.value = true
  if (action === 'create') {
    userRoleStore.createRecord().then(() => {
      loadData.value = false
    })
  } else {
    const recordId = getSingleRecord.value && Object.keys(getSingleRecord.value).length > 0 ? getSingleRecord.value.id : null;
    if (recordId) {
      if (action === 'edit') {
        userRoleStore.updateRecord(recordId).then(() => {
          loadData.value = false
        })
      } else if (action === 'delete') {
        userRoleStore.deleteRecord(recordId).then(() => {
          loadData.value = false
        })
      }
    } else {
      const notificationTitle = t('admin.generic.notification_warning_title');
      const notificationMessage = t('admin.generic.notification_warning_message', { recordId: `${recordId}` });
      console.log(
        `The operation could not be performed. Invalid record id: ${recordId}!`
      );
      notificationSystem(notificationTitle, notificationMessage, 'warning', 'bottom', true)
    }
  }
}

let appliedFilters: Pick<FilterInterface, 'key' | 'value'>[] = [];
onMounted(async () => {
  loadData.value = true
  const savedSearch: string | null = localStorage.getItem(`${userRoleStore.$id}-filters`)
  if (savedSearch && savedSearch !== null) {
    const existingSearchQuery: Record<string, string | number | null> = JSON.parse(savedSearch);
    const filterArray: Pick<FilterInterface, 'key' | 'value'>[] = Object.keys(existingSearchQuery).map((key) => ({
      key,
      value: existingSearchQuery[key]
    }));
    appliedFilters = filterArray
    await userRoleStore.getRecords(filterArray)
      .then(() => {
        appliedFilters = []
        loadData.value = false
      })
  } else {
    await userRoleStore.getRecords()
      .then(() => {
        loadData.value = false
      })
  }
})
</script>

<style lang="scss" scoped></style>
