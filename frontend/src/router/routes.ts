import { RouteRecordRaw } from 'vue-router';
import management from 'src/router/management';
import communication from 'src/router/communication';
import userSettings from 'src/router/userSettings';
import applicationSettings from 'src/router/applicationSettings';

const routes: RouteRecordRaw[] = [
  {
    path: '/admin',
    component: () => import('src/layouts/AdminLayout.vue'),
    children: [
      {
        path: '/admin',
        name: 'HomePage',
        component: () => import('pages/admin/HomePage.vue'),
        meta: {
          title: 'admin.home.title',
          caption: 'admin.home.description',
          icon: 'home',
        },
      },

      // Admin management urls,
      ...management,

      // Admin communication urls,
      ...communication,

      {
        path: '/admin/reports',
        name: 'MonitoringPage',
        component: () => import('pages/admin/MonitoringPage.vue'),
        meta: {
          title: 'admin.reports.title',
          caption: 'admin.reports.description',
          icon: 'analytics',
        },
      },

      {
        path: '/admin/documentation',
        name: 'DocumentationPage',
        component: () => import('pages/admin/DocumentationPage.vue'),
        meta: {
          title: 'admin.documentation.title',
          caption: 'admin.documentation.description',
          icon: 'help',
        },
      },

      // Admin user settings urls
      ...userSettings,

      // Admin application settings urls
      ...applicationSettings,
    ],
  },

  // Capture and display an error message
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue'),
  },
];

export default routes;
