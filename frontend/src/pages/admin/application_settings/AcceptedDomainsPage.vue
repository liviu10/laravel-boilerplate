<template>
  <q-page class="admin admin--page">
    <admin-page-title :admin-page-title="currentRouteTitle" />

    <admin-page-description
      :admin-route-name="currentRouteName"
      :admin-application-name="applicationName"
      :admin-page-description="currentRouteDescription"
    />

    <admin-page-container :admin-route-name="currentRouteName">
      <template v-slot:admin-content>
        <admin-page-container-table
          :columns="TableColumns"
          :create-new-record="true"
          :delete-record-button="true"
          :edit-record-button="true"
          :fullscreen-button="true"
          :loading="loadData"
          :rows="getAllRecords.data"
          :show-record-button="true"
          :rows-per-page-options="[10, 20, 50, 100, 0]"
          :top-left-slot="true"
          :top-right-slot="true"
          :top-row-slot="true"
          @action-method-dialog="actionMethodDialog"
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
                <span>
                  {{ item ?? '—' }}
                </span>
              </div>
            </template>
            <template v-else>
              <q-badge
                v-if="index.toString() === 'is_active' && record"
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
import TableColumns from 'src/columns/acceptedDomainsColumns';
import { displayLabel } from 'src/library/TextOperations';
import { notificationSystem } from 'src/library/NotificationSystem';
import { DialogType } from 'src/types/DialogType';

// Import Pinia's related utilities
import { useAcceptedDomainStore } from 'src/stores/admin/applicationSettings/acceptedDomains';

// Instantiate the pinia store
const acceptedDomainStore = useAcceptedDomainStore();

// Defined the translation variable
const { t } = useI18n({});

// Get current route title and route name
const router = useRouter();
let currentRouteName = ref(router.currentRoute.value.name);
let currentRouteTitle = ref(t(router.currentRoute.value.meta.title as string))
let currentRouteDescription = ref(t(router.currentRoute.value.meta.caption as string))

// Get application name
const applicationName: string | undefined = process.env.APP_NAME

// Load table data
const loadData = ref(false)

// Fetch all user roles and permissions
const getAllRecords = computed(() => acceptedDomainStore.getAllRecords);

// Display the action name & dialog
const actionName: Ref<DialogType | undefined> = ref(undefined)
const displayActionDialog = ref(false)

// Fetch single user details
const getSingleRecord = computed(() => acceptedDomainStore.getSingleRecord);

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
  } else {
    const isInvalidRecordId = !recordId || typeof recordId !== 'number' || recordId === null || recordId === undefined;
    if (isInvalidRecordId) {
      const notificationTitle = t('admin.generic.notification_warning_title');
      const notificationMessage = t('admin.generic.notification_warning_message', { recordId: `${recordId}` });
      console.log(
        `The operation could not be performed. Invalid record id: ${recordId}!`
      );
      loadData.value = false
      notificationSystem(notificationTitle, notificationMessage, 'warning');
    } else {
      acceptedDomainStore.findRecord(recordId).then(() => {
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
    acceptedDomainStore.createRecord().then(() => {
      loadData.value = false
    })
  } else {
    const recordId = getSingleRecord.value && Object.keys(getSingleRecord.value).length > 0 ? getSingleRecord.value.id : null;
    if (recordId) {
      if (action === 'edit') {
        acceptedDomainStore.updateRecord(recordId).then(() => {
          loadData.value = false
        })
      } else if (action === 'delete') {
        acceptedDomainStore.deleteRecord(recordId).then(() => {
          loadData.value = false
        })
      }
    } else {
      const notificationTitle = t('admin.generic.notification_warning_title');
      const notificationMessage = t('admin.generic.notification_warning_message', { recordId: `${recordId}` });
      console.log(
        `The operation could not be performed. Invalid record id: ${recordId}!`
      );
      notificationSystem(notificationTitle, notificationMessage, 'warning');
    }
  }
}

onMounted(async () => {
  loadData.value = true
  await acceptedDomainStore.getRecords().then(() => {
    loadData.value = false
  })
})
</script>

<style lang="scss" scoped></style>
