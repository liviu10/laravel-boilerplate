import { defineStore } from 'pinia';
import { api } from 'src/boot/axios'
import { applicationUserSettings, usersEndpoint } from 'src/api/userSettings';
import { PaginatedResultsInterface, FilterInterface } from 'src/interfaces/ApiResponseInterface';
import { notificationSystem } from 'src/library/NotificationSystem/NotificationSystem';
import { UserInterface } from 'src/interfaces/UserInterface';

const fullApiUrl = applicationUserSettings + usersEndpoint

const useUserStore = defineStore('userStore', {
  state: () => ({
    allRecords: {} as PaginatedResultsInterface,
    userIsAuthenticated: false as boolean,
    allFilters: [] as FilterInterface[],
    appliedFilters: [] as Pick<FilterInterface, 'key' | 'value'>[],
    createRecord: {},
    singleRecord: {} as UserInterface,
    updateRecord: {},
    deleteRecord: {},
  }),
  getters: {
    getAllRecords: (state) => state.allRecords,
    getAllFilters: (state) => state.allFilters,
    getAppliedFilters: (state) => state.appliedFilters,
    getCreatRecord: (state) => state.createRecord,
    getSingleRecord: (state) => state.singleRecord,
    getUpdateRecord: (state) => state.updateRecord,
    getDeleteRecord: (state) => state.deleteRecord,
  },
  actions: {
    async getRecords(search?: Pick<FilterInterface, 'key' | 'value'>[] | undefined) {
      let searchQuery: Record<string, string | number | null> = {};
      if (search && search.length) {
        const savedSearch: string | null = localStorage.getItem('user-filters')
        if (savedSearch && savedSearch !== null) {
          const existingSearchQuery: Record<string, string | number | null> = JSON.parse(savedSearch);
          searchQuery = search.reduce((query, filter) => {
            query[filter.key] = filter.value;
            return query;
          }, {} as Record<string, string | number | null>);
          Object.assign(searchQuery, existingSearchQuery)
          localStorage.setItem('user-filters', JSON.stringify(searchQuery));
        } else {
          searchQuery = search.reduce((query, filter) => {
            query[filter.key] = filter.value;
            return query;
          }, {} as Record<string, string | number | null>);
          localStorage.setItem('user-filters', JSON.stringify(searchQuery));
        }
      } else {
        const savedSearch: string | null = localStorage.getItem('user-filters')
        if (savedSearch && savedSearch !== null) {
          const existingSearchQuery: Record<string, string | number | null> = JSON.parse(savedSearch);
          Object.assign(searchQuery, existingSearchQuery)
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
            notificationSystem(error.name, error.message, 'negative', 'bottom', true, error.response?.data)
            console.log(`User error message: ${error.message}, response: ${error.response?.data}, request: ${error.request}`)
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
            debugger;
            return this.singleRecord
          })
          .catch((error) => {
            notificationSystem(error.name, error.message, 'negative', 'bottom', true, error.response?.data)
            console.log(`User error message: ${error.message}, response: ${error.response?.data}, request: ${error.request}`)
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
