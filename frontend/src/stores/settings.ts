import { defineStore } from 'pinia'
import { api } from 'src/boot/axios'
import { ColumnInterface, FilterInterface, ModelInterface, handleApiResponse } from 'src/library/ApiResponse/main'
import { handleNotificationSystem, handleNotificationSystemLog } from 'src/library/NotificationSystem/main'
import { Ref, computed, ref } from 'vue'

let fullApiUrl = ''
const notificationTitle = 'Warning'
const notificationMessage = 'The resource does not exist'
const settingsResources = [
  {
    id: 1,
    name: 'accepted-domains',
    endpoint: '/admin/settings/accepted-domains'
  },
  {
    id: 2,
    name: 'general',
    endpoint: '/admin/settings/general'
  },
  {
    id: 3,
    name: 'notifications',
    endpoint: '/admin/settings/notifications'
  },
  {
    id: 4,
    name: 'resources',
    endpoint: '/admin/settings/resources'
  },
  {
    id: 5,
    name: 'roles',
    endpoint: '/admin/settings/roles'
  },
  {
    id: 6,
    name: 'users',
    endpoint: '/admin/settings/users'
  }
]

export const useSettingStore = defineStore('settings', () => {
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
    const resourceEndpoint = settingsResources.find((r) => r.name === resourceName)

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
