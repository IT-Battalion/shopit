import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router";
import Login from "../views/Login.vue";
import { user } from "../stores/user";

const routes: Array<RouteRecordRaw> = [
  {
    path: "/login",
    name: "Login",
    component: Login,
  },
  {
    path: "/",
    name: "Products",
    meta: {
      requiresAuth: true,
    },
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

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!user.isLoggedIn) {
      next({
        name: 'Login',
        params: { nextUrl: to.fullPath }
      });
      return;
    }

    if (to.matched.some(record => record.meta.is_admin)) {
      if (user.isAdmin) {
        next();
      } else {
        next(from);
      }
    } else {
      next();
    }
  } else {
    next();
  }
})

export default router;
