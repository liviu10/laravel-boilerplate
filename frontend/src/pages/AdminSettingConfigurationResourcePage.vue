<template>
  <q-page class="admin admin--page">
    <page-title :page-title="t('admin.settings.configuration_resource.title')" />

    <page-description
      :page-description="t('admin.settings.configuration_resource.page_description')"
    />

    <div class="admin-section admin-section--container">
      <basic-table
        :columns="configurationResourceStore.getColumns"
        :resource="configurationResourceStore.resourceName"
        :rows="configurationResourceStore.getAllRecords.results?.data || []"
        @handle-open-dialog="handleOpenDialog"
      />
    </div>

    <page-loading :visible="loadPage" />
  </q-page>
</template>

<script setup lang="ts">
// Import vue related utilities
import { useI18n } from 'vue-i18n';
import { Ref, ref } from 'vue';
import { RouteParamsRaw, useRouter } from 'vue-router';

// Import library utilities, interfaces and components
import { HandleObject } from 'src/utilities/HandleObject';
import { HandleRoute } from 'src/utilities/HandleRoute';
import { TDialog } from 'src/interfaces/BaseInterface';
import PageTitle from 'src/components/PageTitle.vue';
import PageDescription from 'src/components/PageDescription.vue';
import PageLoading from 'src/components/PageLoading.vue';
import BasicTable from 'src/components/BasicTable.vue';

// Import Pinia's related utilities
import { useConfigurationResourceStore } from 'src/stores/settings/configuration_resources';

// Instantiate the pinia store
const configurationResourceStore = useConfigurationResourceStore();

// Defined the translation variable
const { t } = useI18n({});

const loadPage = ref(false);

// Get all records
configurationResourceStore.handleIndex('paginate');

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
      if (configurationResourceStore.getFilterModel.length === 0) {
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
      if (configurationResourceStore.getUploadModel.length === 0) {
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
      if (configurationResourceStore.getDownloadModel.length === 0) {
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
      configurationResourceStore.handleShow(recordId).then(() => {
        loadPage.value = false;
        displayDialog.value = true;
      });
      break;
    case 'quick-edit':
      actionName.value = action;
      if (configurationResourceStore.getDataModel.length === 0) {
        disableActionDialogButton.value = {
          action: action,
          disable: true,
        };
      } else {
        configurationResourceStore.handleShow(recordId).then(() => {
          loadPage.value = false;
          displayDialog.value = true;
        });
      }
      break;
    case 'delete':
      actionName.value = action;
      configurationResourceStore.handleShow(recordId).then(() => {
        loadPage.value = false;
        displayDialog.value = true;
      });
      break;
    case 'restore':
      actionName.value = action;
      configurationResourceStore.handleIndex('restore').then(() => {
        if (
          !checkObject.handleCheckIfObject(
            configurationResourceStore.getAllDeletedRecords
          ) &&
          !checkObject.handleCheckIfArray(
            configurationResourceStore.getAllDeletedRecords.results
          )
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
      configurationResourceStore.handleCreate().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'advanced-filters':
      configurationResourceStore.handleAdvancedFilter('paginate').then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'upload':
      configurationResourceStore.handleUpload().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'download':
      configurationResourceStore.handleDownload().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'restore':
      configurationResourceStore.handleRestore().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'quick-show':
      displayDialog.value = false;
      loadPage.value = false;
      break;
    case 'quick-edit':
      configurationResourceStore.handleUpdate().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'delete':
      configurationResourceStore.handleDelete().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'stats':
      configurationResourceStore.handleStats().then(() => {
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
    actionWords = action.split('-');
    actionName = actionWords[1].charAt(0).toUpperCase() + actionWords[1].slice(1);
    const selectedRecordId = configurationResourceStore.getSingleRecord.results[0].id;
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

<style lang="scss" scoped></style>
