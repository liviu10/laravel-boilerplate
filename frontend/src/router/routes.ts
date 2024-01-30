import { RouteRecordRaw } from 'vue-router';
import management from './management';
import communication from './communication';
import settings from './settings';

const routes: RouteRecordRaw[] = [
  // Admin routes
  {
    path: '/admin',
    component: () => import('src/layouts/AdminLayout.vue'),
    children: [
      {
        path: '/admin',
        name: 'AdminHomePage',
        component: () => import('pages/AdminHomePage.vue'),
      },

      // Management routes
      ...management,

      // Communication routes
      ...communication,

      {
        path: '/admin/documentation',
        name: 'AdminDocumentationPage',
        component: () => import('pages/AdminDocumentationPage.vue'),
      },

      // Settings routes
      ...settings,
    ],
  },

  // Client routes
  {
    path: '/',
    component: () => import('src/layouts/ClientLayout.vue'),
    children: [
      {
        path: 'login',
        name: 'ClientLoginPage',
        component: () => import('pages/ClientLoginPage.vue'),
      },
      {
        path: '',
        name: 'ClientHomePage',
        component: () => import('pages/ClientHomePage.vue'),
      }
    ],
  },

  // Capture and display an error message
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue'),
  },
];

export default routes;
