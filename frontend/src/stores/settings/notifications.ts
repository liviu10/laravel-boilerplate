// Import vue related utilities
import { defineStore } from 'pinia';
import { api } from 'src/boot/axios';
import { Ref, computed, ref } from 'vue';
import { QTableProps } from 'quasar';

// Import library utilities, interfaces and components
import { HandleApi } from 'src/utilities/HandleApi';
import { HandleRoute } from 'src/utilities/HandleRoute';
import {
  IConfiguration,
  IConfigurationInput,
  IConfigurationColumn,
} from 'src/interfaces/ConfigurationResourceInterface';
import {
  IAllRecords,
  IAllRecordsUnpaginated,
  ISingleRecord,
} from 'src/interfaces/NotificationInterface';
import { TResourceType } from 'src/interfaces/BaseInterface';

// Import Pinia's related utilities
import { useConfigurationResourceStore } from 'src/stores/settings/configuration_resources';
import { useResourceStore } from 'src/stores/settings/resources';

// Instantiate the pinia store
const configurationResourceStore = useConfigurationResourceStore();
const resourceStore = useResourceStore();

const handleRoute = new HandleRoute();

export const useNotificationStore = defineStore(
  'notificationStore',
  () => {
    // Handle API
    const handleApi = new HandleApi();

    // State
    const resourceName: Ref<string> = ref('');
    const resourceEndpoint: Ref<string> = ref('');
    const translationString: Ref<string> = ref('');
    const allRecords: Ref<IAllRecords> = ref({} as IAllRecords);
    const columns: Ref<QTableProps['columns']> = ref([] as QTableProps['columns']);
    const dataModel: Ref<IConfigurationInput[]> = ref([] as IConfigurationInput[]);
    const filterModel: Ref<IConfigurationInput[]> = ref([] as IConfigurationInput[]);
    const uploadModel: Ref<IConfigurationInput[]> = ref([] as IConfigurationInput[]);
    const downloadModel: Ref<IConfigurationInput[]> = ref([] as IConfigurationInput[]);
    const searchResourceModel: Ref<IConfigurationInput[]> = ref([] as IConfigurationInput[]);
    const allDeletedRecords: Ref<IAllRecordsUnpaginated> = ref({} as IAllRecordsUnpaginated);
    const resourceConfiguration: Ref<IConfiguration['results']> = ref([] as IConfiguration['results']);
    const singleRecord: Ref<ISingleRecord> = ref({} as ISingleRecord);

    // Getters
    const getResourceName = computed(() => (resourceName.value = handleRoute.handleResourceNameFromRoute()));
    const getTranslationString = computed(() => (translationString.value = handleRoute.handleTranslationFromRoute()));
    const getAllRecords = computed(() => allRecords.value);
    const getColumns = computed(() => columns.value);
    const getDataModel = computed(() => dataModel.value);
    const getFilterModel = computed(() => filterModel.value);
    const getUploadModel = computed(() => uploadModel.value);
    const getDownloadModel = computed(() => downloadModel.value);
    const getSearchResourceModel = computed(() => searchResourceModel.value);
    const getAllDeletedRecords = computed(() => allDeletedRecords.value);
    const getResourceConfiguration = computed(() => resourceConfiguration.value);
    const getSingleRecord = computed(() => singleRecord.value);

    // Actions
    async function handleIndex(type?: TResourceType) {
      try {
        resourceStore.handleApiEndpoint(window.location.pathname).then(async () => {
          const apiEndpoint = resourceStore.getApiEndpoint
          if (apiEndpoint && Array.isArray(apiEndpoint) && apiEndpoint.length) {
            resourceEndpoint.value = apiEndpoint[0].path
            handleGetConfigurationId(getResourceName.value).then(async () => {
              if (resourceConfiguration.value) {
                await handleGetColumns(resourceConfiguration.value)
                await handleGetInputs(resourceConfiguration.value)
                const response = await api.get(resourceEndpoint.value, {
                  params: {
                    type: type ?? undefined,
                  },
                });
                if (type === 'restore') {
                  if (response.data && response.data.hasOwnProperty('results')) {
                    allDeletedRecords.value = response.data as IAllRecordsUnpaginated;
                  }
                } else {
                  allRecords.value = response.data as IAllRecords;
                }
                console.log('-> handleIndex', allRecords.value);
              } else {
                console.log('-> apiConfiguration does not exist', resourceConfiguration.value);
              }
            })
          } else {
            console.log('-> apiEndpoint does not exist', apiEndpoint);
          }
        })
      } catch (error) {
        console.log('-> catch', error);
      }
    }

    async function handleGetConfigurationId(key: string) {
      try {
        const response = await api.get(`${configurationResourceStore.configurationBaseEndpoint}/resources/get-id`, {
          params: {
            key: key ?? undefined,
          },
        });
        resourceConfiguration.value = response.data.results as IConfiguration['results'];
        console.log('-> handleShow', resourceConfiguration.value);
      } catch (error) {
        console.log('-> catch', error);
      }
    }

    async function handleGetColumns(configurationResourceId: IConfiguration['results']) {
      try {
        const response = await api.get(`${configurationResourceStore.configurationBaseEndpoint}/columns`, {
          params: {
            configuration_resource_id: configurationResourceId[0].id ?? undefined,
          },
        });
        if (response.data && response.data.hasOwnProperty('results')) {
          columns.value = response.data.results as IConfigurationColumn[];
          console.log('-> handleGetColumns', columns.value);
        } else {
          // TODO: What do you do when this does not exist
        }
      } catch (error) {
        console.log('-> catch', error);
      }
    }

    async function handleGetInputs(configurationResourceId: IConfiguration['results']) {
      try {
        const response = await api.get(`${configurationResourceStore.configurationBaseEndpoint}/inputs`, {
          params: {
            configuration_resource_id: configurationResourceId[0].id ?? undefined,
          },
        });
        if (response.data && response.data.hasOwnProperty('results')) {
          const activeInputs = response.data.results.filter(
            (activeInput: { is_active: boolean; }) => activeInput.is_active
          ) as IConfigurationInput[]
          dataModel.value = activeInputs.filter(
            (model) => model.is_model && model.key !== 'upload' && model.key !== 'date_to' && model.key !== 'date_from'
          ) as IConfigurationInput[];
          filterModel.value = activeInputs.filter(
            (filter) => filter.is_filter && filter.key !== 'upload' && filter.key !== 'date_to' && filter.key !== 'date_from'
          ) as IConfigurationInput[];
          uploadModel.value = activeInputs.filter(
            (model) => model.key === 'upload'
          ) as IConfigurationInput[];
          downloadModel.value = activeInputs.filter(
            (model) => model.key === 'date_to' || model.key === 'date_from'
          ) as IConfigurationInput[];
          searchResourceModel.value = activeInputs.filter(
            (filter) => filter.key === 'search_resource'
          ) as IConfigurationInput[];
          console.log('-> handleGetInputs', dataModel.value);
        } else {
          // TODO: What do you do when this does not exist
        }
      } catch (error) {
        console.log('-> catch', error);
      }
    }

    async function handleAdvancedFilter(type?: TResourceType) {
      const payload = handleApi.createFilterPayload(filterModel.value);
      try {
        resourceStore.handleApiEndpoint(window.location.pathname).then(async () => {
          const apiEndpoint = resourceStore.getApiEndpoint
          if (apiEndpoint && Array.isArray(apiEndpoint) && apiEndpoint.length) {
            resourceEndpoint.value = apiEndpoint[0].path
            const response = await api.get(resourceEndpoint.value, {
              params: {
                type: type ?? undefined,
                ...payload,
              },
            });
            allRecords.value = response.data as IAllRecords;
          } else {
            console.log('-> apiEndpoint does not exist', apiEndpoint);
          }
        });
      } catch (error) {
        console.log('-> catch', error);
      }
    }

    async function handleUpload() {
      const payload = handleApi.createPayload(uploadModel.value);
      try {
        resourceStore.handleApiEndpoint(window.location.pathname).then(async () => {
          const apiEndpoint = resourceStore.getApiEndpoint
          if (apiEndpoint && Array.isArray(apiEndpoint) && apiEndpoint.length) {
            resourceEndpoint.value = apiEndpoint[0].path
            const response = await api.post(resourceEndpoint.value, {
              ...payload,
            });
            allRecords.value = response.data as IAllRecords;
          } else {
            console.log('-> apiEndpoint does not exist', apiEndpoint);
          }
        });
      } catch (error) {
        console.log('-> catch', error);
      }
    }

    async function handleDownload() {
      const payload = handleApi.createPayload(downloadModel.value);
      try {
        resourceStore.handleApiEndpoint(window.location.pathname).then(async () => {
          const apiEndpoint = resourceStore.getApiEndpoint
          if (apiEndpoint && Array.isArray(apiEndpoint) && apiEndpoint.length) {
            resourceEndpoint.value = apiEndpoint[0].path
            const response = await api.post(resourceEndpoint.value, {
              ...payload,
            });
            allRecords.value = response.data as IAllRecords;
          } else {
            console.log('-> apiEndpoint does not exist', apiEndpoint);
          }
        });
      } catch (error) {
        console.log('-> catch', error);
      }
    }

    async function handleRestore() {
      console.log('-> handleRestore');
    }

    async function handleCreate() {
      const payload = handleApi.createPayload(dataModel.value);
      try {
        resourceStore.handleApiEndpoint(window.location.pathname).then(async () => {
          const apiEndpoint = resourceStore.getApiEndpoint
          if (apiEndpoint && Array.isArray(apiEndpoint) && apiEndpoint.length) {
            resourceEndpoint.value = apiEndpoint[0].path
            const response = await api.post(resourceEndpoint.value, {
              ...payload,
            });
            allRecords.value = response.data as IAllRecords;
          } else {
            console.log('-> apiEndpoint does not exist', apiEndpoint);
          }
        });
      } catch (error) {
        console.log('-> catch', error);
      }
    }

    async function handleShow(recordId: number | undefined, type?: TResourceType) {
      try {
        resourceStore.handleApiEndpoint(window.location.pathname).then(async () => {
          const apiEndpoint = resourceStore.getApiEndpoint
          if (apiEndpoint && Array.isArray(apiEndpoint) && apiEndpoint.length) {
            resourceEndpoint.value = apiEndpoint[0].path
            const response = await api.get(`${resourceEndpoint.value}/${recordId}`, {
              params: {
                type: type ?? undefined,
              },
            });
            singleRecord.value = response.data as ISingleRecord;
            console.log('-> handleShow', singleRecord.value);
          } else {
            console.log('-> apiEndpoint does not exist', apiEndpoint);
          }
        });
      } catch (error) {
        console.log('-> catch', error);
      }
    }

    async function handleUpdate() {
      const payload = handleApi.createPayload(dataModel.value);
      console.log('-> handleUpdate', payload);
    }

    async function handleDelete() {
      console.log('-> handleDelete');
    }

    async function handleStats() {
      console.log('-> handleStats');
    }

    return {
      // Getters
      getResourceName,
      getTranslationString,
      getAllRecords,
      getColumns,
      getDataModel,
      getFilterModel,
      getUploadModel,
      getDownloadModel,
      getSearchResourceModel,
      getAllDeletedRecords,
      getResourceConfiguration,
      getSingleRecord,

      // Actions
      handleIndex,
      handleGetConfigurationId,
      handleAdvancedFilter,
      handleUpload,
      handleDownload,
      handleRestore,
      handleCreate,
      handleShow,
      handleUpdate,
      handleDelete,
      handleStats,
    };
  }
);
