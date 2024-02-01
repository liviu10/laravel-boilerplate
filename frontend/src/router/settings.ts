import { RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
  {
    path: '/admin/settings',
    children: [
      {
        path: '/admin/settings/users',
        children: [
          {
            path: '',
            name: 'AdminSettingUserIndexPage',
            component: () => import('pages/AdminSettingUserIndexPage.vue'),
          },
          {
            path: 'profile',
            name: 'AdminSettingUserProfilePage',
            component: () => import('pages/AdminSettingUserProfilePage.vue'),
          },
        ]
      },
      {
        path: '/admin/settings/roles',
        name: 'AdminSettingRoleIndexPage',
        component: () => import('pages/AdminSettingRoleIndexPage.vue'),
      },
      {
        path: '/admin/settings/general',
        name: 'AdminSettingGeneralIndexPage',
        component: () => import('pages/AdminSettingGeneralIndexPage.vue'),
      },
      {
        path: '/admin/settings/accepted-domains',
        name: 'AdminSettingAcceptedDomainIndexPage',
        component: () => import('pages/AdminSettingAcceptedDomainIndexPage.vue'),
      },
      {
        path: '/admin/settings/notifications',
        name: 'AdminSettingNotificationIndexPage',
        component: () => import('pages/AdminSettingNotificationIndexPage.vue'),
      },
      {
        path: '/admin/settings/resource',
        name: 'AdminSettingResourceIndexPage',
        component: () => import('pages/AdminSettingResourceIndexPage.vue'),
      },
      {
        path: '/admin/settings/configuration/resources',
        children: [
          {
            path: '',
            name: 'AdminSettingConfigurationResourceIndexPage',
            component: () => import('pages/AdminSettingConfigurationResourceIndexPage.vue'),
            props: (route) => ({ resource: route.query.resource as string | undefined }),
          },
          {
            path: 'create',
            name: 'AdminSettingConfigurationResourceCreatePage',
            component: () => import('pages/AdminSettingConfigurationResourceCreatePage.vue'),
            props: route => ({ key: route.query.key }),
          },
          {
            path: 'show/:id',
            name: 'AdminSettingConfigurationResourceShowPage',
            component: () => import('pages/AdminSettingConfigurationResourceShowPage.vue'),
          },
          {
            path: 'edit/:id?',
            name: 'AdminSettingConfigurationResourceEditPage',
            component: () => import('pages/AdminSettingConfigurationResourceEditPage.vue'),
            props: route => ({ key: route.query.key }),
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
