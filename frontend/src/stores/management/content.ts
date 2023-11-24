// Import vue related utilities
import { defineStore } from 'pinia'
import { api } from 'src/boot/axios'
import { Ref, computed, ref } from 'vue'
import { QTableProps } from 'quasar'

// Import library utilities, interfaces and components
import {
  defaultDataModel,
  defaultDownloadModel,
  defaultFilterModel,
  defaultUploadModel
} from 'src/assets/data/dataModel'
import { IConfigurationInput } from 'src/interfaces/ConfigurationResourceInterface'
import { IAllRecords } from 'src/interfaces/ContentInterface'
import { defaultColumns } from 'src/assets/data/columns'

const apiEndpoint = '/admin/management/contents'

export const useContentStore = defineStore('contentStore', () => {
  // State
  const resourceName = 'Content'
  const allRecords: Ref<IAllRecords> = ref({} as IAllRecords)
  const columns: Ref<QTableProps['columns']> = ref(defaultColumns as QTableProps['columns'])
  const dataModel: Ref<IConfigurationInput[]> = ref(defaultDataModel as IConfigurationInput[])
  const filterModel: Ref<IConfigurationInput[]> = ref(defaultFilterModel as IConfigurationInput[])
  const uploadModel: Ref<IConfigurationInput[]> = ref(defaultUploadModel as IConfigurationInput[])
  const downloadModel: Ref<IConfigurationInput[]> = ref(defaultDownloadModel as IConfigurationInput[])

  // Getters
  const getAllRecords = computed(() => allRecords.value)
  const getColumns = computed(() => columns.value)
  const getDataModel = computed(() => dataModel.value)
  const getFilterModel = computed(() => filterModel.value)
  const getUploadModel = computed(() => uploadModel.value)
  const getDownloadModel = computed(() => downloadModel.value)

  // Actions
  async function handleIndex() {
    try {
      const response = await api.get(apiEndpoint)
      allRecords.value = response.data as IAllRecords
      console.log('> try', allRecords.value)
    } catch (error) {
      console.log('> catch', error)
    } finally {
      console.log('> finally')
    }
  }

  async function handleFind(recordId: number) {
    console.log('-> handleFind', recordId)
  }

  async function handleCreate(payload: IConfigurationInput[]) {
    console.log('-> handleCreate', payload)
  }

  async function handleUpdate(recordId: number, payload: IConfigurationInput[]) {
    console.log('-> handleUpdate', recordId, payload)
  }

  async function handleDelete(recordId: number) {
    console.log('-> handleDelete', recordId)
  }

  return {
    resourceName,
    getAllRecords,
    getColumns,
    getDataModel,
    getFilterModel,
    getUploadModel,
    getDownloadModel,
    handleIndex,
    handleFind,
    handleCreate,
    handleUpdate,
    handleDelete,
  }
})
