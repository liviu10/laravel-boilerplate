<template>
  <q-page class="admin admin--page">
    <page-title :page-title="t(`${notificationStore.getTranslationString}.title`)" />

    <page-description
      :page-description="t(`${notificationStore.getTranslationString}.page_description`)"
    />

    <div class="admin-section admin-section--container">
      <grid-table
        :columns="notificationStore.getColumns"
        :is-stats-active="false"
        :search-resource="notificationStore.getSearchResourceModel"
        :resource="notificationStore.getResourceName"
        :rows="notificationStore.getAllRecords.results?.data || []"
        @handle-open-dialog="handleOpenDialog"
        @handle-search-the-resource="handleSearchTheResource"
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
        <card-create
          v-if="actionName === 'create'"
          action-name="create"
          :data-model="notificationStore.getDataModel"
          :resource="notificationStore.getResourceName"
          :translation-string="notificationStore.getTranslationString"
        />

        <card-advanced-filter
          v-if="actionName === 'advanced-filters'"
          action-name="advanced-filters"
          :data-model="notificationStore.getFilterModel"
          :resource="notificationStore.getResourceName"
          :translation-string="notificationStore.getTranslationString"
        />

        <card-upload
          v-if="actionName === 'upload'"
          action-name="upload"
          :data-model="notificationStore.getUploadModel"
          :resource="notificationStore.getResourceName"
          :translation-string="notificationStore.getTranslationString"
        />

        <card-download
          v-if="actionName === 'download'"
          action-name="download"
          :data-model="notificationStore.getDownloadModel"
          :resource="notificationStore.getResourceName"
          :translation-string="notificationStore.getTranslationString"
        />

        <card-restore
          v-if="actionName === 'restore'"
          action-name="restore"
          :record-details="notificationStore.getAllDeletedRecords"
          :resource="notificationStore.getResourceName"
          :translation-string="notificationStore.getTranslationString"
        />

        <management-card-quick-show
          v-if="actionName === 'quick-show'"
          action-name="quick-show"
          :record-details="notificationStore.getSingleRecord"
          :resource="notificationStore.getResourceName"
          :translation-string="notificationStore.getTranslationString"
        />

        <management-card-quick-edit
          v-if="actionName === 'quick-edit'"
          action-name="quick-edit"
          :data-model="notificationStore.getDataModel"
          :resource="notificationStore.getResourceName"
          :translation-string="notificationStore.getTranslationString"
        >
          <template v-slot:record-details>
            <management-card-quick-show
              action-name="quick-show"
              :record-details="notificationStore.getSingleRecord"
              :resource="notificationStore.getResourceName"
              :translation-string="notificationStore.getTranslationString"
            />
          </template>
        </management-card-quick-edit>

        <card-delete
          v-if="actionName === 'delete'"
          action-name="delete"
          :resource="notificationStore.getResourceName"
          :translation-string="notificationStore.getTranslationString"
        >
          <template v-slot:record-details>
            <management-card-quick-show
              action-name="quick-show"
              :record-details="notificationStore.getSingleRecord"
              :resource="notificationStore.getResourceName"
              :translation-string="notificationStore.getTranslationString"
            />
          </template>
        </card-delete>

        <card-stats v-if="actionName === 'stats'" action-name="stats" />
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
import { HandleObject } from 'src/utilities/HandleObject';
import { TDialog } from 'src/interfaces/BaseInterface';
import { ISingleRecord } from 'src/interfaces/NotificationInterface';
import PageTitle from 'src/components/PageTitle.vue';
import PageDescription from 'src/components/PageDescription.vue';
import GridTable from 'src/components/GridTable.vue';
import DialogCard from 'src/components/DialogCard.vue';
import CardCreate from 'src/components/CardCreate.vue';
import CardAdvancedFilter from 'src/components/CardAdvancedFilter.vue';
import CardUpload from 'src/components/CardUpload.vue';
import CardDownload from 'src/components/CardDownload.vue';
import CardRestore from 'src/components/CardRestore.vue';
import ManagementCardQuickShow from 'src/components/ManagementCardQuickShow.vue';
import ManagementCardQuickEdit from 'src/components/ManagementCardQuickEdit.vue';
import CardDelete from 'src/components/CardDelete.vue';
import CardStats from 'src/components/CardStats.vue';
import PageLoading from 'src/components/PageLoading.vue';

// Import Pinia's related utilities
import { useNotificationStore } from 'src/stores/settings/notifications';

// Instantiate the pinia store
const notificationStore = useNotificationStore();

// Defined the translation variable
const { t } = useI18n({});

// Load page
const loadPage = ref(false);

// Get all records
notificationStore.handleIndex('paginate');

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
      displayDialog.value = true;
      if (notificationStore.getFilterModel.length === 0) {
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
      if (notificationStore.getFilterModel.length === 0) {
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
      if (notificationStore.getUploadModel.length === 0) {
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
      if (notificationStore.getDownloadModel.length === 0) {
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
      notificationStore.handleShow(recordId).then(() => {
        loadPage.value = false;
        displayDialog.value = true;
      });
      break;
    case 'quick-edit':
      actionName.value = action;
      if (notificationStore.getDataModel.length === 0) {
        disableActionDialogButton.value = {
          action: action,
          disable: true,
        };
      } else {
        notificationStore.handleShow(recordId).then(() => {
          loadPage.value = false;
          displayDialog.value = true;
        });
      }
      break;
    case 'delete':
      actionName.value = action;
      notificationStore.handleShow(recordId).then(() => {
        loadPage.value = false;
        displayDialog.value = true;
      });
      break;
    case 'restore':
      actionName.value = action;
      notificationStore.handleIndex('restore').then(() => {
        if (
          !checkObject.handleCheckIfObject(notificationStore.getAllDeletedRecords) &&
          !checkObject.handleCheckIfArray(notificationStore.getAllDeletedRecords.results)
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
      notificationStore.handleCreate().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'advanced-filters':
      notificationStore.handleAdvancedFilter('paginate').then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'upload':
      notificationStore.handleUpload().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'download':
      notificationStore.handleDownload().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'restore':
      notificationStore.handleRestore().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'quick-show':
      displayDialog.value = false;
      loadPage.value = false;
      break;
    case 'quick-edit':
      notificationStore.handleUpdate().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'delete':
      notificationStore.handleDelete().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'stats':
      notificationStore.handleStats().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    default:
      break;
  }
}

// Handle search the resource
const handleSearchTheResource = () => notificationStore.handleAdvancedFilter('paginate');

// Go to Configure resource
const router = useRouter();

// Instantiate handle route class
const handleRoute = new HandleRoute();

// Handle navigate to page
const handleNavigateToPage = (action: TDialog) => {
  const selectedRecord: ISingleRecord = notificationStore.getSingleRecord;
  const routeParams =
    selectedRecord &&
    selectedRecord.hasOwnProperty('results') &&
    selectedRecord.results.length > 0
      ? (({ id: selectedRecord.results[0].id } as unknown) as RouteParamsRaw)
      : undefined;

  handleRoute.handleNavigateToRoute(router, action, routeParams);
};
</script>

<style lang="scss" scoped>
@import 'src/css/pages/admin/settings.scss';
</style>
