import { defineStore } from 'pinia';
import { api } from 'src/boot/axios'
import { applicationUserSettings, usersEndpoint } from 'src/api/userSettings';
import { PaginatedResultsInterface, FilterInterface, CreateModelInterface } from 'src/interfaces/ApiResponseInterface';
import { notificationSystem } from 'src/library/NotificationSystem/NotificationSystem';
import { UserInterface } from 'src/interfaces/UserInterface';
import { saveFilterToLocalStorage } from 'src/library/FilterToLocalStorage/SaveFilterToLocalStorage';
import { notificationSystemLog } from 'src/library/NotificationSystem/NotificationSystemLog';

const fullApiUrl = applicationUserSettings + usersEndpoint

const useUserStore = defineStore('userStore', {
  state: () => ({
    allRecords: {} as PaginatedResultsInterface,
    userIsAuthenticated: false as boolean,
    allFilters: [] as FilterInterface[],
    appliedFilters: [] as Pick<FilterInterface, 'key' | 'value'>[],
    dataModel: [] as CreateModelInterface[],
    createRecord: {},
    singleRecord: {} as UserInterface,
    updateRecord: {},
    deleteRecord: {},
  }),
  getters: {
    getAllRecords: (state) => state.allRecords,
    getAllFilters: (state) => state.allFilters,
    getAppliedFilters: (state) => state.appliedFilters,
    getDataModel: (state) => state.dataModel,
    getCreatRecord: (state) => state.createRecord,
    getSingleRecord: (state) => state.singleRecord,
    getUpdateRecord: (state) => state.updateRecord,
    getDeleteRecord: (state) => state.deleteRecord,
  },
  actions: {
    async getRecords(search?: Pick<FilterInterface, 'key' | 'value'>[] | undefined) {
      let searchQuery: Record<string, string | number | null> = {};
      searchQuery = saveFilterToLocalStorage.value(useUserStore.$id, search)

      const apiResponse: PaginatedResultsInterface | void =
        await api.get(fullApiUrl, { params: searchQuery })
          .then(response => {
            this.allRecords = response.data.results
            this.allFilters = response.data.filters
            this.dataModel = response.data.model
            return this.allRecords
          })
          .catch((error) => {
            notificationSystem(error.name, error.message, 'negative', 'bottom', true, error.response?.data)
            console.error(`${notificationSystemLog.value('negative', useUserStore.$id, error)}`)
          })
      return apiResponse
    },

    async createRecord() {
      const payload: { [key: string]: string | number | null } = {};
      this.dataModel.forEach(item => { payload[item.key] = item.value; });

      const apiResponse: UserInterface | void =
        await api.post(fullApiUrl, payload)
          .then(response => {
            debugger;
            this.singleRecord = response.data.results[0]
            return this.singleRecord
          })
          .catch((error) => {
            Object.keys(error.response?.data.errors).forEach(key => {
              const matchingItem = this.dataModel.find(item => item.key === key);
              if (matchingItem) {
                const errorArray = error.response?.data.errors[key];
                matchingItem.errors = errorArray[0];
              }
            });
            debugger;
            notificationSystem(error.name, error.message, 'negative', 'bottom', true, error.response?.data)
            console.error(`${notificationSystemLog.value('negative', useUserStore.$id, error)}`)
          })
      return apiResponse
    },

    async findRecord(recordId: number) {
      const apiResponse: UserInterface | void =
        await api.get(fullApiUrl + '/' + recordId)
          .then(response => {
            this.singleRecord = response.data.results[0]
            return this.singleRecord
          })
          .catch((error) => {
            notificationSystem(error.name, error.message, 'negative', 'bottom', true, error.response?.data)
            console.error(`${notificationSystemLog.value('negative', useUserStore.$id, error)}`)
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
