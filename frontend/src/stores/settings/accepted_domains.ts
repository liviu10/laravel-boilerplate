import { defineStore } from 'pinia'
// import { AxiosResponse } from 'axios'
import { api } from 'src/boot/axios'
import { IAllRecords } from 'src/interfaces/AcceptedDomainInterface'
// import { handleNotificationSystem, handleNotificationSystemLog } from 'src/library/NotificationSystem/main'
import { Ref, computed, ref } from 'vue'

const apiEndpoint = '/admin/settings/accepted-domains'

export const useAcceptedDomainStore = defineStore('acceptedDomainStore', () => {
  // State
  const allRecords: Ref<IAllRecords> = ref({} as IAllRecords)

  // Getters
  const getAllRecords = computed(() => allRecords.value)

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

    await
      api
        .get(apiEndpoint)
        .then(response => {
          allRecords.value = response.data as IAllRecords
        })
        .catch((error) => {
          //
        })

    // await
    //   api
    //     .get(apiEndpoint)
    //     .then(response => {
    //       allRecords.value = response.data as IAllRecords
    //     })
    //     .catch((error) => {
    //       handleNotificationSystem(error.name, error.message, 'negative', 'bottom', true, error.response?.data)
    //       console.error(`${handleNotificationSystemLog.value('negative', useAcceptedDomainStore.$id, error)}`)
    //     })
  }

  return {
    getAllRecords,
    handleIndex,
  }
})
