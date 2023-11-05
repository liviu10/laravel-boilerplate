import { RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
  {
    path: '/admin/communication',
    children: [
      {
        path: '/admin/communication/contact',
        name: 'AdminCommunicationContactPage',
        component: () => import('pages/AdminCommunicationContactPage.vue'),
      },
      {
        path: '/admin/communication/newsletter',
        name: 'AdminCommunicationNewsletterPage',
        component: () => import('pages/AdminCommunicationNewsletterPage.vue'),
      },
      {
        path: '/admin/communication/reviews',
        name: 'AdminCommunicationReviewsPage',
        component: () => import('pages/AdminCommunicationReviewPage.vue'),
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
