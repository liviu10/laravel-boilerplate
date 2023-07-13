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
          title: 'Dashboard',
          caption: 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
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
