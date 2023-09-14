import { RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
  {
    path: '/admin/management',
    meta: {
      title: 'admin.management.title',
      caption: 'admin.management.description',
      icon: 'group_work',
    },
    children: [
      {
        path: '/admin/management/contents',
        name: 'ContentPage',
        component: () => import('pages/admin/management/ContentPage.vue'),
        meta: {
          title: 'admin.management.contents.title',
          caption: 'admin.management.contents.description',
        },
      },
      {
        path: '/admin/management/tags',
        name: 'TagsPage',
        component: () => import('pages/admin/management/TagsPage.vue'),
        meta: {
          title: 'admin.management.tags.title',
          caption: 'admin.management.tags.description',
        },
      },
      {
        path: '/admin/management/articles',
        name: 'ArticlesPage',
        component: () => import('pages/admin/management/ArticlesPage.vue'),
        meta: {
          title: 'admin.management.articles.title',
          caption: 'admin.management.articles.description',
        },
      },
      {
        path: '/admin/management/media',
        name: 'MediaPage',
        component: () => import('pages/admin/management/MediaPage.vue'),
        meta: {
          title: 'admin.management.media.title',
          caption: 'admin.management.media.description',
        },
      },
      {
        path: '/admin/management/comments',
        name: 'CommentsPage',
        component: () => import('pages/admin/management/CommentsPage.vue'),
        meta: {
          title: 'admin.management.comments.title',
          caption: 'admin.management.comments.description',
        },
      },
    ],
  },
];

export default routes;
