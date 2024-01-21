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
            name: 'AdminManagementContentIndexPage',
            component: () => import('pages/AdminManagementContentIndexPage.vue'),
            props: (route) => ({ resource: route.query.resource as string | undefined }),
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
        name: 'AdminManagementTagIndexPage',
        component: () => import('pages/AdminManagementTagIndexPage.vue'),
        props: (route) => ({ resource: route.query.resource as string | undefined }),
      },
      {
        path: '/admin/management/media',
        name: 'AdminManagementMediaIndexPage',
        component: () => import('pages/AdminManagementMediaIndexPage.vue'),
        props: (route) => ({ resource: route.query.resource as string | undefined }),
      },
      {
        path: '/admin/management/comments',
        name: 'AdminManagementCommentIndexPage',
        component: () => import('pages/AdminManagementCommentIndexPage.vue'),
        props: (route) => ({ resource: route.query.resource as string | undefined }),
      },
      {
        path: '/admin/management/appreciations',
        name: 'AdminManagementAppreciationIndexPage',
        component: () => import('pages/AdminManagementAppreciationIndexPage.vue'),
        props: (route) => ({ resource: route.query.resource as string | undefined }),
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
