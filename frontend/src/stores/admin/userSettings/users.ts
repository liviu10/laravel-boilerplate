import { defineStore } from 'pinia';
import { $users } from 'src/api';

const useUserStore = defineStore('userStore', {
  state: () => ({
    allRecords: {},
    createRecord: {},
    findRecord: {},
    updateRecord: {},
    deleteRecord: {},
  }),
  getters: {
    getAllRecords: (state) => state.allRecords,
    getCreatRecord: (state) => state.createRecord,
    getFindRecord: (state) => state.findRecord,
    getUpdateRecord: (state) => state.updateRecord,
    getDeleteRecord: (state) => state.deleteRecord,
  },
  actions: {
    async getRecords() {
      await $users.users.get(1)
      debugger;
    },

    async createRecord() {
      debugger;
    },

    async findRecord() {
      await $users.users.find()
      debugger;
    },

    async updateRecord() {
      debugger;
    },

    async deleteRecord() {
      debugger;
    }
  },
});

export { useUserStore };
