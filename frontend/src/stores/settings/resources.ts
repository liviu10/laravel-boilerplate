import { defineStore } from 'pinia'
import { api } from 'src/boot/axios'
import { IAllRecords } from 'src/interfaces/ResourceInterface'
import { handleNotificationSystem, handleNotificationSystemLog } from 'src/library/NotificationSystem/main'
import { Ref, computed, ref } from 'vue'

const apiEndpoint = '/admin/settings/resources'

export const useResourceStore = defineStore('resourceStore', () => {
  // State
  const allRecords: Ref<IAllRecords['results']> = ref([])

  // Getters
  const getAllRecords = computed(() => allRecords.value)

  // Actions
  async function handleIndex() {
    await
      api
        .get(apiEndpoint, { params: { type: 'Menu' } })
        .then(response => {
          allRecords.value = response.data.results as IAllRecords['results']
        })
        .catch((error) => {
          handleNotificationSystem(error.name, error.message, 'negative', 'bottom', true, error.response?.data)
          console.error(`${handleNotificationSystemLog.value('negative', useResourceStore.$id, error)}`)
        })
  }

  return {
    getAllRecords,
    handleIndex,
  }
})
