import { defineStore } from 'pinia';
import { api } from 'src/boot/axios'
import { applicationUserSettings, usersEndpoint } from 'src/api/userSettings';
import { PaginatedResultsInterface, FilterInterface } from 'src/interfaces/ApiResponseInterface';
import { notificationSystem } from 'src/library/NotificationSystem';
import { UserInterface } from 'src/interfaces/UserInterface';
import { Cookies } from 'quasar';

const fullApiUrl = applicationUserSettings + usersEndpoint

const useUserStore = defineStore('userStore', {
  state: () => ({
    allRecords: {} as PaginatedResultsInterface,
    allFilters: [] as FilterInterface[],
    createRecord: {},
    singleRecord: {} as UserInterface,
    updateRecord: {},
    deleteRecord: {},
  }),
  getters: {
    getAllRecords: (state) => state.allRecords,
    getAllFilters: (state) => state.allFilters,
    getCreatRecord: (state) => state.createRecord,
    getSingleRecord: (state) => state.singleRecord,
    getUpdateRecord: (state) => state.updateRecord,
    getDeleteRecord: (state) => state.deleteRecord,
  },
  actions: {
    async getRecords(appliedFilters?: string | undefined) {
      const searchQuery: Record<string, number | string | null> = {}
      if (appliedFilters && appliedFilters !== undefined) {
        Cookies.set('all-user-filters', appliedFilters)
        const savedSearchQuery: Pick<FilterInterface, 'key' | 'value'>[] = Cookies.get('all-user-filters')
        if (savedSearchQuery && savedSearchQuery !== undefined) {
          savedSearchQuery.forEach((filter: Pick<FilterInterface, 'key' | 'value'>) => {
            searchQuery[filter.key] = filter.value
          })
        }
      }

      const apiResponse: PaginatedResultsInterface | void =
        await api.get(fullApiUrl, { params: searchQuery })
          .then(response => {
            this.allRecords = response.data.results
            this.allFilters = response.data.filters
            return this.allRecords
          })
          .catch((error) => {
            notificationSystem(error.name, error.message, 'negative', error.response?.data)
            console.log('--> Response users endpoint: ', error.message, error.response?.data)
            console.log('--> Request users endpoint: ', error.request)
          })
      return apiResponse
    },

    async createRecord() {
      debugger;
    },

    async findRecord(recordId: number) {
      const apiResponse: UserInterface | void =
        await api.get(fullApiUrl + '/' + recordId)
          .then(response => {
            this.singleRecord = response.data.results[0]
            return this.singleRecord
          })
          .catch((error) => {
            notificationSystem(error.name, error.message, 'negative', error.response?.data)
            console.log('--> Response users endpoint: ', error.message, error.response?.data)
            console.log('--> Request users endpoint: ', error.request)
          })
      return apiResponse
    },

    async updateRecord(recordId: number) {
      console.log('--> updateRecord', recordId)
    },

    async deleteRecord(recordId: number) {
      console.log('--> deleteRecord', recordId)
    }
  },
});

export { useUserStore };
