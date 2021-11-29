import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router";
import Login from "../views/Login.vue";
import Products from "../views/Products.vue";
import Main from "../views/layout/Main.vue";
import { user } from "../stores/user";

const routes: Array<RouteRecordRaw> = [
  {
    path: "/login",
    name: "Login",
    component: Login,
    meta: {
      redirectWhenAuthenticated: true,
      redirectTo: 'Home',
    }
  },
  {
    path: "/",
    name: "Main",
    component: Main,
    meta: {
      requiresAuth: true,
    },

    children: [
      {
        path: "/",
        name: "Home",
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () =>
          import("../views/layout/Home.vue"),

        children: [
          {
            path: "",
            name: "Products",
            component: Products,
          }
        ]
      },
    ]
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
    if (to.matched.some(record => record.meta.redirectWhenAuthenticated)
      && user.isLoggedIn) {
      next({
        name: to.meta.redirectTo as string,
      });
      return;
    }
    next();
  }
});

export default router;
