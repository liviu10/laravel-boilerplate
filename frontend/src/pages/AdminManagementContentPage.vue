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
      :disable-action-dialog-button="disableActionDialogButton"
      @handle-close-dialog="() => (displayDialog = false)"
      @handle-action-dialog="handleActionDialog"
      @handle-navigate-to-page="handleNavigateToPage"
    >
      <template v-slot:dialog-details>
        <management-card-advanced-filter
          v-if="actionName === 'advanced-filters'"
          action-name="advanced-filters"
          :data-model="contentStore.getFilterModel"
          :resource="contentStore.resourceName"
        />

        <management-card-upload
          v-if="actionName === 'upload'"
          action-name="upload"
          :data-model="contentStore.getUploadModel"
          :resource="contentStore.resourceName"
        />

        <management-card-download
          v-if="actionName === 'download'"
          action-name="download"
          :data-model="contentStore.getDownloadModel"
          :resource="contentStore.resourceName"
        />

        <management-card-restore
          v-if="actionName === 'restore'"
          action-name="restore"
          :record-details="contentStore.getAllDeletedRecords"
          :resource="contentStore.resourceName"
        />

        <management-card-quick-show
          v-if="actionName === 'quick-show'"
          action-name="quick-show"
          :record-details="contentStore.getSingleRecord"
          :resource="contentStore.resourceName"
        />

        <management-card-quick-edit
          v-if="actionName === 'quick-edit'"
          action-name="quick-edit"
          :data-model="contentStore.getDataModel"
          :resource="contentStore.resourceName"
        >
          <template v-slot:record-details>
            <management-card-quick-show
              action-name="quick-show"
              :record-details="contentStore.getSingleRecord"
              :resource="contentStore.resourceName"
            />
          </template>
        </management-card-quick-edit>

        <management-card-delete
          v-if="actionName === 'delete'"
          action-name="delete"
          :resource="contentStore.resourceName"
        >
          <template v-slot:record-details>
            <management-card-quick-show
              action-name="quick-show"
              :record-details="contentStore.getSingleRecord"
              :resource="contentStore.resourceName"
            />
          </template>
        </management-card-delete>

        <management-card-stats v-if="actionName === 'stats'" action-name="stats" />
      </template>
    </dialog-card>

    <page-loading :visible="loadPage" />
  </q-page>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';
import { Ref, ref } from 'vue';
import { RouteParamsRaw, useRouter } from 'vue-router';

// Import library utilities, interfaces and components
import { HandleRoute } from 'src/utilities/HandleRoute';
import { TDialog } from 'src/interfaces/BaseInterface';
import { HandleObject } from 'src/utilities/HandleObject';
import PageTitle from 'src/components/PageTitle.vue';
import PageDescription from 'src/components/PageDescription.vue';
import ManagementGridTable from 'src/components/ManagementGridTable.vue';
import DialogCard from 'src/components/DialogCard.vue';
import ManagementCardAdvancedFilter from 'src/components/ManagementCardAdvancedFilter.vue';
import ManagementCardUpload from 'src/components/ManagementCardUpload.vue';
import ManagementCardDownload from 'src/components/ManagementCardDownload.vue';
import ManagementCardRestore from 'src/components/ManagementCardRestore.vue';
import ManagementCardQuickShow from 'src/components/ManagementCardQuickShow.vue';
import ManagementCardQuickEdit from 'src/components/ManagementCardQuickEdit.vue';
import ManagementCardDelete from 'src/components/ManagementCardDelete.vue';
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
contentStore.handleIndex('paginate');

// Display the action name & dialog
const actionName: Ref<TDialog | undefined> = ref(undefined);
const displayDialog = ref(false);
const disableActionDialogButton: Ref<{
  action: TDialog | undefined;
  disable: boolean;
}> = ref({ action: undefined, disable: false });

// Handle open dialog
async function handleOpenDialog(action: TDialog, recordId?: number): Promise<void> {
  const checkObject = new HandleObject();
  loadPage.value = true;
  switch (action) {
    case 'create':
      actionName.value = action;
      loadPage.value = false;
      handleNavigateToPage(action);
      break;
    case 'advanced-filters':
      actionName.value = action;
      loadPage.value = false;
      displayDialog.value = true;
      if (contentStore.getFilterModel.length === 0) {
        disableActionDialogButton.value = {
          action: action,
          disable: true,
        };
      }
      break;
    case 'upload':
      actionName.value = action;
      loadPage.value = false;
      displayDialog.value = true;
      if (contentStore.getUploadModel.length === 0) {
        disableActionDialogButton.value = {
          action: action,
          disable: true,
        };
      }
      break;
    case 'download':
      actionName.value = action;
      loadPage.value = false;
      displayDialog.value = true;
      if (contentStore.getDownloadModel.length === 0) {
        disableActionDialogButton.value = {
          action: action,
          disable: true,
        };
      }
      break;
    case 'stats':
      actionName.value = action;
      loadPage.value = false;
      displayDialog.value = true;
      break;
    case 'quick-show':
      actionName.value = action;
      contentStore.handleShow(recordId).then(() => {
        loadPage.value = false;
        displayDialog.value = true;
      });
      break;
    case 'quick-edit':
      actionName.value = action;
      if (contentStore.getDataModel.length === 0) {
        disableActionDialogButton.value = {
          action: action,
          disable: true,
        };
      } else {
        contentStore.handleShow(recordId).then(() => {
          loadPage.value = false;
          displayDialog.value = true;
        });
      }
      break;
    case 'delete':
      actionName.value = action;
      contentStore.handleShow(recordId).then(() => {
        loadPage.value = false;
        displayDialog.value = true;
      });
      break;
    case 'restore':
      actionName.value = action;
      contentStore.handleIndex('restore').then(() => {
        if (
          !checkObject.handleCheckIfObject(contentStore.getAllDeletedRecords) &&
          !checkObject.handleCheckIfArray(contentStore.getAllDeletedRecords.results)
        ) {
          disableActionDialogButton.value = {
            action: action,
            disable: true,
          };
        }
        loadPage.value = false;
        displayDialog.value = true;
      });
      break;
    default:
      break;
  }
}

// Handle action dialog
async function handleActionDialog(action: TDialog): Promise<void> {
  loadPage.value = true;
  switch (action) {
    case 'create':
      contentStore.handleCreate().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'advanced-filters':
      contentStore.handleAdvancedFilter('paginate').then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'upload':
      contentStore.handleUpload().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'download':
      contentStore.handleDownload().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'restore':
      contentStore.handleRestore().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'quick-show':
      displayDialog.value = false;
      loadPage.value = false;
      break;
    case 'quick-edit':
      contentStore.handleUpdate().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'delete':
      contentStore.handleDelete().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'stats':
      contentStore.handleStats().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    default:
      break;
  }
}

// Go to Configure resource
const router = useRouter();

// Handle navigate to page
const handleNavigateToPage = (action: TDialog) => {
  const navigateToRoute = new HandleRoute();
  let actionWords;
  let actionName;
  if (action.includes('-')) {
    actionWords = action.split('-')
    actionName = actionWords[1].charAt(0).toUpperCase() + actionWords[1].slice(1);
    const selectedRecordId = contentStore.getSingleRecord.results[0].id;
      navigateToRoute.handleNavigateToRoute(
      router,
      `AdminManagementContent${actionName}Page`,
      ({ id: selectedRecordId } as unknown) as RouteParamsRaw
    );
  } else {
    actionWords = action;
    actionName = actionWords.charAt(0).toUpperCase() + actionWords.slice(1);
    navigateToRoute.handleNavigateToRoute(
      router,
      `AdminManagementContent${actionName}Page`
    );
  }
};
</script>

<style lang="scss" scoped>
@import 'src/css/pages/admin/management.scss';
</style>
