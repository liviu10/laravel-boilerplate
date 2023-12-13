import { RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
  {
    path: '/admin/management',
    children: [
      {
        path: '/admin/management/contents',
        children: [
          {
            path: '',
            name: 'AdminManagementContentPage',
            component: () => import('pages/AdminManagementContentPage.vue'),
          },
          {
            path: 'create',
            name: 'AdminManagementContentCreatePage',
            component: () => import('pages/AdminManagementContentCreatePage.vue'),
          },
          {
            path: 'show/:id',
            name: 'AdminManagementContentShowPage',
            component: () => import('pages/AdminManagementContentShowPage.vue'),
          },
          {
            path: 'edit/:id',
            name: 'AdminManagementContentEditPage',
            component: () => import('pages/AdminManagementContentEditPage.vue'),
          },
        ],
      },
      {
        path: '/admin/management/tags',
        name: 'AdminManagementTagPage',
        component: () => import('pages/AdminManagementTagPage.vue'),
      },
      {
        path: '/admin/management/media',
        name: 'AdminManagementMediaPage',
        component: () => import('pages/AdminManagementMediaPage.vue'),
      },
      {
        path: '/admin/management/comments',
        name: 'AdminManagementCommentPage',
        component: () => import('pages/AdminManagementCommentPage.vue'),
      },
      {
        path: '/admin/management/appreciations',
        name: 'AdminManagementAppreciationPage',
        component: () => import('pages/AdminManagementAppreciationPage.vue'),
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
