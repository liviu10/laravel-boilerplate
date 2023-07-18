import { RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
  {
    path: '/admin/communication',
    meta: {
      title: 'admin.communication.title',
      caption: 'admin.communication.description',
      icon: 'forum',
    },
    children: [
      {
        path: '/admin/communication/contact-me',
        name: 'ContactMePage',
        component: () => import('pages/admin/communication/ContactMePage.vue'),
        meta: {
          title: 'admin.communication.contact.title',
          caption: 'admin.communication.contact.description',
        },
      },
      {
        path: '/admin/communication/newsletter',
        name: 'NewsletterPage',
        component: () => import('pages/admin/communication/NewsletterPage.vue'),
        meta: {
          title: 'admin.communication.newsletter.title',
          caption: 'admin.communication.newsletter.description',
        },
      },
    ],
  },
];

export default routes;
