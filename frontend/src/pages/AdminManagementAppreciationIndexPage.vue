<template>
  <q-page class="admin admin--page">
    <page-title :page-title="t(`${appreciationStore.getTranslationString}.title`)" />

    <page-description
      :page-description="t(`${appreciationStore.getTranslationString}.page_description`)"
    />

    <div class="admin-section admin-section--container">
      <grid-table
        :columns="appreciationStore.getColumns"
        :resource="appreciationStore.getResourceName"
        :rows="appreciationStore.getAllRecords.results?.data || []"
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
        <card-create
          v-if="actionName === 'create'"
          action-name="create"
          :data-model="appreciationStore.getDataModel"
          :resource="appreciationStore.getResourceName"
          :translation-string="appreciationStore.getTranslationString"
        />

        <card-advanced-filter
          v-if="actionName === 'advanced-filters'"
          action-name="advanced-filters"
          :data-model="appreciationStore.getFilterModel"
          :resource="appreciationStore.getResourceName"
          :translation-string="appreciationStore.getTranslationString"
        />

        <card-upload
          v-if="actionName === 'upload'"
          action-name="upload"
          :data-model="appreciationStore.getUploadModel"
          :resource="appreciationStore.getResourceName"
          :translation-string="appreciationStore.getTranslationString"
        />

        <card-download
          v-if="actionName === 'download'"
          action-name="download"
          :data-model="appreciationStore.getDownloadModel"
          :resource="appreciationStore.getResourceName"
          :translation-string="appreciationStore.getTranslationString"
        />

        <card-restore
          v-if="actionName === 'restore'"
          action-name="restore"
          :record-details="appreciationStore.getAllDeletedRecords"
          :resource="appreciationStore.getResourceName"
          :translation-string="appreciationStore.getTranslationString"
        />

        <management-card-quick-show
          v-if="actionName === 'quick-show'"
          action-name="quick-show"
          :record-details="appreciationStore.getSingleRecord"
          :resource="appreciationStore.getResourceName"
          :translation-string="appreciationStore.getTranslationString"
        />

        <management-card-quick-edit
          v-if="actionName === 'quick-edit'"
          action-name="quick-edit"
          :data-model="appreciationStore.getDataModel"
          :resource="appreciationStore.getResourceName"
          :translation-string="appreciationStore.getTranslationString"
        >
          <template v-slot:record-details>
            <management-card-quick-show
              action-name="quick-show"
              :record-details="appreciationStore.getSingleRecord"
              :resource="appreciationStore.getResourceName"
              :translation-string="appreciationStore.getTranslationString"
            />
          </template>
        </management-card-quick-edit>

        <card-delete
          v-if="actionName === 'delete'"
          action-name="delete"
          :resource="appreciationStore.getResourceName"
          :translation-string="appreciationStore.getTranslationString"
        >
          <template v-slot:record-details>
            <management-card-quick-show
              action-name="quick-show"
              :record-details="appreciationStore.getSingleRecord"
              :resource="appreciationStore.getResourceName"
              :translation-string="appreciationStore.getTranslationString"
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
import { TDialog } from 'src/interfaces/BaseInterface';
import { HandleObject } from 'src/utilities/HandleObject';
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
import { useAppreciationStore } from 'src/stores/management/appreciations';

// Instantiate the pinia store
const appreciationStore = useAppreciationStore();

// Defined the translation variable
const { t } = useI18n({});

// Load page
const loadPage = ref(false);

// Get all records
appreciationStore.handleIndex('paginate');

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
      if (appreciationStore.getDataModel.length === 0) {
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
      if (appreciationStore.getFilterModel.length === 0) {
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
      if (appreciationStore.getUploadModel.length === 0) {
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
      if (appreciationStore.getDownloadModel.length === 0) {
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
      appreciationStore.handleShow(recordId).then(() => {
        loadPage.value = false;
        displayDialog.value = true;
        hideGoToShowPage.value = true;
      });
      break;
    case 'quick-edit':
      actionName.value = action;
      if (appreciationStore.getDataModel.length === 0) {
        disableActionDialogButton.value = {
          action: action,
          disable: true,
        };
      } else {
        appreciationStore.handleShow(recordId).then(() => {
          loadPage.value = false;
          displayDialog.value = true;
          hideGoToEditPage.value = true;
        });
      }
      break;
    case 'delete':
      actionName.value = action;
      appreciationStore.handleShow(recordId).then(() => {
        loadPage.value = false;
        displayDialog.value = true;
      });
      break;
    case 'restore':
      actionName.value = action;
      appreciationStore.handleIndex('restore').then(() => {
        if (
          !checkObject.handleCheckIfObject(appreciationStore.getAllDeletedRecords) &&
          !checkObject.handleCheckIfArray(appreciationStore.getAllDeletedRecords.results)
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
      appreciationStore.handleCreate().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'advanced-filters':
      appreciationStore.handleAdvancedFilter('paginate').then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'upload':
      appreciationStore.handleUpload().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'download':
      appreciationStore.handleDownload().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'restore':
      appreciationStore.handleRestore().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'quick-show':
      displayDialog.value = false;
      loadPage.value = false;
      break;
    case 'quick-edit':
      appreciationStore.handleUpdate().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'delete':
      appreciationStore.handleDelete().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'stats':
      appreciationStore.handleStats().then(() => {
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
  const selectedRecordId = appreciationStore.getSingleRecord.results[0].id;
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
