import { defineStore } from 'pinia';
import { api } from 'src/boot/axios';
import { generalEndpoint } from 'src/api/settings';
import { handleNotificationSystem, handleNotificationSystemLog } from 'src/library/NotificationSystem/main';

const fullApiUrl: string = generalEndpoint

const useGeneralStore = defineStore('generalStore', {
  state: () => ({
    allRecords: {},
    createRecord: {},
    singleRecord: {},
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
      const apiResponse: unknown | void =
        await api.get(fullApiUrl)
          .then(response => {
            this.allRecords = response.data.results
            return this.allRecords
          })
          .catch((error) => {
            handleNotificationSystem(error.name, error.message, 'negative', 'bottom', true, error.response?.data)
            console.error(`${handleNotificationSystemLog.value('negative', useGeneralStore.$id, error)}`)
          })
      return apiResponse
    },

    async createRecord() {
      //
    },

    async findRecord() {
      //
    },

    async updateRecord() {
      //
    },

    async deleteRecord() {
      //
    }
  },
});

export { useGeneralStore };
