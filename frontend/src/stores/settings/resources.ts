// Import vue related utilities
import { defineStore } from 'pinia';
import { api } from 'src/boot/axios';
import { Ref, computed, ref } from 'vue';
import { QTableProps } from 'quasar';

// Import library utilities, interfaces and components
import { HandleApi } from 'src/utilities/HandleApi';
import { HandleRoute } from 'src/utilities/HandleRoute';
import { HandleObject } from 'src/utilities/HandleObject';
import { TResourceType } from 'src/interfaces/BaseInterface'
import {
  IConfiguration,
  IConfigurationInput,
  IConfigurationColumn,
} from 'src/interfaces/ConfigurationResourceInterface';
import {
  IAllRecords,
  IAllRecordsUnpaginated,
  ISingleRecord,
} from 'src/interfaces/ResourceInterface';

// Import Pinia's related utilities
import { useConfigurationResourceStore } from 'src/stores/settings/configuration_resources';

const handleRoute = new HandleRoute();
const handleObject = new HandleObject();

export const useResourceStore = defineStore(
  'resourceStore',
  () => {
    // Instantiate the pinia store
    const configurationResourceStore = useConfigurationResourceStore();

    // Handle API
    const handleApi = new HandleApi();

    // State
    const baseEndpoint = '/admin/settings/resource'
    const configurationBaseEndpoint = configurationResourceStore.baseEndpoint || 'admin/settings/configuration'
    const resourceName: Ref<string> = ref('');
    const resourceEndpoint: Ref<string> = ref('');
    const translationString: Ref<string> = ref('');
    const allRecords: Ref<IAllRecords> = ref({} as IAllRecords)
    const columns: Ref<QTableProps['columns']> = ref([] as QTableProps['columns']);
    const dataModel: Ref<IConfigurationInput[]> = ref([] as IConfigurationInput[]);
    const filterModel: Ref<IConfigurationInput[]> = ref([] as IConfigurationInput[]);
    const uploadModel: Ref<IConfigurationInput[]> = ref([] as IConfigurationInput[]);
    const downloadModel: Ref<IConfigurationInput[]> = ref([] as IConfigurationInput[]);
    const searchResourceModel: Ref<IConfigurationInput[]> = ref([] as IConfigurationInput[]);
    const apiEndpoint: Ref<IAllRecordsUnpaginated['results']> = ref([] as IAllRecordsUnpaginated['results'])
    const apiMenu: Ref<IAllRecordsUnpaginated['results']> = ref([] as IAllRecordsUnpaginated['results'])
    const allDeletedRecords: Ref<IAllRecordsUnpaginated> = ref({} as IAllRecordsUnpaginated);
    const resourceConfiguration: Ref<IConfiguration['results']> = ref([] as IConfiguration['results']);
    const singleRecord: Ref<ISingleRecord> = ref({} as ISingleRecord);
    const loadPage: Ref<boolean> = ref(false);

    // Client state
    const apiClientMenu: Ref<IAllRecordsUnpaginated['results']> = ref([] as IAllRecordsUnpaginated['results'])

    // Getters
    const getResourceName = computed(() => (resourceName.value = handleRoute.handleResourceNameFromRoute()));
    const getTranslationString = computed(() => (translationString.value = handleRoute.handleTranslationFromRoute()));
    const getAllRecords = computed(() => allRecords.value)
    const getColumns = computed(() => columns.value);
    const getDataModel = computed(() => dataModel.value);
    const getFilterModel = computed(() => filterModel.value);
    const getUploadModel = computed(() => uploadModel.value);
    const getDownloadModel = computed(() => downloadModel.value);
    const getSearchResourceModel = computed(() => searchResourceModel.value);
    const getApiEndpoint = computed(() => apiEndpoint.value)
    const getApiMenu = computed(() => apiMenu.value);
    const getAllDeletedRecords = computed(() => allDeletedRecords.value);
    const getResourceConfiguration = computed(() => resourceConfiguration.value);
    const getSingleRecord = computed(() => singleRecord.value);

    // Client getters
    const getApiClientMenu = computed(() => apiClientMenu.value);

    // Actions
    async function handleIndex(type?: TResourceType) {
      try {
        loadPage.value = true;
        handleApiEndpoint(window.location.pathname).then(async () => {
          const apiEndpoint = getApiEndpoint.value
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
                loadPage.value = false;
              } else {
                console.log('-> apiConfiguration does not exist', resourceConfiguration.value);
              }
            })
          } else {
            console.log('-> apiEndpoint does not exist, but the default value is used', apiEndpoint);
            handleGetConfigurationId(getResourceName.value).then(async () => {
              if (resourceConfiguration.value) {
                await handleGetColumns(resourceConfiguration.value)
                await handleGetInputs(resourceConfiguration.value)
                const response = await api.get(baseEndpoint, {
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
                loadPage.value = false;
              } else {
                console.log('-> apiConfiguration does not exist', resourceConfiguration.value);
              }
            })
          }
        })
      } catch (error) {
        console.log('-> catch', error);
      }
    }

    async function handleGetConfigurationId(key: string) {
      try {
        const response = await api.get(`${configurationBaseEndpoint}/resources/get-id`, {
          params: {
            key: key ?? undefined,
          },
        });
        resourceConfiguration.value = response.data.results as IConfiguration['results'];
      } catch (error) {
        console.log('-> catch', error);
      }
    }

    async function handleGetColumns(configurationResourceId: IConfiguration['results']) {
      try {
        const response = await api.get(`${configurationBaseEndpoint}/columns`, {
          params: {
            configuration_resource_id: configurationResourceId[0].id ?? undefined,
          },
        });
        if (response.data && response.data.hasOwnProperty('results')) {
          columns.value = response.data.results as IConfigurationColumn[];
        } else {
          // TODO: What do you do when this does not exist
        }
      } catch (error) {
        console.log('-> catch', error);
      }
    }

    async function handleGetInputs(configurationResourceId: IConfiguration['results']) {
      try {
        const response = await api.get(`${configurationBaseEndpoint}/inputs`, {
          params: {
            configuration_resource_id: configurationResourceId[0].id ?? undefined,
          },
        });
        if (response.data && response.data.hasOwnProperty('results')) {
          const activeInputs = handleObject.handleActiveInputs(response.data.results)
          dataModel.value = handleObject.handleActiveInputsDataModel(activeInputs)
          filterModel.value = handleObject.handleActiveInputsFilterModel(activeInputs)
          uploadModel.value = handleObject.handleActiveInputsUploadModel(activeInputs)
          downloadModel.value = handleObject.handleActiveInputsDownloadModel(activeInputs)
          searchResourceModel.value = handleObject.handleActiveInputsSearchResourceModel(activeInputs)
        } else {
          // TODO: What do you do when this does not exist
        }
      } catch (error) {
        console.log('-> catch', error);
      }
    }

    async function handleAdvancedFilter(type?: TResourceType) {
      const payload = handleApi.createFilterPayload(filterModel.value, searchResourceModel.value);
      try {
        loadPage.value = true;
        handleApiEndpoint(window.location.pathname).then(async () => {
          const apiEndpoint = getApiEndpoint.value
          if (apiEndpoint && Array.isArray(apiEndpoint) && apiEndpoint.length) {
            resourceEndpoint.value = apiEndpoint[0].path
            const response = await api.get(resourceEndpoint.value, {
              params: {
                type: type ?? undefined,
                ...payload,
              },
            });
            allRecords.value = response.data as IAllRecords;
            loadPage.value = false;
          } else {
            console.log('-> apiEndpoint does not exist, but the default value is used', apiEndpoint);
            const response = await api.get(baseEndpoint, {
              params: {
                type: type ?? undefined,
                ...payload,
              },
            });
            allRecords.value = response.data as IAllRecords;
            loadPage.value = false;
          }
        });
      } catch (error) {
        console.log('-> catch', error);
      }
    }

    async function handleUpload() {
      const payload = handleApi.createPayload(uploadModel.value);
      try {
        loadPage.value = true;
        handleApiEndpoint(window.location.pathname).then(async () => {
          const apiEndpoint = getApiEndpoint.value
          if (apiEndpoint && Array.isArray(apiEndpoint) && apiEndpoint.length) {
            resourceEndpoint.value = apiEndpoint[0].path
            const response = await api.post(resourceEndpoint.value, {
              ...payload,
            });
            allRecords.value = response.data as IAllRecords;
            loadPage.value = false;
          } else {
            console.log('-> apiEndpoint does not exist, but the default value is used', apiEndpoint);
            const response = await api.post(baseEndpoint, {
              ...payload,
            });
            allRecords.value = response.data as IAllRecords;
            loadPage.value = false;
          }
        });
      } catch (error) {
        console.log('-> catch', error);
      }
    }

    async function handleDownload() {
      const payload = handleApi.createPayload(downloadModel.value);
      try {
        loadPage.value = true;
        handleApiEndpoint(window.location.pathname).then(async () => {
          const apiEndpoint = getApiEndpoint.value
          if (apiEndpoint && Array.isArray(apiEndpoint) && apiEndpoint.length) {
            resourceEndpoint.value = apiEndpoint[0].path
            const response = await api.post(resourceEndpoint.value, {
              ...payload,
            });
            allRecords.value = response.data as IAllRecords;
            loadPage.value = false;
          } else {
            console.log('-> apiEndpoint does not exist, but the default value is used', apiEndpoint);
            const response = await api.post(baseEndpoint, {
              ...payload,
            });
            allRecords.value = response.data as IAllRecords;
            loadPage.value = false;
          }
        });
      } catch (error) {
        console.log('-> catch', error);
      }
    }

    async function handleApiEndpoint(path?: string) {
      try {
        const response = await api.get(baseEndpoint, {
          params: {
            type: 'API' as TResourceType,
            path: path ?? undefined
          }
        })
        apiEndpoint.value = response.data.results as IAllRecordsUnpaginated['results']
      } catch (error) {
        console.log('-> catch', error)
      }
    }

    async function handleMenu() {
      try {
        const response = await api.get(baseEndpoint, {
          params: {
            type: 'Menu' as TResourceType,
            requires_auth: true
          }
        })
        apiMenu.value = response.data.results as IAllRecordsUnpaginated['results']
      } catch (error) {
        console.log('-> catch', error)
      }
    }

    async function handleRestore() {
      console.log('-> handleRestore');
    }

    async function handleCreate() {
      const payload = handleApi.createPayload(dataModel.value);
      try {
        loadPage.value = true;
        handleApiEndpoint(window.location.pathname).then(async () => {
          const apiEndpoint = getApiEndpoint.value
          if (apiEndpoint && Array.isArray(apiEndpoint) && apiEndpoint.length) {
            resourceEndpoint.value = apiEndpoint[0].path
            const response = await api.post(resourceEndpoint.value, {
              ...payload,
            });
            allRecords.value = response.data as IAllRecords;
            loadPage.value = false;
          } else {
            console.log('-> apiEndpoint does not exist, but the default value is used', apiEndpoint);
            const response = await api.post(baseEndpoint, {
              ...payload,
            });
            allRecords.value = response.data as IAllRecords;
            loadPage.value = false;
          }
        });
      } catch (error) {
        console.log('-> catch', error);
      }
    }

    async function handleShow(recordId: number | undefined, type?: TResourceType) {
      try {
        loadPage.value = true;
        handleApiEndpoint(window.location.pathname).then(async () => {
          const apiEndpoint = getApiEndpoint.value
          if (apiEndpoint && Array.isArray(apiEndpoint) && apiEndpoint.length) {
            resourceEndpoint.value = apiEndpoint[0].path
            const response = await api.get(`${resourceEndpoint.value}/${recordId}`, {
              params: {
                type: type ?? undefined,
              },
            });
            singleRecord.value = response.data as ISingleRecord;
            loadPage.value = false;
          } else {
            console.log('-> apiEndpoint does not exist, but the default value is used', apiEndpoint);
            const response = await api.get(`${baseEndpoint}/${recordId}`, {
              params: {
                type: type ?? undefined,
              },
            });
            singleRecord.value = response.data as ISingleRecord;
            loadPage.value = false;
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

    async function handleReset() {
      console.log('-> handleReset');
    }

    async function handleClientMenu(requiresAuth?: boolean) {
      try {
        const response = await api.get(baseEndpoint, {
          params: {
            type: 'Menu' as TResourceType,
            requires_auth: requiresAuth ?? undefined
          }
        })
        apiClientMenu.value = response.data.results as IAllRecordsUnpaginated['results']
      } catch (error) {
        console.log('-> catch', error)
      }
    }

    return {
      // State
      baseEndpoint,
      resourceEndpoint,
      loadPage,

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
      getApiEndpoint,
      getApiMenu,
      getAllDeletedRecords,
      getResourceConfiguration,
      getSingleRecord,

      // Client Getters
      getApiClientMenu,

      // Actions
      handleIndex,
      handleGetConfigurationId,
      handleGetColumns,
      handleGetInputs,
      handleAdvancedFilter,
      handleUpload,
      handleDownload,
      handleApiEndpoint,
      handleMenu,
      handleRestore,
      handleCreate,
      handleShow,
      handleUpdate,
      handleDelete,
      handleStats,
      handleReset,

      // Client actions
      handleClientMenu,
    }
  }
)
