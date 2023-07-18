import { RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
  {
    path: '/admin',
    meta: {
      title: 'admin.application_settings.title',
      caption: 'admin.application_settings.description',
      icon: 'settings',
    },
    children: [
      {
        path: '/admin/application-settings/general',
        name: 'GeneralPage',
        component: () => import('pages/admin/application_settings/GeneralPage.vue'),
        meta: {
          title: 'admin.application_settings.general.title',
          caption: 'admin.application_settings.general.description',
        },
      },
      {
        path: '/admin/application-settings/performance',
        name: 'PerformancePage',
        component: () => import('pages/admin/application_settings/PerformancePage.vue'),
        meta: {
          title: 'admin.application_settings.performance.title',
          caption: 'admin.application_settings.performance.description',
        },
      },
      {
        path: '/admin/application-settings/accepted-domains',
        name: 'AcceptedDomainsPage',
        component: () => import('pages/admin/application_settings/AcceptedDomainsPage.vue'),
        meta: {
          title: 'admin.application_settings.accepted_domains.title',
          caption: 'admin.application_settings.accepted_domains.description',
        },
      },
      {
        path: '/admin/application-settings/notifications',
        name: 'NotificationsPage',
        component: () => import('pages/admin/application_settings/NotificationsPage.vue'),
        meta: {
          title: 'admin.application_settings.notifications.title',
          caption: 'admin.application_settings.notifications.description',
        },
      },
      {
        path: '/admin/application-settings/emails',
        name: 'EmailsPage',
        component: () => import('pages/admin/application_settings/EmailsPage.vue'),
        meta: {
          title: 'admin.application_settings.emails.title',
          caption: 'admin.application_settings.emails.description',
        },
      },
    ],
  },
];

export default routes;
