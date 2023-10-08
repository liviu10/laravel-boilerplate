import { defineStore } from 'pinia'
import { resourceEndpoint } from 'src/api/settings'
import { api } from 'src/boot/axios'
import { ColumnInterface, FilterInterface, ModelInterface, handleApiResponse } from 'src/library/ApiResponse/main'
import { handleNotificationSystem, handleNotificationSystemLog } from 'src/library/NotificationSystem/main'
import { Ref, computed, ref } from 'vue'

const fullApiUrl: string = resourceEndpoint

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
  async function listRecords() {
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
