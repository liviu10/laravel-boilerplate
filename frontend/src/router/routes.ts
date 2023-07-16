import { RouteRecordRaw } from 'vue-router';
import adminSettings from 'src/router/adminSettings';

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
          icon: 'home'
        },
      },

      // Admin settings urls
      ...adminSettings,
    ],
  },

  // Capture and display an error message
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue'),
  },
];

export default routes;
