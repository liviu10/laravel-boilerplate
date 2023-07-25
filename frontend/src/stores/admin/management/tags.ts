import { defineStore } from 'pinia';
import { api } from 'src/boot/axios'
import { applicationManagement, tagsEndpoint } from 'src/api/management';
import { PaginatedResultsInterface } from 'src/interfaces/ApiResponseInterface';
import { notificationSystem } from 'src/library/NotificationSystem';
import { TagsInterface } from 'src/interfaces/TagsInterface';

const fullApiUrl = applicationManagement + tagsEndpoint

const useTagStore = defineStore('tagStore', {
  state: () => ({
    allRecords: {} as PaginatedResultsInterface,
    createRecord: {},
    singleRecord: {} as TagsInterface,
    updateRecord: {},
    deleteRecord: {},
  }),
  getters: {
    getAllRecords: (state) => state.allRecords,
    getCreatRecord: (state) => state.createRecord,
    getSingleRecord: (state) => state.singleRecord,
    getUpdateRecord: (state) => state.updateRecord,
    getDeleteRecord: (state) => state.deleteRecord,
  },
  actions: {
    async getRecords() {
      const apiResponse: PaginatedResultsInterface | void =
        await api.get(fullApiUrl)
          .then(response => {
            this.allRecords = response.data.results
            return this.allRecords
          })
          .catch((error) => {
            notificationSystem(error.name, error.message, 'negative', error.response?.data)
            console.log('--> Response tags endpoint: ', error.message, error.response?.data)
            console.log('--> Request tags endpoint: ', error.request)
          })
      return apiResponse
    },

    async createRecord() {
      debugger;
    },

    async findRecord(recordId: number) {
      const apiResponse: TagsInterface | void =
        await api.get(fullApiUrl + '/' + recordId)
          .then(response => {
            this.singleRecord = response.data.results[0]
            return this.singleRecord
          })
          .catch((error) => {
            notificationSystem(error.name, error.message, 'negative', error.response?.data)
            console.log('--> Response tags endpoint: ', error.message, error.response?.data)
            console.log('--> Request tags endpoint: ', error.request)
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

export { useTagStore };
