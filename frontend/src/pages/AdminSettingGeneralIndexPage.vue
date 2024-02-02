<template>
  <q-page class="admin admin--page">
    <page-title :page-title="t(`${generalStore.getTranslationString}.title`)" />

    <page-description
      :page-description="t(`${generalStore.getTranslationString}.page_description`)"
    />

    <div class="admin-section admin-section--container">
      <grid-table
        :columns="generalStore.getColumns"
        :is-stats-active="false"
        :search-resource="generalStore.getSearchResourceModel"
        :resource="generalStore.getResourceName"
        :rows="generalStore.getAllRecords.results?.data || []"
        @handle-open-dialog="handleOpenDialog"
        @handle-search-the-resource="handleSearchTheResource"
      />
    </div>

    <dialog-card
      v-if="displayDialog"
      :action-name="actionName"
      :display-dialog="displayDialog"
      :disable-action-dialog-button="disableActionDialogButton"
      :hide-go-to-show-page="true"
      :hide-go-to-edit-page="true"
      @handle-close-dialog="() => (displayDialog = false)"
      @handle-action-dialog="handleActionDialog"
      @handle-navigate-to-page="handleNavigateToPage"
    >
      <template v-slot:dialog-details>
        <card-create
          v-if="actionName === 'create'"
          action-name="create"
          :data-model="generalStore.getDataModel"
          :resource="generalStore.getResourceName"
          :translation-string="generalStore.getTranslationString"
        />

        <card-advanced-filter
          v-if="actionName === 'advanced-filters'"
          action-name="advanced-filters"
          :data-model="generalStore.getFilterModel"
          :resource="generalStore.getResourceName"
          :translation-string="generalStore.getTranslationString"
        />

        <card-upload
          v-if="actionName === 'upload'"
          action-name="upload"
          :data-model="generalStore.getUploadModel"
          :resource="generalStore.getResourceName"
          :translation-string="generalStore.getTranslationString"
        />

        <card-download
          v-if="actionName === 'download'"
          action-name="download"
          :data-model="generalStore.getDownloadModel"
          :resource="generalStore.getResourceName"
          :translation-string="generalStore.getTranslationString"
        />

        <card-restore
          v-if="actionName === 'restore'"
          action-name="restore"
          :record-details="generalStore.getAllDeletedRecords"
          :resource="generalStore.getResourceName"
          :translation-string="generalStore.getTranslationString"
        />

        <card-quick-show
          v-if="actionName === 'quick-show'"
          action-name="quick-show"
          :record-details="generalStore.getSingleRecord"
          :resource="generalStore.getResourceName"
          :translation-string="generalStore.getTranslationString"
        />

        <card-quick-edit
          v-if="actionName === 'quick-edit'"
          action-name="quick-edit"
          :data-model="generalStore.getDataModel"
          :resource="generalStore.getResourceName"
          :translation-string="generalStore.getTranslationString"
        >
          <template v-slot:record-details>
            <card-quick-show
              action-name="quick-show"
              :record-details="generalStore.getSingleRecord"
              :resource="generalStore.getResourceName"
              :translation-string="generalStore.getTranslationString"
            />
          </template>
        </card-quick-edit>

        <card-delete
          v-if="actionName === 'delete'"
          action-name="delete"
          :resource="generalStore.getResourceName"
          :translation-string="generalStore.getTranslationString"
        >
          <template v-slot:record-details>
            <card-quick-show
              action-name="quick-show"
              :record-details="generalStore.getSingleRecord"
              :resource="generalStore.getResourceName"
              :translation-string="generalStore.getTranslationString"
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
import { ISingleRecord } from 'src/interfaces/GeneralInterface';
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
import { useGeneralStore } from 'src/stores/settings/general';

// Instantiate the pinia store
const generalStore = useGeneralStore();

// Defined the translation variable
const { t } = useI18n({});

// Load page
const loadPage = ref(false);

// Get all records
generalStore.handleIndex('paginate');

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
      if (generalStore.getFilterModel.length === 0) {
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
      if (generalStore.getFilterModel.length === 0) {
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
      if (generalStore.getUploadModel.length === 0) {
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
      if (generalStore.getDownloadModel.length === 0) {
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
      generalStore.handleShow(recordId).then(() => {
        loadPage.value = false;
        displayDialog.value = true;
      });
      break;
    case 'quick-edit':
      actionName.value = action;
      if (generalStore.getDataModel.length === 0) {
        disableActionDialogButton.value = {
          action: action,
          disable: true,
        };
      } else {
        generalStore.handleShow(recordId).then(() => {
          loadPage.value = false;
          displayDialog.value = true;
        });
      }
      break;
    case 'delete':
      actionName.value = action;
      generalStore.handleShow(recordId).then(() => {
        loadPage.value = false;
        displayDialog.value = true;
      });
      break;
    case 'restore':
      actionName.value = action;
      generalStore.handleIndex('restore').then(() => {
        if (
          !checkObject.handleCheckIfObject(generalStore.getAllDeletedRecords) &&
          !checkObject.handleCheckIfArray(generalStore.getAllDeletedRecords.results)
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
      generalStore.handleCreate().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'advanced-filters':
      generalStore.handleAdvancedFilter('paginate').then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'upload':
      generalStore.handleUpload().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'download':
      generalStore.handleDownload().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'restore':
      generalStore.handleRestore().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'quick-show':
      displayDialog.value = false;
      loadPage.value = false;
      break;
    case 'quick-edit':
      generalStore.handleUpdate().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'delete':
      generalStore.handleDelete().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'stats':
      generalStore.handleStats().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    default:
      break;
  }
}

// Handle search the resource
const handleSearchTheResource = () => generalStore.handleAdvancedFilter('paginate');

// Go to Configure resource
const router = useRouter();

// Instantiate handle route class
const handleRoute = new HandleRoute();

// Handle navigate to page
const handleNavigateToPage = (action: TDialog) => {
  const selectedRecord: ISingleRecord = generalStore.getSingleRecord;
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
