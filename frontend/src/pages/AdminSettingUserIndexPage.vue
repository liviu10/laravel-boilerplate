<template>
  <q-page class="admin admin--page">
    <page-title :page-title="t(`${userStore.getTranslationString}.title`)" />

    <page-description
      :page-description="t(`${userStore.getTranslationString}.page_description`)"
    />

    <div class="admin-section admin-section--container">
      <grid-table
        :columns="userStore.getColumns"
        :is-stats-active="false"
        :is-upload-active="false"
        :search-resource="userStore.getSearchResourceModel"
        :resource="userStore.getResourceName"
        :rows="userStore.getAllRecords.results?.data || []"
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
          :data-model="userStore.getDataModel"
          :resource="userStore.getResourceName"
          :translation-string="userStore.getTranslationString"
        />

        <card-advanced-filter
          v-if="actionName === 'advanced-filters'"
          action-name="advanced-filters"
          :data-model="userStore.getFilterModel"
          :resource="userStore.getResourceName"
          :translation-string="userStore.getTranslationString"
        />

        <card-upload
          v-if="actionName === 'upload'"
          action-name="upload"
          :data-model="userStore.getUploadModel"
          :resource="userStore.getResourceName"
          :translation-string="userStore.getTranslationString"
        />

        <card-download
          v-if="actionName === 'download'"
          action-name="download"
          :data-model="userStore.getDownloadModel"
          :resource="userStore.getResourceName"
          :translation-string="userStore.getTranslationString"
        />

        <card-restore
          v-if="actionName === 'restore'"
          action-name="restore"
          :record-details="userStore.getAllDeletedRecords"
          :resource="userStore.getResourceName"
          :translation-string="userStore.getTranslationString"
        />

        <card-quick-show
          v-if="actionName === 'quick-show'"
          action-name="quick-show"
          :record-details="userStore.getSingleRecord"
          :resource="userStore.getResourceName"
          :translation-string="userStore.getTranslationString"
        />

        <card-quick-edit
          v-if="actionName === 'quick-edit'"
          action-name="quick-edit"
          :data-model="userStore.getDataModel"
          :resource="userStore.getResourceName"
          :translation-string="userStore.getTranslationString"
        >
          <template v-slot:record-details>
            <card-quick-show
              action-name="quick-show"
              :record-details="userStore.getSingleRecord"
              :resource="userStore.getResourceName"
              :translation-string="userStore.getTranslationString"
            />
          </template>
        </card-quick-edit>

        <card-delete
          v-if="actionName === 'delete'"
          action-name="delete"
          :resource="userStore.getResourceName"
          :translation-string="userStore.getTranslationString"
        >
          <template v-slot:record-details>
            <management-card-quick-show
              action-name="quick-show"
              :record-details="userStore.getSingleRecord"
              :resource="userStore.getResourceName"
              :translation-string="userStore.getTranslationString"
            />
          </template>
        </card-delete>

        <card-stats v-if="actionName === 'stats'" action-name="stats" />
      </template>
    </dialog-card>

    <page-loading :visible="userStore.loadPage" />
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
import { ISingleRecord } from 'src/interfaces/UserInterface';
import PageTitle from 'src/components/PageTitle.vue';
import PageDescription from 'src/components/PageDescription.vue';
import GridTable from 'src/components/GridTable.vue';
import DialogCard from 'src/components/DialogCard.vue';
import CardCreate from 'src/components/CardCreate.vue';
import CardAdvancedFilter from 'src/components/CardAdvancedFilter.vue';
import CardUpload from 'src/components/CardUpload.vue';
import CardDownload from 'src/components/CardDownload.vue';
import CardRestore from 'src/components/CardRestore.vue';
import CardQuickShow from 'src/components/CardQuickShow.vue';
import CardQuickEdit from 'src/components/CardQuickEdit.vue';
import CardDelete from 'src/components/CardDelete.vue';
import CardStats from 'src/components/CardStats.vue';
import PageLoading from 'src/components/PageLoading.vue';

// Import Pinia's related utilities
import { useUserStore } from 'src/stores/settings/users';

// Instantiate the pinia store
const userStore = useUserStore();

// Defined the translation variable
const { t } = useI18n({});

// Get all records
userStore.handleIndex('paginate');

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
  switch (action) {
    case 'create':
      actionName.value = action;
      displayDialog.value = true;
      if (userStore.getFilterModel.length === 0) {
        disableActionDialogButton.value = {
          action: action,
          disable: true,
        };
      }
      break;
    case 'advanced-filters':
      actionName.value = action;
      displayDialog.value = true;
      if (userStore.getFilterModel.length === 0) {
        disableActionDialogButton.value = {
          action: action,
          disable: true,
        };
      }
      break;
    case 'upload':
      actionName.value = action;
      displayDialog.value = true;
      if (userStore.getUploadModel.length === 0) {
        disableActionDialogButton.value = {
          action: action,
          disable: true,
        };
      }
      break;
    case 'download':
      actionName.value = action;
      displayDialog.value = true;
      if (userStore.getDownloadModel.length === 0) {
        disableActionDialogButton.value = {
          action: action,
          disable: true,
        };
      }
      break;
    case 'stats':
      actionName.value = action;
      displayDialog.value = true;
      break;
    case 'quick-show':
      actionName.value = action;
      userStore.handleShow(recordId).then(() => {
        displayDialog.value = true;
      });
      break;
    case 'quick-edit':
      actionName.value = action;
      if (userStore.getDataModel.length === 0) {
        disableActionDialogButton.value = {
          action: action,
          disable: true,
        };
      } else {
        userStore.handleShow(recordId).then(() => {
          displayDialog.value = true;
        });
      }
      break;
    case 'delete':
      actionName.value = action;
      userStore.handleShow(recordId).then(() => {
        displayDialog.value = true;
      });
      break;
    case 'restore':
      actionName.value = action;
      userStore.handleIndex('restore').then(() => {
        if (
          !checkObject.handleCheckIfObject(userStore.getAllDeletedRecords) &&
          !checkObject.handleCheckIfArray(userStore.getAllDeletedRecords.results)
        ) {
          disableActionDialogButton.value = {
            action: action,
            disable: true,
          };
        }
        displayDialog.value = true;
      });
      break;
    default:
      break;
  }
}

// Handle action dialog
async function handleActionDialog(action: TDialog): Promise<void> {
  switch (action) {
    case 'create':
      userStore.handleCreate().then(() => {
        displayDialog.value = false;
      });
      break;
    case 'advanced-filters':
      userStore.handleAdvancedFilter('paginate').then(() => {
        displayDialog.value = false;
      });
      break;
    case 'upload':
      userStore.handleUpload().then(() => {
        displayDialog.value = false;
      });
      break;
    case 'download':
      userStore.handleDownload().then(() => {
        displayDialog.value = false;
      });
      break;
    case 'restore':
      userStore.handleRestore().then(() => {
        displayDialog.value = false;
      });
      break;
    case 'quick-show':
      displayDialog.value = false;
      break;
    case 'quick-edit':
      userStore.handleUpdate().then(() => {
        displayDialog.value = false;
      });
      break;
    case 'delete':
      userStore.handleDelete().then(() => {
        displayDialog.value = false;
      });
      break;
    case 'stats':
      userStore.handleStats().then(() => {
        displayDialog.value = false;
      });
      break;
    default:
      break;
  }
}

// Handle search the resource
const handleSearchTheResource = () => userStore.handleAdvancedFilter('paginate');

// Go to Configure resource
const router = useRouter();

// Instantiate handle route class
const handleRoute = new HandleRoute();

// Handle navigate to page
const handleNavigateToPage = (action: TDialog) => {
  const selectedRecord: ISingleRecord = userStore.getSingleRecord;
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
