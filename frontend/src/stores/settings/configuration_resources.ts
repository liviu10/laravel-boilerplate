// Import vue related utilities
import { defineStore } from 'pinia'
import { api } from 'src/boot/axios'
import { Ref, computed, ref } from 'vue'
import { QTableProps } from 'quasar'

// Import library utilities, interfaces and components
import { HandleApi } from 'src/utilities/HandleApi'
import { HandleRoute } from 'src/utilities/HandleRoute'
import {
  IAllRecords,
  IAllRecordsUnpaginated,
  ISingleRecord,
  IConfigurationInput,
  IConfiguration
} from 'src/interfaces/ConfigurationResourceInterface'
import { TResourceType } from 'src/interfaces/BaseInterface'

const handleRoute = new HandleRoute

export const useConfigurationResourceStore = defineStore('configurationResourceStore', () => {
  // Handle API
  const handleApi = new HandleApi

  // State
  const resourceName: Ref<string> = ref('')
  const resourceEndpoint: Ref<string> = ref('')
  const translationString: Ref<string> = ref('')
  const allRecords: Ref<IAllRecords> = ref({} as IAllRecords)
  const columns: Ref<QTableProps['columns']> = ref([] as QTableProps['columns'])
  const dataModel: Ref<IConfigurationInput[]> = ref([] as IConfigurationInput[])
  const filterModel: Ref<IConfigurationInput[]> = ref([] as IConfigurationInput[])
  const uploadModel: Ref<IConfigurationInput[]> = ref([] as IConfigurationInput[])
  const downloadModel: Ref<IConfigurationInput[]> = ref([] as IConfigurationInput[])
  const allDeletedRecords: Ref<IAllRecordsUnpaginated> = ref({} as IAllRecordsUnpaginated)
  const resourceConfiguration: Ref<IConfiguration['results']> = ref([] as IConfiguration['results'])
  const singleRecord: Ref<ISingleRecord> = ref({} as ISingleRecord)

  // Getters
  const getResourceName = computed(() => resourceName.value = handleRoute.handleResourceNameFromRoute())
  const getTranslationString = computed(() => translationString.value = handleRoute.handleTranslationFromRoute())
  const getAllRecords = computed(() => allRecords.value)
  const getColumns = computed(() => columns.value)
  const getDataModel = computed(() => dataModel.value)
  const getFilterModel = computed(() => filterModel.value)
  const getUploadModel = computed(() => uploadModel.value)
  const getDownloadModel = computed(() => downloadModel.value)
  const getAllDeletedRecords = computed(() => allDeletedRecords.value)
  const getResourceConfiguration = computed(() => resourceConfiguration.value)
  const getSingleRecord = computed(() => singleRecord.value)

  // Actions
  async function handleIndex(type?: TResourceType) {
    try {
      handleApi.getEndpoint(getResourceName.value, useConfigurationResourceStore.$id).then(
        async (apiEndpoint) => {
          if (apiEndpoint) {
            handleApi.getConfiguration(getResourceName.value, useConfigurationResourceStore.$id).then(
              async (apiConfiguration) => {
                if (apiConfiguration) {
                  resourceEndpoint.value = apiEndpoint[0].path
                  resourceConfiguration.value = apiConfiguration
                  columns.value = handleApi.getColumnConfiguration(resourceConfiguration.value)
                  dataModel.value = handleApi.getDataModelConfiguration(resourceConfiguration.value)
                  filterModel.value = handleApi.getFilterModelConfiguration(resourceConfiguration.value)
                  uploadModel.value = handleApi.getUploadModelConfiguration(resourceConfiguration.value)
                  downloadModel.value = handleApi.getDownloadModelConfiguration(resourceConfiguration.value)
                  const response = await api.get(resourceEndpoint.value, {
                    params: {
                      type: type ?? undefined
                    }
                  })
                  if (type === 'restore') {
                    if (response.data && response.data.hasOwnProperty('results')) {
                      allDeletedRecords.value = response.data as IAllRecordsUnpaginated
                    }
                  } else {
                    allRecords.value = response.data as IAllRecords
                  }
                  console.log('-> handleIndex', allRecords.value)
                } else {
                  console.log('-> apiConfiguration does not exist', apiConfiguration)
                }
              }
            )
          } else {
            console.log('-> apiEndpoint does not exist', apiEndpoint)
          }
        }
      )
    } catch (error) {
      console.log('-> catch', error)
    } finally {
      console.log('-> finally')
    }
  }

  async function handleAdvancedFilter(type?: TResourceType) {
    const payload = handleApi.createFilterPayload(filterModel.value)
    debugger
    try {
      handleApi.getEndpoint(resourceName.value, useConfigurationResourceStore.$id).then(
        async (apiEndpoint) => {
          if (apiEndpoint) {
            resourceEndpoint.value = apiEndpoint[0].path
            const response = await api.get(resourceEndpoint.value, {
              params: {
                type: type ?? undefined,
                ...payload
              }
            })
            allRecords.value = response.data as IAllRecords
          } else {
            console.log('-> apiEndpoint does not exist', apiEndpoint)
          }
        }
      )
    } catch (error) {
      console.log('-> catch', error)
    } finally {
      console.log('-> finally')
    }
  }

  async function handleUpload() {
    const payload = handleApi.createPayload(uploadModel.value)
    try {
      handleApi.getEndpoint(resourceName.value, useConfigurationResourceStore.$id).then(
        async (apiEndpoint) => {
          if (apiEndpoint) {
            resourceEndpoint.value = apiEndpoint[0].path
            const response = await api.post(resourceEndpoint.value, {
              ...payload
            })
            allRecords.value = response.data as IAllRecords
          } else {
            console.log('-> apiEndpoint does not exist', apiEndpoint)
          }
        }
      )
    } catch (error) {
      console.log('-> catch', error)
    } finally {
      console.log('-> finally')
    }
  }

  async function handleDownload() {
    const payload = handleApi.createPayload(downloadModel.value)
    try {
      handleApi.getEndpoint(resourceName.value, useConfigurationResourceStore.$id).then(
        async (apiEndpoint) => {
          if (apiEndpoint) {
            resourceEndpoint.value = apiEndpoint[0].path
            const response = await api.post(resourceEndpoint.value, {
              ...payload
            })
            allRecords.value = response.data as IAllRecords
          } else {
            console.log('-> apiEndpoint does not exist', apiEndpoint)
          }
        }
      )
    } catch (error) {
      console.log('-> catch', error)
    } finally {
      console.log('-> finally')
    }
  }

  async function handleRestore() {
    console.log('-> handleRestore')
  }

  async function handleCreate() {
    const payload = handleApi.createPayload(dataModel.value)
    try {
      handleApi.getEndpoint(resourceName.value, useConfigurationResourceStore.$id).then(
        async (apiEndpoint) => {
          if (apiEndpoint) {
            resourceEndpoint.value = apiEndpoint[0].path
            const response = await api.post(resourceEndpoint.value, {
              ...payload
            })
            allRecords.value = response.data as IAllRecords
          } else {
            console.log('-> apiEndpoint does not exist', apiEndpoint)
          }
        }
      )
    } catch (error) {
      console.log('-> catch', error)
    } finally {
      console.log('-> finally')
    }
  }

  async function handleGetConfigurations(key: string) {
    try {
      const response = await api.get('admin/settings/get-configuration', {
        params: {
          key: key ?? undefined
        }
      })
      resourceConfiguration.value = response.data.results as IConfiguration['results']
      console.log('-> handleShow', resourceConfiguration.value)
    } catch (error) {
      console.log('-> catch', error)
    } finally {
      console.log('-> finally')
    }
  }

  async function handleShow(recordId: number | undefined, type?: TResourceType) {
    try {
      handleApi.getEndpoint(resourceName.value, useConfigurationResourceStore.$id).then(
        async (apiEndpoint) => {
          if (apiEndpoint) {
            resourceEndpoint.value = apiEndpoint[0].path
            const response = await api.get(`${resourceEndpoint.value}/${recordId}`, {
              params: {
                type: type ?? undefined
              }
            })
            singleRecord.value = response.data as ISingleRecord
            console.log('-> handleShow', singleRecord.value)
          } else {
            console.log('-> apiEndpoint does not exist', apiEndpoint)
          }
        }
      )
    } catch (error) {
      console.log('-> catch', error)
    } finally {
      console.log('-> finally')
    }
  }

  async function handleUpdate() {
    const payload = handleApi.createPayload(dataModel.value)
    console.log('-> handleUpdate', payload)
  }

  async function handleDelete() {
    console.log('-> handleDelete')
  }

  async function handleStats() {
    console.log('-> handleStats')
  }

  return {
    getResourceName,
    getTranslationString,
    getAllRecords,
    getColumns,
    getDataModel,
    getFilterModel,
    getUploadModel,
    getDownloadModel,
    getAllDeletedRecords,
    getResourceConfiguration,
    getSingleRecord,
    handleIndex,
    handleAdvancedFilter,
    handleUpload,
    handleDownload,
    handleRestore,
    handleCreate,
    handleGetConfigurations,
    handleShow,
    handleUpdate,
    handleDelete,
    handleStats,
  }
})
