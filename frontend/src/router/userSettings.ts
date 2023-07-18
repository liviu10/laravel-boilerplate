import { RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
  {
    path: '/admin',
    meta: {
      title: 'admin.user_settings.title',
      caption: 'admin.user_settings.description',
      icon: 'group',
    },
    children: [
      {
        path: '/admin/user-settings/user-profile',
        name: 'UserProfilePage',
        component: () => import('pages/admin/user_settings/UserProfilePage.vue'),
        meta: {
          title: 'admin.user_settings.user_profile.title',
          caption: 'admin.user_settings.user_profile.description',
        },
      },
      {
        path: '/admin/user-settings/users',
        name: 'UsersPage',
        component: () => import('pages/admin/user_settings/UsersPage.vue'),
        meta: {
          title: 'admin.user_settings.users.title',
          caption: 'admin.user_settings.users.description',
        },
      },
      {
        path: '/admin/user-settings/roles-and-permissions',
        name: 'RolesAndPermissionsPage',
        component: () =>
          import('pages/admin/user_settings/RolesAndPermissionsPage.vue'),
        meta: {
          title: 'admin.user_settings.roles_and_permissions.title',
          caption: 'admin.user_settings.roles_and_permissions.description',
        },
      },
    ],
  },
];

export default routes;
