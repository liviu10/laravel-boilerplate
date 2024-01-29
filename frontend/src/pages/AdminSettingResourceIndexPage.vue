<template>
  <q-page class="admin admin--page">
    <page-title
      :page-title="t(`${resourceStore.getTranslationString}.title`)"
    />

    <page-description
      :page-description="
        t(`${resourceStore.getTranslationString}.page_description`)
      "
    />

    <div class="admin-section admin-section--container">
      <grid-table
        :columns="resourceStore.getColumns"
        :is-stats-active="false"
        :search-resource="resourceStore.getSearchResourceModel"
        :resource="resourceStore.getResourceName"
        :rows="resourceStore.getAllRecords.results?.data || []"
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
          :data-model="resourceStore.getDataModel"
          :resource="resourceStore.getResourceName"
          :translation-string="resourceStore.getTranslationString"
        />

        <card-advanced-filter
          v-if="actionName === 'advanced-filters'"
          action-name="advanced-filters"
          :data-model="resourceStore.getFilterModel"
          :resource="resourceStore.getResourceName"
          :translation-string="resourceStore.getTranslationString"
        />

        <card-upload
          v-if="actionName === 'upload'"
          action-name="upload"
          :data-model="resourceStore.getUploadModel"
          :resource="resourceStore.getResourceName"
          :translation-string="resourceStore.getTranslationString"
        />

        <card-download
          v-if="actionName === 'download'"
          action-name="download"
          :data-model="resourceStore.getDownloadModel"
          :resource="resourceStore.getResourceName"
          :translation-string="resourceStore.getTranslationString"
        />

        <card-restore
          v-if="actionName === 'restore'"
          action-name="restore"
          :record-details="resourceStore.getAllDeletedRecords"
          :resource="resourceStore.getResourceName"
          :translation-string="resourceStore.getTranslationString"
        />

        <management-card-quick-show
          v-if="actionName === 'quick-show'"
          action-name="quick-show"
          :record-details="resourceStore.getSingleRecord"
          :resource="resourceStore.getResourceName"
          :translation-string="resourceStore.getTranslationString"
        />

        <management-card-quick-edit
          v-if="actionName === 'quick-edit'"
          action-name="quick-edit"
          :data-model="resourceStore.getDataModel"
          :resource="resourceStore.getResourceName"
          :translation-string="resourceStore.getTranslationString"
        >
          <template v-slot:record-details>
            <management-card-quick-show
              action-name="quick-show"
              :record-details="resourceStore.getSingleRecord"
              :resource="resourceStore.getResourceName"
              :translation-string="resourceStore.getTranslationString"
            />
          </template>
        </management-card-quick-edit>

        <card-delete
          v-if="actionName === 'delete'"
          action-name="delete"
          :resource="resourceStore.getResourceName"
          :translation-string="resourceStore.getTranslationString"
        >
          <template v-slot:record-details>
            <management-card-quick-show
              action-name="quick-show"
              :record-details="resourceStore.getSingleRecord"
              :resource="resourceStore.getResourceName"
              :translation-string="resourceStore.getTranslationString"
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
import { ISingleRecord } from 'src/interfaces/ResourceInterface';
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
import { useResourceStore } from 'src/stores/settings/resources';

// Instantiate the pinia store
const resourceStore = useResourceStore();

// Defined the translation variable
const { t } = useI18n({});

// Load page
const loadPage = ref(false);

// Get all records
resourceStore.handleIndex('paginate');

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
      if (resourceStore.getDataModel.length === 0) {
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
      if (resourceStore.getFilterModel.length === 0) {
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
      if (resourceStore.getUploadModel.length === 0) {
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
      if (resourceStore.getDownloadModel.length === 0) {
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
      resourceStore.handleShow(recordId).then(() => {
        loadPage.value = false;
        displayDialog.value = true;
      });
      break;
    case 'quick-edit':
      actionName.value = action;
      if (resourceStore.getDataModel.length === 0) {
        disableActionDialogButton.value = {
          action: action,
          disable: true,
        };
      } else {
        resourceStore.handleShow(recordId).then(() => {
          loadPage.value = false;
          displayDialog.value = true;
        });
      }
      break;
    case 'delete':
      actionName.value = action;
      resourceStore.handleShow(recordId).then(() => {
        loadPage.value = false;
        displayDialog.value = true;
      });
      break;
    case 'restore':
      actionName.value = action;
      resourceStore.handleIndex('restore').then(() => {
        if (
          !checkObject.handleCheckIfObject(
            resourceStore.getAllDeletedRecords
          ) &&
          !checkObject.handleCheckIfArray(
            resourceStore.getAllDeletedRecords.results
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
    case 'advanced-filters':
      resourceStore.handleAdvancedFilter('paginate').then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'upload':
      resourceStore.handleUpload().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'download':
      resourceStore.handleDownload().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'restore':
      resourceStore.handleRestore().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'quick-show':
      displayDialog.value = false;
      loadPage.value = false;
      break;
    case 'quick-edit':
      resourceStore.handleUpdate().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'delete':
      resourceStore.handleDelete().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    case 'stats':
      resourceStore.handleStats().then(() => {
        displayDialog.value = false;
        loadPage.value = false;
      });
      break;
    default:
      break;
  }
}

// Handle search the resource
const handleSearchTheResource = () => resourceStore.handleAdvancedFilter('paginate')

// Go to Configure resource
const router = useRouter();

// Instantiate handle route class
const handleRoute = new HandleRoute();

// Handle navigate to page
const handleNavigateToPage = (action: TDialog) => {
  const selectedRecord: ISingleRecord = resourceStore.getSingleRecord
  const routeParams = selectedRecord &&
    selectedRecord.hasOwnProperty('results') &&
    selectedRecord.results.length > 0
      ? ({ id: selectedRecord.results[0].id } as unknown) as RouteParamsRaw
      : undefined

  handleRoute.handleNavigateToRoute(router, action, routeParams)
};
</script>

<style lang="scss" scoped>
@import 'src/css/pages/admin/settings.scss';
</style>
