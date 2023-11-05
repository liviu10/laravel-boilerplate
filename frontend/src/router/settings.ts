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
        path: '/admin/settings/performance',
        name: 'AdminSettingPerformancePage',
        component: () => import('pages/AdminSettingPerformancePage.vue'),
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
    ],
  },

  // Capture and display an error message
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue'),
  },
];

export default routes;
