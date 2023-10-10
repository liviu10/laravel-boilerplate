import { defineStore } from 'pinia'
import { ResourceEndpointInterface } from 'src/api/interface'
import { settingsResources } from 'src/api/settings'
import { api } from 'src/boot/axios'
import { ColumnInterface, FilterInterface, ModelInterface } from 'src/library/ApiResponse/composables/interfaces'
import { handleApiResponse } from 'src/library/ApiResponse/main'
import { handleNotificationSystem, handleNotificationSystemLog } from 'src/library/NotificationSystem/main'
import { Ref, computed, ref } from 'vue'

let fullApiUrl = ''
let resourceEndpoint: ResourceEndpointInterface | undefined = undefined
const notificationTitle = 'Warning'
const notificationMessage = 'The resource does not exist'

export const useSettingStore = defineStore('settings', () => {
  // State
  const allColumns: Ref<ColumnInterface[] | [] | undefined> = ref(undefined)
  const responseTitle = ref('')
  const allFilters: Ref<FilterInterface[] | [] | undefined> = ref(undefined)
  const allModels: Ref<ModelInterface[] | [] | undefined> = ref(undefined)
  const allRecords: Ref<object[] | [] | undefined> = ref(undefined)
  const responseMessage = ref('')
  const singleRecord: Ref<object[] | [] | undefined> = ref(undefined)

  // Getters
  const getAllColumns = computed(() => allColumns.value)
  const getResponseTitle = computed(() => responseTitle.value)
  const getAllFilters = computed(() => allFilters.value)
  const getAllModels = computed(() => allModels.value)
  const getAllRecords = computed(() => allRecords.value)
  const getResponseMessage = computed(() => responseMessage.value)
  const getSingleRecord = computed(() => singleRecord.value)

  // Actions
  async function handleIndex(resourceName: string) {
    resourceEndpoint = settingsResources.find((r) => r.name === resourceName)

    if (resourceEndpoint) {
      fullApiUrl = resourceEndpoint.endpoint;
      await api.get(fullApiUrl)
        .then(response => {
          const data = handleApiResponse(response, useSettingStore.$id)

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
          console.error(`${handleNotificationSystemLog.value('negative', useSettingStore.$id, error)}`)
        })
    } else {
      const context = {
        message: 'Test context'
      }
      handleNotificationSystem(notificationTitle, notificationMessage, 'negative', 'bottom', true)
      console.error(`${handleNotificationSystemLog.value('negative', useSettingStore.$id, context)}`)
    }
  }

  async function handleShow(resourceName: string, recordId: number) {
    resourceEndpoint = settingsResources.find((r) => r.name === resourceName)

    if (resourceEndpoint) {
      fullApiUrl = `${resourceEndpoint.endpoint}/${recordId}`
      await api.get(fullApiUrl)
        .then(response => {
          debugger;
        })
        .catch((error) => {
          handleNotificationSystem(error.name, error.message, 'negative', 'bottom', true, error.response?.data)
          console.error(`${handleNotificationSystemLog.value('negative', useSettingStore.$id, error)}`)
        })
    } else {
      const context = {
        message: 'Test context'
      }
      handleNotificationSystem(notificationTitle, notificationMessage, 'negative', 'bottom', true)
      console.error(`${handleNotificationSystemLog.value('negative', useSettingStore.$id, context)}`)
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
    handleIndex,
    handleShow,
  }
})
