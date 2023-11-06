import { defineStore } from 'pinia'
import { api } from 'src/boot/axios'
import { IAllRecords } from 'src/interfaces/AcceptedDomainInterface'
import { handleNotificationSystem, handleNotificationSystemLog } from 'src/library/NotificationSystem/main'
import { Ref, computed, ref } from 'vue'

const apiEndpoint = '/admin/settings/accepted-domains'

export const useAcceptedDomainStore = defineStore('acceptedDomainStore', () => {
  // State
  const allRecords: Ref<IAllRecords> = ref({} as IAllRecords)

  // Getters
  const getAllRecords = computed(() => allRecords.value)

  // Actions
  async function handleIndex() {
    await
      api
        .get(apiEndpoint)
        .then(response => {
          allRecords.value = response.data as IAllRecords
        })
        .catch((error) => {
          handleNotificationSystem(error.name, error.message, 'negative', 'bottom', true, error.response?.data)
          console.error(`${handleNotificationSystemLog.value('negative', useAcceptedDomainStore.$id, error)}`)
        })
  }

  return {
    getAllRecords,
    handleIndex,
  }
})
