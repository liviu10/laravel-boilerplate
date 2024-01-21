import { RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
  {
    path: '/admin/communication',
    children: [
      {
        path: '/admin/communication/contact',
        name: 'AdminCommunicationContactIndexPage',
        component: () => import('pages/AdminCommunicationContactIndexPage.vue'),
      },
      {
        path: '/admin/communication/newsletter',
        name: 'AdminCommunicationNewsletterIndexPage',
        component: () => import('pages/AdminCommunicationNewsletterIndexPage.vue'),
      },
      {
        path: '/admin/communication/reviews',
        name: 'AdminCommunicationReviewsIndexPage',
        component: () => import('pages/AdminCommunicationReviewIndexPage.vue'),
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
