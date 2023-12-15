<template>
  <q-page class="admin admin--page">
    <page-title :page-title="t('admin.management.media.title')" />

    <page-description :page-description="t('admin.management.media.page_description')" />

    <div class="admin-section admin-section--container">
      <grid-table
        :columns="mediaStore.getColumns"
        :resource="mediaStore.resourceName"
        :rows="mediaStore.getAllRecords.results?.data || []"
        @handle-open-dialog="handleOpenDialog"
      />
    </div>

    <dialog-card
      v-if="displayDialog"
      :action-name="actionName"
      :display-dialog="displayDialog"
      :disable-action-dialog-button="disableActionDialogButton"
      :hide-go-to-show-page="hideGoToShowPage"
      :hide-go-to-edit-page="hideGoToEditPage"
      @handle-close-dialog="() => (displayDialog = false)"
      @handle-action-dialog="handleActionDialog"
      @handle-navigate-to-page="handleNavigateToPage"
    >
      <template v-slot:dialog-details>
        <management-card-create
          v-if="actionName === 'create'"
          action-name="create"
          :data-model="mediaStore.getDataModel"
          :resource="mediaStore.resourceName"
        />

        <management-card-advanced-filter
          v-if="actionName === 'advanced-filters'"
          action-name="advanced-filters"
          :data-model="mediaStore.getFilterModel"
          :resource="mediaStore.resourceName"
        />

        <management-card-upload
          v-if="actionName === 'upload'"
          action-name="upload"
          :data-model="mediaStore.getUploadModel"
          :resource="mediaStore.resourceName"
        />

        <management-card-download
          v-if="actionName === 'download'"
          action-name="download"
          :data-model="mediaStore.getDownloadModel"
          :resource="mediaStore.resourceName"
        />

        <management-card-restore
          v-if="actionName === 'restore'"
          action-name="restore"
          :record-details="mediaStore.getAllDeletedRecords"
          :resource="mediaStore.resourceName"
        />

        <management-card-quick-show
          v-if="actionName === 'quick-show'"
          action-name="quick-show"
          :record-details="mediaStore.getSingleRecord"
          :resource="mediaStore.resourceName"
        />

        <management-card-quick-edit
          v-if="actionName === 'quick-edit'"
          action-name="quick-edit"
          :data-model="mediaStore.getDataModel"
          :resource="mediaStore.resourceName"
        >
          <template v-slot:record-details>
            <management-card-quick-show
              action-name="quick-show"
              :record-details="mediaStore.getSingleRecord"
              :resource="mediaStore.resourceName"
            />
          </template>
        </management-card-quick-edit>

        <management-card-delete
          v-if="actionName === 'delete'"
          action-name="delete"
          :resource="mediaStore.resourceName"
        >
          <template v-slot:record-details>
            <management-card-quick-show
              action-name="quick-show"
              :record-details="mediaStore.getSingleRecord"
              :resource="mediaStore.resourceName"
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
import GridTable from 'src/components/GridTable.vue';
import DialogCard from 'src/components/DialogCard.vue';
import ManagementCardCreate from 'src/components/ManagementCardCreate.vue';
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
import { useMediaStore } from 'src/stores/management/media';

// Instantiate the pinia store
const mediaStore = useMediaStore();

// Defined the translation variable
const { t } = useI18n({});

// Load page
const loadPage = ref(false);

// Get all records
mediaStore.handleIndex('paginate');

// Display the action name & dialog
const actionName: Ref<TDialog | undefined> = ref(undefined);
const displayDialog = ref(false);
const disableActionDialogButton: Ref<{
  action: TDialog | undefined;
  disable: boolean;
}> = ref({ action: undefined, disable: false });
const hideGoToShowPage = ref(false);
const hideGoToEditPage = ref(false);

// Handle open dialog
async function handleOpenDialog(action: TDialog, recordId?: number): Promise<void> {
  const checkObject = new HandleObject();
  loadPage.value = true;
  switch (action) {
    case 'create':
      actionName.value = action;
      loadPage.value = false;
      displayDialog.value = true;
      if (mediaStore.getDataModel.length === 0) {
        disableActionDialogButton.value = {
          action: action,
          disable: true,
        };
      }
      break;
    case 'advanced-filters':
      actionName.value = action;
      loadPage.value = false;
      displayDialog.value = true;
      if (mediaStore.getFilterModel.length === 0) {
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
      if (mediaStore.getUploadModel.length === 0) {
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
      if (mediaStore.getDownloadModel.length === 0) {
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
      mediaStore.handleShow(recordId).then(() => {
        loadPage.value = false;
        displayDialog.value = true;
        hideGoToShowPage.value = true;
      });
      break;
    case 'quick-edit':
      actionName.value = action;
      if (mediaStore.getDataModel.length === 0) {
        disableActionDialogButton.value = {
          action: action,
          disable: true,
        };
      } else {
        mediaStore.handleShow(recordId).then(() => {
          loadPage.value = false;
          displayDialog.value = true;
          hideGoToEditPage.value = true;
        });
      }
      break;
    case 'delete':
      actionName.value = action;
      mediaStore.handleShow(recordId).then(() => {
        loadPage.value = false;
        displayDialog.value = true;
      });
      break;
    case 'restore':
      actionName.value = action;
      mediaStore.handleIndex('restore').then(() => {
        if (
          !checkObject.handleCheckIfObject(mediaStore.getAllDeletedRecords) &&
          !checkObject.handleCheckIfArray(mediaStore.getAllDeletedRecords.results)
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
      mediaStore.handleCreate().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'advanced-filters':
      mediaStore.handleAdvancedFilter('paginate').then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'upload':
      mediaStore.handleUpload().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'download':
      mediaStore.handleDownload().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'restore':
      mediaStore.handleRestore().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'quick-show':
      displayDialog.value = false;
      loadPage.value = false;
      break;
    case 'quick-edit':
      mediaStore.handleUpdate().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'delete':
      mediaStore.handleDelete().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'stats':
      mediaStore.handleStats().then(() => {
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
  const actionWords = action.split('-');
  if (actionWords.length >= 2) {
    actionWords[1] = actionWords[1].charAt(0).toUpperCase() + actionWords[1].slice(1);
  }
  const actionName = actionWords[1];
  const selectedRecordId = mediaStore.getSingleRecord.results[0].id;
  navigateToRoute.handleNavigateToRoute(
    router,
    `AdminManagementContent${actionName}Page`,
    ({ id: selectedRecordId } as unknown) as RouteParamsRaw
  );
};
</script>

<style lang="scss" scoped>
@import 'src/css/pages/admin/management.scss';
</style>
