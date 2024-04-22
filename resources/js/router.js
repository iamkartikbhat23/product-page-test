import { createRouter, createWebHashHistory } from 'vue-router'

const router = createRouter({
  history: createWebHashHistory(),
  routes: [
    {
      path: '/',
      redirect: () => ({ name: 'products' })
    },
    {
      path: '/listProducts',
      name: 'listProducts',
      component: () => import('./views/ListProducts.vue')
    },
    {
      path: '/addProduct',
      name: 'addProduct',
      component: () => import('./views/AddProduct.vue')
    },
    {
      path: '/editProduct/:id',
      name: 'editProduct',
      component: () => import('./views/EditProduct.vue'),
      params: true,
    },
    {
      path: '/products',
      name: 'products',
      component: () => import('./views/Products.vue')
    },
    {
      path: '/shop/product/:slug',
      name: 'product',
      component: () => import('./views/Product.vue')
    },
    {
      path: '/:pathMatch(.*)*',
      name: 'errorPage',
      component: () => import('./views/ErrorPage.vue'),
      props: (route) => ({ code: route.query.code })
    }
  ],
})

export default router;
