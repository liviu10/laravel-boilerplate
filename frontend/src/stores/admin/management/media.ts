import { defineStore } from 'pinia';

const useMediaStore = defineStore('mediaStore', {
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
      debugger;
    },

    async createRecord() {
      debugger;
    },

    async findRecord() {
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

export { useMediaStore };
