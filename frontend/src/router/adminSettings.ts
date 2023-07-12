import { RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
  {
    path: '/admin',
    meta: {
      title: 'Settings',
      caption: 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
      icon: 'settings'
    },
    children: [
      {
        path: '/admin/settings/users',
        name: 'UsersPage',
        component: () => import('pages/admin/settings/UsersPage.vue'),
        meta: {
          title: 'All users',
          caption: 'Lorem ipsum dolor sit amet consectetur adipisicing elit.'
        },
      },
      {
        path: '/admin/settings/user-roles',
        name: 'UserRolesPage',
        component: () => import('pages/admin/settings/UserRolesPage.vue'),
        meta: {
          title: 'User roles and permissions',
          caption: 'Lorem ipsum dolor sit amet consectetur adipisicing elit.'
        },
      },
    ],
  },
];

export default routes;
