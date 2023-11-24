<template>
  <q-page class="admin admin--page">
    <page-title :page-title="t('admin.management.content.title')" />

    <page-description
      :page-description="t('admin.management.content.page_description')"
    />

    <div class="admin-section admin-section--container">
      <management-grid-table
        :columns="contentStore.getColumns"
        :resource="contentStore.resourceName"
        :rows="contentStore.getAllRecords.results?.data || []"
        @handle-open-dialog="handleOpenDialog"
      />
    </div>

    <dialog-card
      v-if="displayDialog"
      :action-name="actionName"
      :display-dialog="displayDialog"
      @handle-close-dialog="() => (displayDialog = false)"
      @handle-action-dialog="handleActionDialog"
    >
      <template v-slot:dialog-details>
        <management-card-create
          v-if="actionName === 'create'"
          :data-model="contentStore.getDataModel"
          :resource="contentStore.resourceName"
        />
        <management-card-show v-if="actionName === 'show'" />
        <management-card-quick-edit
          v-if="actionName === 'quick-edit'"
          :data-model="contentStore.getDataModel"
          :resource="contentStore.resourceName"
        />
        <management-card-delete v-if="actionName === 'delete'" />
        <management-card-advanced-filter
          v-if="actionName === 'advanced-filters'"
          :data-model="contentStore.getFilterModel"
          :resource="contentStore.resourceName"
        />
        <management-card-upload
          v-if="actionName === 'upload'"
          :data-model="contentStore.getUploadModel"
          :resource="contentStore.resourceName"
        />
        <management-card-download
          v-if="actionName === 'download'"
          :data-model="contentStore.getDownloadModel"
          :resource="contentStore.resourceName"
        />
        <management-card-stats v-if="actionName === 'stats'" />
      </template>
    </dialog-card>

    <page-loading :visible="loadPage" />
  </q-page>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';
import { Ref, ref } from 'vue';

// Import library utilities, interfaces and components
import { TDialog } from 'src/interfaces/BaseInterface';
import PageTitle from 'src/components/PageTitle.vue';
import PageDescription from 'src/components/PageDescription.vue';
import ManagementGridTable from 'src/components/ManagementGridTable.vue';
import DialogCard from 'src/components/DialogCard.vue';
import ManagementCardCreate from 'src/components/ManagementCardCreate.vue';
import ManagementCardShow from 'src/components/ManagementCardShow.vue';
import ManagementCardQuickEdit from 'src/components/ManagementCardQuickEdit.vue';
import ManagementCardDelete from 'src/components/ManagementCardDelete.vue';
import ManagementCardAdvancedFilter from 'src/components/ManagementCardAdvancedFilter.vue';
import ManagementCardUpload from 'src/components/ManagementCardUpload.vue';
import ManagementCardDownload from 'src/components/ManagementCardDownload.vue';
import ManagementCardStats from 'src/components/ManagementCardStats.vue';
import PageLoading from 'src/components/PageLoading.vue';

// Import Pinia's related utilities
import { useContentStore } from 'src/stores/management/content';

// Instantiate the pinia store
const contentStore = useContentStore();

// Defined the translation variable
const { t } = useI18n({});

// Load page
const loadPage = ref(false);

// Get all records
contentStore.handleIndex();

// Display the action name & dialog
const actionName: Ref<TDialog | undefined> = ref(undefined);
const displayDialog = ref(false);

// Action dialog
async function handleOpenDialog(action: TDialog, recordId?: number): Promise<void> {
  loadPage.value = true;
  if (
    action === 'create' ||
    action === 'advanced-filters' ||
    action === 'upload' ||
    action === 'download'
  ) {
    actionName.value = action;
    loadPage.value = false;
    displayDialog.value = true;
  } else {
    debugger;
    const isInvalidRecordId =
      !recordId ||
      typeof recordId !== 'number' ||
      recordId === null ||
      recordId === undefined;
    if (isInvalidRecordId) {
      // const notificationTitle = t('admin.generic.notification_warning_title');
      // const notificationMessage = t('admin.generic.notification_warning_message', { recordId: `${recordId}` });
      // console.log(`The operation could not be performed. Invalid record id: ${recordId}!`);
      loadPage.value = false;
      // notificationSystem(notificationTitle, notificationMessage, 'warning', 'bottom', true)
    } else {
      // Pinia store get record by ID
    }
  }
}

// Handle action method
async function handleActionDialog(action: TDialog): Promise<void> {
  loadPage.value = true;
  switch (action) {
    case 'create':
      contentStore.handleCreate().then(() => {
        loadPage.value = false;
        displayDialog.value = false;
      });
    case 'show':
      loadPage.value = false;
      displayDialog.value = false;
    case 'quick-edit':
      contentStore.handleUpdate().then(() => {
        loadPage.value = false;
        displayDialog.value = false;
      });
    case 'delete':
      contentStore.handleDelete().then(() => {
        loadPage.value = false;
        displayDialog.value = false;
      });
    case 'advanced-filters':
      contentStore.handleAdvancedFilter().then(() => {
        loadPage.value = false;
        displayDialog.value = false;
      });
    case 'upload':
      contentStore.handleUpload().then(() => {
        loadPage.value = false;
        displayDialog.value = false;
      });
    case 'download':
      contentStore.handleDownload().then(() => {
        loadPage.value = false;
        displayDialog.value = false;
      });
    default:
      break;
  }
}
</script>

<style lang="scss" scoped>
@import 'src/css/pages/admin/content.scss';
</style>
