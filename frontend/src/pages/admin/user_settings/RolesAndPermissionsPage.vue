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
import { FilterInterface, PaginatedResultsInterface } from 'src/interfaces/ApiResponseInterface';
import { applicationName } from 'src/composables/CopyrightInfo';
import {
  currentRouteName,
  currentRouteTitle,
  currentRouteDescription
} from 'src/composables/RouteInfo';
import { readFilterFromLocalStorage } from 'src/library/FilterToLocalStorage/ReadFilterFromLocalStorage';
import { updateFilterToStore } from 'src/library/FilterToLocalStorage/UpdateFilterToStore';
import { removeFilterFromLocalStorage } from 'src/library/FilterToLocalStorage/RemoveFilterFromLocalStorage';
import { UserRoleInterface } from 'src/interfaces/UserInterface';

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

/**
 * Computed function that retrieves all records from the userRoleStore.
 * @returns {PaginatedResultsInterface} An object representing paginated results
 * containing user records.
 */
const getAllRecords = computed((): PaginatedResultsInterface => userRoleStore.getAllRecords);

/**
 * Computed function that retrieves and processes filters from the userRoleStore.
 * @returns {FilterInterface[]} An array of filter objects representing filters.
 */
const getAllFilters = computed((): FilterInterface[] => {
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

/**
 * Computed function that retrieves a single user record from the userRoleStore.
 * @returns {UserInterface} An object representing a single user record.
 */
const getSingleRecord = computed((): UserRoleInterface => userRoleStore.getSingleRecord);

/**
 * Asynchronously filters user records based on the provided filters and updates the data accordingly.
 * @param {Pick<FilterInterface, 'key' | 'value'>[]} appliedFilters - An array of filter objects with 'key' and 'value' properties.
 * @returns {Promise<void>} A Promise that resolves once the filtering and data update process is complete.
 */
async function filterRecord(appliedFilters: Pick<FilterInterface, 'key' | 'value'>[]): Promise<void> {
  loadData.value = true
  await userRoleStore.getRecords(appliedFilters).then(() => {
    loadData.value = false
  })
}

/**
 * Asynchronously clears a specific filter, updates saved search in localStorage,
 * and fetches updated user records based on the applied filters.
 * @param {string} filterKey - The key associated with the filter to be cleared.
 * @returns {Promise<void>} A Promise that resolves once the clearing and data update process is complete.
 */
async function clearFilter(filterKey: string): Promise<void> {
  loadData.value = true
  const savedSearch: string | null = localStorage.getItem(`${userRoleStore.$id}-filters`)
  appliedFilters = []
  if (savedSearch && savedSearch !== null) {
    const existingSearchQuery: Record<string, string | number | null> = JSON.parse(savedSearch);
    removeFilterFromLocalStorage.value(userRoleStore.$id, existingSearchQuery, filterKey)
    await userRoleStore.getRecords().then(() => {
      loadData.value = false
    })
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
 * Asynchronously manages action dialogs based on the provided action type and record ID.
 * @param {DialogType} action - The type of action to perform in the dialog.
 * @param {number | undefined} recordId - The ID of the record associated with the action (if applicable).
 * @returns {Promise<void>} A Promise that resolves once the action dialog handling is complete.
 */
async function actionMethodDialog(action: DialogType, recordId?: number): Promise<void> {
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
 * Computed property that retrieves the ID of the selected record if available.
 * @returns {number | null} The ID of the selected record, or null if no record is selected.
 */
const selectedRecordId = computed((): number | null => {
  const recordId = getSingleRecord.value && Object.keys(getSingleRecord.value).length > 0 ? getSingleRecord.value.id : null;
  return recordId
});

/**
 * Asynchronously handles action methods such as creating, editing, or deleting records.
 * @param {DialogType} action - The type of action to perform.
 * @returns {Promise<void>} A Promise that resolves once the action handling is complete.
 */
async function handleActionMethod(action: DialogType): Promise<void> {
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
