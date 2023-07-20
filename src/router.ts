import type { RouteRecordRaw } from 'vue-router'
import { createRouter, createWebHistory } from 'vue-router'

import Prodcuts from './views/admin/Prodcuts.vue'
import Forms from './views/admin/Forms.vue'
import Category from './views/admin/Category.vue'
import Tables from './views/admin/Tables.vue'
import UIElements from './views/admin/UIElements.vue'
import Login from './views/admin/Login.vue'
import Card from './views/Products.vue'

const routes: RouteRecordRaw[] = [
  {
    path: '/login',
    name: 'Login',
    component: Login,
    meta: { layout: 'empty' },
  },
  {
    path: '/',
    component: Prodcuts,
  },
  {
    path: '/admin/',
    name: 'admin',
    component: Prodcuts,
  },
  {
    path: '/admin/prodcuts',
    name: 'Prodcuts',
    //redirect: '/login',
    component: Prodcuts,
  },
  {
    path: '/admin/forms',
    name: 'Forms',
    component: Forms,
  },
  {
    path: '/admin/category',
    name: 'Category',
    component: Category,
  },
  {
    path: '/prodcuts',
    name: 'Cards',
    component: Card,
    meta: { layout: 'page' },
  },
  {
    path: '/admin/tables',
    name: 'Tables',
    component: Tables,
  },
  {
    path: '/admin/ui-elements',
    name: 'UIElements',
    component: UIElements,
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
