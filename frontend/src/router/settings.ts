import { RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
  {
    path: '/admin/settings',
    children: [
      {
        path: '/admin/settings/user-profile',
        name: 'AdminSettingUserProfilePage',
        component: () => import('pages/AdminSettingUserProfilePage.vue'),
      },
      {
        path: '/admin/settings/users',
        name: 'AdminSettingUserPage',
        component: () => import('pages/AdminSettingUserPage.vue'),
      },
      {
        path: '/admin/settings/roles-and-permissions',
        name: 'AdminSettingRoleAndPermissionPage',
        component: () => import('pages/AdminSettingRoleAndPermissionPage.vue'),
      },
      {
        path: '/admin/settings/general',
        name: 'AdminSettingGeneralPage',
        component: () => import('pages/AdminSettingGeneralPage.vue'),
      },
      {
        path: '/admin/settings/accepted-domains',
        name: 'AdminSettingAcceptedDomainPage',
        component: () => import('pages/AdminSettingAcceptedDomainPage.vue'),
      },
      {
        path: '/admin/settings/notifications',
        name: 'AdminSettingNotificationPage',
        component: () => import('pages/AdminSettingNotificationPage.vue'),
      },
      {
        path: '/admin/settings/templates',
        name: 'AdminSettingTemplatePage',
        component: () => import('pages/AdminSettingTemplatePage.vue'),
      },
      {
        path: '/admin/settings/configuration-resources',
        children: [
          {
            path: '',
            name: 'AdminSettingConfigurationResourcePage',
            component: () => import('pages/AdminSettingConfigurationResourcePage.vue'),
            props: (route) => ({ resource: route.query.resource as string | undefined }),
          },
          {
            path: 'create',
            name: 'AdminSettingConfigurationResourceCreatePage',
            component: () => import('pages/AdminSettingConfigurationResourceCreatePage.vue'),
          },
          {
            path: 'show/:id',
            name: 'AdminSettingConfigurationResourceShowPage',
            component: () => import('pages/AdminSettingConfigurationResourceShowPage.vue'),
          },
          {
            path: 'edit/:id',
            name: 'AdminSettingConfigurationResourceEditPage',
            component: () => import('pages/AdminSettingConfigurationResourceEditPage.vue'),
          },
        ]
      },
    ],
  },

  // Capture and display an error message
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue'),
  },
];

export default routes;
