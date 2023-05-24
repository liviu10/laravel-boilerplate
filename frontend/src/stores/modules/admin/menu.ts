import { defineStore } from 'pinia';
import { api } from 'src/boot/axios';

// Import: interfaces, notification system and other settings
import AdminMenuInterface from 'src/interfaces/AdminMenuInterface';
import { ApiSettingsEndpoints } from 'src/api/settings';
import { notificationSystem } from 'src/library/NotificationSystem';

const adminMenuStore = defineStore('adminMenu', {
  state: () => ({
    adminMenu: {} as AdminMenuInterface,
  }),
  getters: {
    getAdminMenu: (state) => state.adminMenu,
  },
  actions: {
    /**
     * Fetches the admin menu from the API.
     * @returns Promise<void | AdminMenuInterface>. A promise that resolves
     * with the admin menu data or void if there is an error.
     */
    async fetchAdminMenu(): Promise<void | AdminMenuInterface> {
      const apiEndpoint: string = ApiSettingsEndpoints.ADMIN_MENU;
      const fullApiUrl: string = apiEndpoint;
      const apiResponse: AdminMenuInterface | void = await api
        .get(fullApiUrl)
        .then((response) => {
          if (response.data.count === 0) {
            const notificationTitle = 'Warning';
            const notificationMessage = 'There are no menus to display';
            notificationSystem(
              notificationTitle,
              notificationMessage,
              'warning'
            );
          } else {
            this.adminMenu = response.data.menu;
            return this.adminMenu;
          }
        })
        .catch((error) => {
          console.log(
            '--> Error response admin menu: ',
            error.message,
            error.response?.data
          );
          console.log('--> Error request admin menu: ', error.request);
          console.log('--> Error general admin menu: ', error.message);
          notificationSystem(
            error.name,
            error.message,
            'negative',
            error.response?.data
          );
        });
      return apiResponse;
    },
  },
});

export { adminMenuStore };
