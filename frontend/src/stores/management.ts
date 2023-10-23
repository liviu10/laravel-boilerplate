import { defineStore } from 'pinia'
import { QTableProps } from 'quasar'
import { managementResources } from 'src/api/management'
import { api } from 'src/boot/axios'
import { Filter, Model } from 'src/library/ApiResponse/composables/interfaces'
import { handleApiResource, handleApiResponse } from 'src/library/ApiResponse/main'
import { handleNotificationSystem, handleNotificationSystemLog } from 'src/library/NotificationSystem/main'
import { Ref, computed, ref } from 'vue'

export const useManagementStore = defineStore('management', () => {
  // State
  const allColumns: Ref<QTableProps['columns'] | [] | undefined> = ref(undefined)
  const responseTitle = ref('')
  const allFilters: Ref<Filter[] | [] | undefined> = ref(undefined)
  const allModels: Ref<Model[] | [] | undefined> = ref(undefined)
  const allRecords: Ref<object[] | [] | undefined> = ref(undefined)
  const responseMessage = ref('')
  const singleRecord: Ref<object[] | [] | undefined> = ref(undefined)
  const createdRecord: Ref<object[] | [] | undefined> = ref(undefined)
  const updatedRecord: Ref<object[] | [] | undefined> = ref(undefined)
  const deletedRecord: Ref<object[] | [] | undefined> = ref(undefined)

  // Getters
  const getAllColumns = computed(() => allColumns.value)
  const getResponseTitle = computed(() => responseTitle.value)
  const getAllFilters = computed(() => allFilters.value)
  const getAllModels = computed(() => allModels.value)
  const getAllRecords = computed(() => allRecords.value)
  const getResponseMessage = computed(() => responseMessage.value)
  const getSingleRecord = computed(() => singleRecord.value)
  const getCreatedRecord = computed(() => createdRecord.value)
  const getUpdatedRecord = computed(() => updatedRecord.value)
  const getDeletedRecord = computed(() => deletedRecord.value)

  // Actions
  async function handleIndex(resourceName: string) {
    const apiEndpoint = handleApiResource(managementResources, resourceName, useManagementStore.$id)

    if (apiEndpoint && apiEndpoint !== null) {
      await api.get(apiEndpoint)
      .then(response => {
        const data = handleApiResponse(response, useManagementStore.$id)

        if (data) {
          allColumns.value = data.columns
          responseMessage.value = data.description
          allFilters.value = data.filters
          allModels.value = data.models
          allRecords.value = data.results
          responseTitle.value = data.title
        }
      })
      .catch((error) => {
        handleNotificationSystem(error.name, error.message, 'negative', 'bottom', true, error.response?.data)
        console.error(`${handleNotificationSystemLog.value('negative', useManagementStore.$id, error)}`)
      })
    }
  }

  async function handleStore(resourceName: string, payload: unknown) {
    const apiEndpoint = handleApiResource(managementResources, resourceName, useManagementStore.$id)

    if (apiEndpoint && apiEndpoint !== null) {
      await api.post(apiEndpoint, payload)
      .then(response => {
        const data = handleApiResponse(response, useManagementStore.$id)

        if (data) {
          responseMessage.value = data.description
          createdRecord.value = data.results
          responseTitle.value = data.title
        }
      })
      .catch((error) => {
        handleNotificationSystem(error.name, error.message, 'negative', 'bottom', true, error.response?.data)
        console.error(`${handleNotificationSystemLog.value('negative', useManagementStore.$id, error)}`)
      })
    }
  }

  async function handleShow(resourceName: string, recordId: number) {
    const apiEndpoint = handleApiResource(managementResources, resourceName, useManagementStore.$id)

    if (apiEndpoint && apiEndpoint !== null) {
      await api.get(`${apiEndpoint}/${recordId}`)
        .then(response => {
          const data = handleApiResponse(response, useManagementStore.$id)

          if (data) {
            responseMessage.value = data.description
            singleRecord.value = data.results
            responseTitle.value = data.title
          }
        })
        .catch((error) => {
          handleNotificationSystem(error.name, error.message, 'negative', 'bottom', true, error.response?.data)
          console.error(`${handleNotificationSystemLog.value('negative', useManagementStore.$id, error)}`)
        })
    }
  }

  async function handleUpdate(resourceName: string, recordId: number, payload: unknown) {
    const apiEndpoint = handleApiResource(managementResources, resourceName, useManagementStore.$id)

    if (apiEndpoint && apiEndpoint !== null) {
      await api.put(`${apiEndpoint}/${recordId}`, payload)
      .then(response => {
        const data = handleApiResponse(response, useManagementStore.$id)

        if (data) {
          responseMessage.value = data.description
          updatedRecord.value = data.results
          responseTitle.value = data.title
        }
      })
      .catch((error) => {
        handleNotificationSystem(error.name, error.message, 'negative', 'bottom', true, error.response?.data)
        console.error(`${handleNotificationSystemLog.value('negative', useManagementStore.$id, error)}`)
      })
    }
  }

  async function handleDestroy(resourceName: string, recordId: number) {
    const apiEndpoint = handleApiResource(managementResources, resourceName, useManagementStore.$id)

    if (apiEndpoint && apiEndpoint !== null) {
      await api.delete(`${apiEndpoint}/${recordId}`)
        .then(response => {
          const data = handleApiResponse(response, useManagementStore.$id)

          if (data) {
            deletedRecord.value = data.results
          }
        })
        .catch((error) => {
          handleNotificationSystem(error.name, error.message, 'negative', 'bottom', true, error.response?.data)
          console.error(`${handleNotificationSystemLog.value('negative', useManagementStore.$id, error)}`)
        })
    }
  }

  return {
    getAllColumns,
    getResponseTitle,
    getAllFilters,
    getAllModels,
    getAllRecords,
    getResponseMessage,
    getSingleRecord,
    getCreatedRecord,
    getUpdatedRecord,
    getDeletedRecord,
    handleIndex,
    handleStore,
    handleShow,
    handleUpdate,
    handleDestroy,
  }
})