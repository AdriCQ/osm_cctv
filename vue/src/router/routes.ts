import { RouteRecordRaw } from 'vue-router';
import { ROUTE_NAME } from './names';

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    name: ROUTE_NAME.MAIN_HOME,
    component: () => import('layouts/MainLayout.vue'),
    children: [{ path: '', component: () => import('pages/IndexPage.vue') }],
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue'),
  },
];

export default routes;
