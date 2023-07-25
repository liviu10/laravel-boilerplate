import { defineStore } from 'pinia';
import { api } from 'src/boot/axios'
import { applicationCommunication, newsletterEndpoint } from 'src/api/communication';
import { PaginatedResultsInterface } from 'src/interfaces/ApiResponseInterface';
import { notificationSystem } from 'src/library/NotificationSystem';
import { NewsletterInterface } from 'src/interfaces/NewsletterInterface';

const fullApiUrl = applicationCommunication + newsletterEndpoint

const useNewsletterStore = defineStore('newsletterStore', {
  state: () => ({
    allRecords: {} as PaginatedResultsInterface,
    createRecord: {},
    singleRecord: {} as NewsletterInterface,
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
            console.log('--> Response newsletter endpoint: ', error.message, error.response?.data)
            console.log('--> Request newsletter endpoint: ', error.request)
          })
      return apiResponse
    },

    async createRecord() {
      debugger;
    },

    async findRecord(recordId: number) {
      const apiResponse: NewsletterInterface | void =
        await api.get(fullApiUrl + '/' + recordId)
          .then(response => {
            this.singleRecord = response.data.results[0]
            return this.singleRecord
          })
          .catch((error) => {
            notificationSystem(error.name, error.message, 'negative', error.response?.data)
            console.log('--> Response newsletter endpoint: ', error.message, error.response?.data)
            console.log('--> Request newsletter endpoint: ', error.request)
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

export { useNewsletterStore };
