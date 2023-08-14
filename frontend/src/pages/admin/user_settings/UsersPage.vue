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
            <span class="text-bold">{{ displayLabel(index) }}</span>:
            <template v-if="record !== null && (typeof record === 'object')">
              <div v-for="(item, key) in record" :key="key" class="q-ml-md">
                <span class="text-bold">
                  {{ displayLabel(key) }}
                </span>:
                <q-badge
                  v-if="key.toString() === 'is_active' && item"
                  :color="(item as unknown as boolean) === true ? 'positive' : 'negative'"
                  text-color="black"
                  :label="item.toString()"
                />
                <template v-else-if="Array.isArray(item)">
                  <template v-for="(subItem, key) in item" :key="key">
                    <template v-for="(i, j) in subItem" :key="j">
                      <div v-if="j === 'name' || j === 'is_active'" class="q-ml-md">
                        <span class="text-bold">
                          {{ displayLabel(j) }}
                        </span>:
                        <span v-if="j === 'is_active'">
                          {{ i }}
                        </span>
                        <span v-else>
                          {{ j }}: {{ i }}
                        </span>
                      </div>
                    </template>
                  </template>
                </template>
                <span v-else>
                  {{ item ?? '—' }}
                </span>
              </div>
            </template>
            <template v-else>
              <a v-if="index.toString() === 'email' && record" :href="'mailto:' + record">
                {{ record }}
              </a>
              <a v-else-if="index.toString() === 'phone' && record" :href="'tel:' + record">
                {{ record }}
              </a>
              <a v-else-if="index.toString() === 'profile_image' && record" :href="record.toString()">
                {{ t('admin.generic.view_image_label') }}
              </a>
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
import TableColumns from 'src/columns/userColumns';
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
import { useUserStore } from 'src/stores/admin/userSettings/users';

// Instantiate the pinia store
const userStore = useUserStore();

// Defined the translation variable
const { t } = useI18n({});

// Get current route title and route name
const router = useRouter();

// Load table data
const loadData = ref(false)

const getAllRecords = computed(() => userStore.getAllRecords);

const getAllFilters = computed(() => {
  appliedFilters = readFilterFromLocalStorage.value(userStore.$id)

  if (appliedFilters && appliedFilters.length) {
    return updateFilterToStore.value(userStore.getAllFilters, appliedFilters)
  } else {
    return userStore.getAllFilters
  }
})

// Display the action name & dialog
const actionName: Ref<DialogType | undefined> = ref(undefined)
const displayActionDialog = ref(false)

// Fetch single user details
const getSingleRecord = computed(() => userStore.getSingleRecord);

async function filterRecord(appliedFilters: Pick<FilterInterface, 'key' | 'value'>[]) {
  loadData.value = true
  await userStore.getRecords(appliedFilters).then(() => {
    loadData.value = false
  })
}

async function clearFilter(filterKey: string) {
  loadData.value = true
  const savedSearch: string | null = localStorage.getItem(`${userStore.$id}-filters`)
  appliedFilters = []
  if (savedSearch && savedSearch !== null) {
    const existingSearchQuery: Record<string, string | number | null> = JSON.parse(savedSearch);
    if (existingSearchQuery.hasOwnProperty(filterKey)) {
      if (Object.keys(existingSearchQuery).length > 1) {
        delete existingSearchQuery[filterKey]
        localStorage.setItem(`${userStore.$id}-filters`, JSON.stringify(existingSearchQuery));
      } else {
        localStorage.removeItem(`${userStore.$id}-filters`);
      }
      await userStore.getRecords().then(() => {
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
      userStore.findRecord(recordId).then(() => {
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
    userStore.createRecord().then(() => {
      loadData.value = false
    })
  } else {
    const recordId = getSingleRecord.value && Object.keys(getSingleRecord.value).length > 0 ? getSingleRecord.value.id : null;
    if (recordId) {
      if (action === 'edit') {
        userStore.updateRecord(recordId).then(() => {
          loadData.value = false
        })
      } else if (action === 'delete') {
        userStore.deleteRecord(recordId).then(() => {
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
  const savedSearch: string | null = localStorage.getItem(`${userStore.$id}-filters`)
  if (savedSearch && savedSearch !== null) {
    const existingSearchQuery: Record<string, string | number | null> = JSON.parse(savedSearch);
    const filterArray: Pick<FilterInterface, 'key' | 'value'>[] = Object.keys(existingSearchQuery).map((key) => ({
      key,
      value: existingSearchQuery[key]
    }));
    appliedFilters = filterArray
    await userStore.getRecords(filterArray)
      .then(() => {
        appliedFilters = []
        loadData.value = false
      })
  } else {
    await userStore.getRecords()
      .then(() => {
        loadData.value = false
      })
  }
})
</script>

<style lang="scss" scoped></style>
