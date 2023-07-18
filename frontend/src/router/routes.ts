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
      {
        path: '/admin/page-configurations',
        name: 'PageConfigurationPage',
        component: () => import('pages/admin/PageConfigurationPage.vue'),
        meta: {
          title: 'admin.page_configuration.title',
          caption: 'admin.page_configuration.description',
          icon: 'description'
        },
      },
      {
        path: '/admin/documentation',
        name: 'DocumentationPage',
        component: () => import('pages/admin/DocumentationPage.vue'),
        meta: {
          title: 'admin.documentation.title',
          caption: 'admin.documentation.description',
          icon: 'help'
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
