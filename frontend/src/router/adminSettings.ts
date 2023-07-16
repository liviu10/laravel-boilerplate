import { RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
  {
    path: '/admin',
    meta: {
      title: 'admin.settings.title',
      caption: 'admin.settings.description',
      icon: 'settings'
    },
    children: [
      {
        path: '/admin/settings/notifications',
        name: 'NotificationsPage',
        component: () => import('pages/admin/settings/NotificationsPage.vue'),
        meta: {
          title: 'admin.settings.notifications.title',
          caption: 'admin.settings.notifications.description'
        },
      },
      {
        path: '/admin/settings/users',
        name: 'UsersPage',
        component: () => import('pages/admin/settings/UsersPage.vue'),
        meta: {
          title: 'admin.settings.users.title',
          caption: 'admin.settings.users.description'
        },
      },
      {
        path: '/admin/settings/roles-and-permissions',
        name: 'RolesAndPermissionsPage',
        component: () => import('pages/admin/settings/RolesAndPermissionsPage.vue'),
        meta: {
          title: 'admin.settings.roles_and_permissions.title',
          caption: 'admin.settings.roles_and_permissions.description'
        },
      },
    ],
  },
];

export default routes;
