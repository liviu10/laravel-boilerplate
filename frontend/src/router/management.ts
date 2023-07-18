import { RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
  {
    path: '/admin/management',
    meta: {
      title: 'admin.management.title',
      caption: 'admin.management.description',
      icon: 'description',
    },
    children: [
      {
        path: '/admin/management/pages',
        name: 'ManagementPage',
        component: () => import('pages/admin/management/ManagementPage.vue'),
        meta: {
          title: 'admin.management.pages.title',
          caption: 'admin.management.pages.description',
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
        path: '/admin/management/comments',
        name: 'CommentsPage',
        component: () => import('pages/admin/management/CommentsPage.vue'),
        meta: {
          title: 'admin.management.comments.title',
          caption: 'admin.management.comments.description',
        },
      },
      {
        path: '/admin/management/contact-me',
        name: 'ContactMePage',
        component: () => import('pages/admin/management/ContactMePage.vue'),
        meta: {
          title: 'admin.management.contact.title',
          caption: 'admin.management.contact.description',
        },
      },
      {
        path: '/admin/management/newsletter',
        name: 'NewsletterPage',
        component: () => import('pages/admin/management/NewsletterPage.vue'),
        meta: {
          title: 'admin.management.newsletter.title',
          caption: 'admin.management.newsletter.description',
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
    ],
  },
];

export default routes;
