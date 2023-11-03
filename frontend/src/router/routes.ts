import { RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
  {
    path: '/admin',
    component: () => import('src/layouts/AdminLayout.vue'),
    children: [
      {
        path: '/admin',
        name: 'AdminHomePage',
        component: () => import('pages/AdminHomePage.vue'),
        meta: {
          title: 'admin.home.title',
          caption: 'admin.home.description',
          icon: 'home',
        },
      },
      {
        path: '/admin/settings',
        name: 'SettingsUserPage',
        component: () => import('pages/SettingsUserPage.vue'),
        meta: {
          title: 'admin.user.title',
          caption: 'admin.user.description',
          icon: 'person',
        },
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
