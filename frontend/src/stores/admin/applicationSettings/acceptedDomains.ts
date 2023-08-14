import { defineStore } from 'pinia';
import { api } from 'src/boot/axios'
import { applicationApiSettings, acceptedDomainsEndpoint } from 'src/api/apiSettings';
import { PaginatedResultsInterface, FilterInterface } from 'src/interfaces/ApiResponseInterface';
import { notificationSystem } from 'src/library/NotificationSystem/NotificationSystem';
import { AcceptedDomainInterface } from 'src/interfaces/ApplicationInterface';
import { saveFilterToLocalStorage } from 'src/library/SaveFilterToLocalStorage/SaveFilterToLocalStorage';
import { notificationSystemLog } from 'src/library/NotificationSystem/NotificationSystemLog';

const fullApiUrl = applicationApiSettings + acceptedDomainsEndpoint

const useAcceptedDomainStore = defineStore('acceptedDomainStore', {
  state: () => ({
    allRecords: {} as PaginatedResultsInterface,
    userIsAuthenticated: false as boolean,
    allFilters: [] as FilterInterface[],
    appliedFilters: [] as Pick<FilterInterface, 'key' | 'value'>[],
    createRecord: {},
    singleRecord: {} as AcceptedDomainInterface,
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
      searchQuery = saveFilterToLocalStorage.value(useAcceptedDomainStore.$id, search)

      const apiResponse: PaginatedResultsInterface | void =
        await api.get(fullApiUrl, { params: searchQuery })
          .then(response => {
            this.allRecords = response.data.results
            this.allFilters = response.data.filters
            return this.allRecords
          })
          .catch((error) => {
            notificationSystem(error.name, error.message, 'negative', 'bottom', true, error.response?.data)
            console.error(`${notificationSystemLog.value('negative', useAcceptedDomainStore.$id, error)}`)
          })
      return apiResponse
    },

    async createRecord() {
      debugger;
    },

    async findRecord(recordId: number) {
      const apiResponse: AcceptedDomainInterface | void =
        await api.get(fullApiUrl + '/' + recordId)
          .then(response => {
            this.singleRecord = response.data.results[0]
            return this.singleRecord
          })
          .catch((error) => {
            notificationSystem(error.name, error.message, 'negative', 'bottom', true, error.response?.data)
            console.error(`${notificationSystemLog.value('negative', useAcceptedDomainStore.$id, error)}`)
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

export { useAcceptedDomainStore };
