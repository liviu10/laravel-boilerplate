// Import vue related utilities
import { defineStore } from 'pinia';
import { api } from 'src/boot/axios';
import { Ref, computed, ref } from 'vue';

// Import library utilities, interfaces and components
import { HandleApi } from 'src/utilities/HandleApi';
import { HandleRoute } from 'src/utilities/HandleRoute';
import { HandleObject } from 'src/utilities/HandleObject';
import {
  IConfiguration,
  IConfigurationInput,
} from 'src/interfaces/ConfigurationResourceInterface';
import {
  IAllRecordsUnpaginated,
  ISingleRecord,
} from 'src/interfaces/UserInterface';
import { TResourceType } from 'src/interfaces/BaseInterface';

// Import Pinia's related utilities
import { useConfigurationResourceStore } from 'src/stores/settings/configuration_resources';
import { useResourceStore } from 'src/stores/settings/resources';

const handleRoute = new HandleRoute();
const handleObject = new HandleObject();

export const useUserProfileStore = defineStore(
  'userProfileStore',
  () => {
    // Instantiate the pinia store
    const configurationResourceStore = useConfigurationResourceStore();
    const resourceStore = useResourceStore();

    // Handle API
    const handleApi = new HandleApi();

    // State
    const baseEndpoint = '/admin/settings/users/profile'
    const configurationBaseEndpoint = configurationResourceStore.baseEndpoint || 'admin/settings/configuration'
    const resourceName: Ref<string> = ref('');
    const resourceEndpoint: Ref<string> = ref('');
    const translationString: Ref<string> = ref('');
    const dataModel: Ref<IConfigurationInput[]> = ref([] as IConfigurationInput[]);
    const allDeletedRecords: Ref<IAllRecordsUnpaginated> = ref({} as IAllRecordsUnpaginated);
    const resourceConfiguration: Ref<IConfiguration['results']> = ref([] as IConfiguration['results']);
    const singleRecord: Ref<ISingleRecord> = ref({} as ISingleRecord);

    // Getters
    const getResourceName = computed(() => (resourceName.value = handleRoute.handleResourceNameFromRoute()));
    const getTranslationString = computed(() => (translationString.value = handleRoute.handleTranslationFromRoute()));
    const getDataModel = computed(() => dataModel.value);
    const getAllDeletedRecords = computed(() => allDeletedRecords.value);
    const getResourceConfiguration = computed(() => resourceConfiguration.value);
    const getSingleRecord = computed(() => singleRecord.value);

    // Actions
    async function handleIndex() {
      try {
        resourceStore.handleApiEndpoint(window.location.pathname).then(async () => {
          const apiEndpoint = resourceStore.getApiEndpoint
          if (apiEndpoint && Array.isArray(apiEndpoint) && apiEndpoint.length) {
            resourceEndpoint.value = apiEndpoint[0].path
            handleGetConfigurationId(getResourceName.value).then(async () => {
              if (resourceConfiguration.value) {
                await handleGetInputs(resourceConfiguration.value)
              } else {
                console.log('-> apiConfiguration does not exist', resourceConfiguration.value);
              }
            })
          } else {
            console.log('-> apiEndpoint does not exist, but the default value is used', apiEndpoint);
            handleGetConfigurationId(getResourceName.value).then(async () => {
              if (resourceConfiguration.value) {
                await handleGetInputs(resourceConfiguration.value)
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
        } else {
          // TODO: What do you do when this does not exist
        }
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
          } else {
            console.log('-> apiEndpoint does not exist, but the default value is used', apiEndpoint);
            const response = await api.get(`${baseEndpoint}/${recordId}`, {
              params: {
                type: type ?? undefined,
              },
            });
            singleRecord.value = response.data as ISingleRecord;
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

    async function handleDeactivate() {
      console.log('-> handleDeactivate');
    }

    async function handleReset() {
      console.log('-> handleReset');
    }

    return {
      // State
      resourceEndpoint,

      // Getters
      getResourceName,
      getTranslationString,
      getDataModel,
      getAllDeletedRecords,
      getResourceConfiguration,
      getSingleRecord,

      // Actions
      handleIndex,
      handleGetConfigurationId,
      handleGetInputs,
      handleShow,
      handleUpdate,
      handleDeactivate,
      handleReset,
    };
  }
);
