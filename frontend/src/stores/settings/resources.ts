// Import vue related utilities
import { defineStore } from 'pinia'
import { api } from 'src/boot/axios'
import { Ref, computed, ref } from 'vue'

// Import library utilities, interfaces and components
import { IAllRecords } from 'src/interfaces/ResourceInterface'
import { TResourceType } from 'src/interfaces/BaseInterface'

const apiEndpoint = '/admin/settings/resources'

export const useResourceStore = defineStore('resourceStore', () => {
  // State
  const allRecords: Ref<IAllRecords['results']> = ref([])
  const apiEndpoints: Ref<IAllRecords['results']> = ref([])
  const menus: Ref<IAllRecords['results']> = ref([])

  // Getters
  const getAllRecords = computed(() => allRecords.value)
  const getApiEndpoints = computed(() => apiEndpoints.value)
  const getMenus = computed(() => menus.value)

  // Actions

  async function handleIndex() {
    console.log('-> handleIndex')
  }

  async function handleApiEndpoints() {
    try {
      const response = await api.get(apiEndpoint, {
        params: {
          type: 'API' as TResourceType,
          path: 'content'
        }
      })
      apiEndpoints.value = response.data.results as IAllRecords['results']
      console.log('-> handleIndex', apiEndpoints.value)
    } catch (error) {
      console.log('-> catch', error)
    } finally {
      console.log('-> finally')
    }
  }

  async function handleMenu() {
    try {
      const response = await api.get(apiEndpoint, {
        params: {
          type: 'Menu' as TResourceType
        }
      })
      menus.value = response.data.results as IAllRecords['results']
      console.log('-> handleIndex', menus.value)
    } catch (error) {
      console.log('-> catch', error)
    } finally {
      console.log('-> finally')
    }
  }

  return {
    getAllRecords,
    getApiEndpoints,
    getMenus,
    handleIndex,
    handleApiEndpoints,
    handleMenu,
  }
})
