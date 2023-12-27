// Import vue related utilities
import { defineStore } from 'pinia'
import { api } from 'src/boot/axios'
import { Ref, computed, ref } from 'vue'
import { QTableProps } from 'quasar'

// Import library utilities, interfaces and components
import { HandleApi } from 'src/utilities/HandleApi'
import { defaultColumns } from 'src/assets/data/columns'
import {
  defaultDataModel,
  defaultDownloadModel,
  defaultFilterModel,
  defaultUploadModel
} from 'src/assets/data/dataModel'
import { IAllRecords, IAllRecordsUnpaginated, ISingleRecord } from 'src/interfaces/GeneralInterface'
import { IConfigurationInput } from 'src/interfaces/ConfigurationResourceInterface'
import { TResourceType } from 'src/interfaces/BaseInterface'

const handleApi = new HandleApi

export const useGeneralStore = defineStore('generalStore', () => {
  // State
  const resourceName = 'General'
  const resourceEndpoint: Ref<string> = ref('')
  const allRecords: Ref<IAllRecords> = ref({} as IAllRecords)
  const columns: Ref<QTableProps['columns']> = ref(defaultColumns as QTableProps['columns'])
  const dataModel: Ref<IConfigurationInput[]> = ref(defaultDataModel as IConfigurationInput[])
  const filterModel: Ref<IConfigurationInput[]> = ref(defaultFilterModel as IConfigurationInput[])
  const uploadModel: Ref<IConfigurationInput[]> = ref(defaultUploadModel as IConfigurationInput[])
  const downloadModel: Ref<IConfigurationInput[]> = ref(defaultDownloadModel as IConfigurationInput[])
  const allDeletedRecords: Ref<IAllRecordsUnpaginated> = ref({} as IAllRecordsUnpaginated)
  const singleRecord: Ref<ISingleRecord> = ref({} as ISingleRecord)

  // Getters
  const getAllRecords = computed(() => allRecords.value)
  const getColumns = computed(() => columns.value)
  const getDataModel = computed(() => dataModel.value)
  const getFilterModel = computed(() => filterModel.value)
  const getUploadModel = computed(() => uploadModel.value)
  const getDownloadModel = computed(() => downloadModel.value)
  const getAllDeletedRecords = computed(() => allDeletedRecords.value)
  const getSingleRecord = computed(() => singleRecord.value)

  // Actions
  async function handleIndex(type?: TResourceType) {
    try {
      handleApi.getEndpoint(resourceName, useGeneralStore.$id).then(
        async (apiEndpoint) => {
          if (apiEndpoint) {
            resourceEndpoint.value = apiEndpoint[0].path
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
    try {
      handleApi.getEndpoint(resourceName, useGeneralStore.$id).then(
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
      handleApi.getEndpoint(resourceName, useGeneralStore.$id).then(
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
      handleApi.getEndpoint(resourceName, useGeneralStore.$id).then(
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
      handleApi.getEndpoint(resourceName, useGeneralStore.$id).then(
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

  async function handleShow(recordId: number | undefined, type?: TResourceType) {
    try {
      handleApi.getEndpoint(resourceName, useGeneralStore.$id).then(
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
    resourceName,
    getAllRecords,
    getColumns,
    getDataModel,
    getFilterModel,
    getUploadModel,
    getDownloadModel,
    getAllDeletedRecords,
    getSingleRecord,
    handleIndex,
    handleAdvancedFilter,
    handleUpload,
    handleDownload,
    handleRestore,
    handleCreate,
    handleShow,
    handleUpdate,
    handleDelete,
    handleStats,
  }
})
