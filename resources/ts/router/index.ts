import {createRouter, createWebHistory, RouteRecordRaw} from "vue-router";

const routes: Array<RouteRecordRaw> = [
  {
    path: "/products",
    name: "Products",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import("../views/Products.vue"),
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
