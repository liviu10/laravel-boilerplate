<template>
  <q-page class="admin admin--page">
    <page-title
      :page-title="t(`${configurationResourceStore.getTranslationString}.title`)"
    />

    <page-description
      :page-description="
        t(`${configurationResourceStore.getTranslationString}.page_description`)
      "
    />

    <div class="admin-section admin-section--container">
      <grid-table
        :columns="configurationResourceStore.getColumns"
        :is-stats-active="false"
        :search-resource="configurationResourceStore.getSearchResourceModel"
        :resource="configurationResourceStore.getResourceName"
        :rows="configurationResourceStore.getAllRecords.results?.data || []"
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
        <card-advanced-filter
          v-if="actionName === 'advanced-filters'"
          action-name="advanced-filters"
          :data-model="configurationResourceStore.getFilterModel"
          :resource="configurationResourceStore.getResourceName"
          :translation-string="configurationResourceStore.getTranslationString"
        />

        <card-upload
          v-if="actionName === 'upload'"
          action-name="upload"
          :data-model="configurationResourceStore.getUploadModel"
          :resource="configurationResourceStore.getResourceName"
          :translation-string="configurationResourceStore.getTranslationString"
        />

        <card-download
          v-if="actionName === 'download'"
          action-name="download"
          :data-model="configurationResourceStore.getDownloadModel"
          :resource="configurationResourceStore.getResourceName"
          :translation-string="configurationResourceStore.getTranslationString"
        />

        <card-restore
          v-if="actionName === 'restore'"
          action-name="restore"
          :record-details="configurationResourceStore.getAllDeletedRecords"
          :resource="configurationResourceStore.getResourceName"
          :translation-string="configurationResourceStore.getTranslationString"
        />

        <card-quick-show
          v-if="actionName === 'quick-show'"
          action-name="quick-show"
          :record-details="configurationResourceStore.getSingleRecord"
          :resource="configurationResourceStore.getResourceName"
          :translation-string="configurationResourceStore.getTranslationString"
        />

        <card-quick-edit
          v-if="actionName === 'quick-edit'"
          action-name="quick-edit"
          :data-model="configurationResourceStore.getDataModel"
          :resource="configurationResourceStore.getResourceName"
          :translation-string="configurationResourceStore.getTranslationString"
        >
          <template v-slot:record-details>
            <card-quick-show
              action-name="quick-show"
              :record-details="configurationResourceStore.getSingleRecord"
              :resource="configurationResourceStore.getResourceName"
              :translation-string="configurationResourceStore.getTranslationString"
            />
          </template>
        </card-quick-edit>

        <card-delete
          v-if="actionName === 'delete'"
          action-name="delete"
          :resource="configurationResourceStore.getResourceName"
          :translation-string="configurationResourceStore.getTranslationString"
        >
          <template v-slot:record-details>
            <card-quick-show
              action-name="quick-show"
              :record-details="configurationResourceStore.getSingleRecord"
              :resource="configurationResourceStore.getResourceName"
              :translation-string="configurationResourceStore.getTranslationString"
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
import { ISingleRecord } from 'src/interfaces/ConfigurationResourceInterface';
import PageTitle from 'src/components/PageTitle.vue';
import PageDescription from 'src/components/PageDescription.vue';
import GridTable from 'src/components/GridTable.vue';
import DialogCard from 'src/components/DialogCard.vue';
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
import { useConfigurationResourceStore } from 'src/stores/settings/configuration_resources';

// Instantiate the pinia store
const configurationResourceStore = useConfigurationResourceStore();

// Defined the translation variable
const { t } = useI18n({});

// Load page
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

// Handle search the resource
const handleSearchTheResource = () => configurationResourceStore.handleAdvancedFilter('paginate')

// Go to Configure resource
const router = useRouter();

// Instantiate handle route class
const handleRoute = new HandleRoute();

// Handle navigate to page
const handleNavigateToPage = (action: TDialog) => {
  const selectedRecord: ISingleRecord = configurationResourceStore.getSingleRecord
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
