import { defineStore } from 'pinia'
import { communicationResources } from 'src/api/communication'
import { ResourceEndpointInterface } from 'src/api/interface'
import { api } from 'src/boot/axios'
import { ColumnInterface, FilterInterface, ModelInterface } from 'src/library/ApiResponse/composables/interfaces'
import { handleApiResponse } from 'src/library/ApiResponse/main'
import { handleNotificationSystem, handleNotificationSystemLog } from 'src/library/NotificationSystem/main'
import { Ref, computed, ref } from 'vue'

let fullApiUrl = ''
let resourceEndpoint: ResourceEndpointInterface | undefined = undefined
const notificationTitle = 'Warning'
const notificationMessage = 'The resource does not exist'

export const useCommunicationStore = defineStore('communication', () => {
  // State
  const allColumns: Ref<ColumnInterface[] | [] | undefined> = ref(undefined)
  const responseTitle = ref('')
  const allFilters: Ref<FilterInterface[] | [] | undefined> = ref(undefined)
  const allModels: Ref<ModelInterface[] | [] | undefined> = ref(undefined)
  const allRecords: Ref<object[] | [] | undefined> = ref(undefined)
  const responseMessage = ref('')

  // Getters
  const getAllColumns = computed(() => allColumns.value)
  const getResponseTitle = computed(() => responseTitle.value)
  const getAllFilters = computed(() => allFilters.value)
  const getAllModels = computed(() => allModels.value)
  const getAllRecords = computed(() => allRecords.value)
  const getResponseMessage = computed(() => responseMessage.value)

  // Actions
  async function listRecords(resourceName: string) {
    resourceEndpoint = communicationResources.find((r) => r.name === resourceName)

    if (resourceEndpoint) {
      fullApiUrl = resourceEndpoint.endpoint;
      await api.get(fullApiUrl)
        .then(response => {
          const data = handleApiResponse(response, useCommunicationStore.$id)

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
          console.error(`${handleNotificationSystemLog.value('negative', useCommunicationStore.$id, error)}`)
        })
    } else {
      const context = {
        message: 'Test context'
      }
      handleNotificationSystem(notificationTitle, notificationMessage, 'negative', 'bottom', true)
      console.error(`${handleNotificationSystemLog.value('negative', useCommunicationStore.$id, context)}`)
    }
  }

  return {
    getAllColumns,
    getResponseTitle,
    getAllFilters,
    getAllModels,
    getAllRecords,
    getResponseMessage,
    listRecords
  }
})
