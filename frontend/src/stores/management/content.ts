// Import vue related utilities
import { defineStore } from 'pinia'
import { api } from 'src/boot/axios'
import { Ref, computed, ref } from 'vue'
import { QTableProps } from 'quasar'

// Import library utilities, interfaces and components
import { HandleApiRequestProcessor } from 'src/utilities/HandleApiRequestProcessor'
import { defaultColumns } from 'src/assets/data/columns'
import {
  defaultDataModel,
  defaultDownloadModel,
  defaultFilterModel,
  defaultUploadModel
} from 'src/assets/data/dataModel'
import { IConfigurationInput } from 'src/interfaces/ConfigurationResourceInterface'
import { IAllRecords, IAllRecordsUnpaginated, ISingleRecord } from 'src/interfaces/ContentInterface'
import { TResourceType } from 'src/interfaces/BaseInterface'

const apiEndpoint = '/admin/management/contents'

const handleApiRequestProcessor = new HandleApiRequestProcessor

export const useContentStore = defineStore('contentStore', () => {
  // State
  const resourceName = 'Content'
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
      const response = await api.get(apiEndpoint, {
        params: {
          type: type ?? undefined
        }
      })
      if (type === 'restore') {
        allDeletedRecords.value = response.data as IAllRecordsUnpaginated
      } else {
        allRecords.value = response.data as IAllRecords
      }
      console.log('-> handleIndex', allRecords.value)
    } catch (error) {
      console.log('-> catch', error)
    } finally {
      console.log('-> finally')
    }
  }

  async function handleAdvancedFilter() {
    const payload = handleApiRequestProcessor.createPayload(filterModel.value)
    console.log('-> handleAdvancedFilter', payload)
  }

  async function handleUpload() {
    const payload = handleApiRequestProcessor.createPayload(uploadModel.value)
    console.log('-> handleUpload', payload)
  }

  async function handleDownload() {
    const payload = handleApiRequestProcessor.createPayload(downloadModel.value)
    console.log('-> handleDownload', payload)
  }

  async function handleRestore() {
    console.log('-> handleRestore')
  }

  async function handleCreate() {
    const payload = handleApiRequestProcessor.createPayload(dataModel.value)
    console.log('-> handleCreate', payload)
  }

  async function handleShow(recordId: number | undefined, type?: TResourceType) {
    try {
      const response = await api.get(`${apiEndpoint}/${recordId}`, {
        params: {
          type: type ?? undefined
        }
      })
      singleRecord.value = response.data as ISingleRecord
      console.log('-> handleShow', singleRecord.value)
    } catch (error) {
      console.log('-> catch', error)
    } finally {
      console.log('-> finally')
    }
  }

  async function handleUpdate() {
    const payload = handleApiRequestProcessor.createPayload(dataModel.value)
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
