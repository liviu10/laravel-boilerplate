import { defineStore } from 'pinia'
import { api } from 'src/boot/axios'
import { IAllRecords } from 'src/interfaces/ContentInterface'
import { Ref, computed, ref } from 'vue'

const apiEndpoint = '/admin/management/contents'

export const useContentStore = defineStore('contentStore', () => {
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
  }

  return {
    getAllRecords,
    handleIndex,
  }
})
