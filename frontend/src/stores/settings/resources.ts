// Import vue related utilities
import { defineStore } from 'pinia'
import { api } from 'src/boot/axios'
import { Ref, computed, ref } from 'vue'

// Import library utilities, interfaces and components
import { IAllRecords } from 'src/interfaces/ResourceInterface'
import { TResourceType } from 'src/interfaces/BaseInterface'

const resourceEndpoint = '/admin/settings/resources'

export const useResourceStore = defineStore('resourceStore', () => {
  // State
  const allRecords: Ref<IAllRecords> = ref({} as IAllRecords)
  const apiEndpoint: Ref<IAllRecords['results']> = ref([] as IAllRecords['results'])
  const apiMenu: Ref<IAllRecords['results']> = ref([] as IAllRecords['results'])

  // Getters
  const getAllRecords = computed(() => allRecords.value)
  const getApiEndpoint = computed(() => apiEndpoint.value)
  const getApiMenu = computed(() => apiMenu.value)

  // Actions

  async function handleIndex() {
    console.log('-> handleIndex')
  }

  async function handleApiEndpoint(path: string) {
    try {
      const response = await api.get(resourceEndpoint, {
        params: {
          type: 'API' as TResourceType,
          path: path
        }
      })
      apiEndpoint.value = response.data.results as IAllRecords['results']
      console.log('-> handleIndex', apiEndpoint.value)
    } catch (error) {
      console.log('-> catch', error)
    } finally {
      console.log('-> finally')
    }
  }

  async function handleMenu() {
    try {
      const response = await api.get(resourceEndpoint, {
        params: {
          type: 'Menu' as TResourceType
        }
      })
      apiMenu.value = response.data.results as IAllRecords['results']
      console.log('-> handleIndex', apiMenu.value)
    } catch (error) {
      console.log('-> catch', error)
    } finally {
      console.log('-> finally')
    }
  }

  return {
    getAllRecords,
    getApiEndpoint,
    getApiMenu,
    handleIndex,
    handleApiEndpoint,
    handleMenu,
  }
})
