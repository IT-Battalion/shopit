import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router";
import Login from "../views/Login.vue";
import Products from "../views/Products.vue";
import Main from "../views/layout/Main.vue";
import { user } from "../stores/user";
import ProductOverview from "../components/ProductOverview.vue";
import ProfilePage from "../components/ProfilePage.vue";

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
          },
          {
            path: "product/:name",
            name: "product",
            component: ProductOverview,
          }
        ]
      },
      {
        path: "/admin/",
        name: "Admin",
        component: () =>
          import("../views/layout/Admin.vue"),

        children: [
          {
            path: "",
            name: "ProfilePage",
            component: () => ProfilePage,
          }
        ]
      }
    ],
  },
];

const router = createRouter({
  history: createWebHistory(),
  scrollBehavior: (to, from, savedPosition) => {
    console.log(to, from, savedPosition);
    if (savedPosition) {
      console.log('saved');
      return savedPosition;
    } else if (to.hash) {
      console.log('element');
      console.log({
        el: to.hash,
        behavior: 'smooth',
      });
      return {
        el: to.hash,
        behavior: 'smooth',
      }
    } else {
      return {
        top: 0,
        left: 0,
        behavior: 'smooth',
      }
    }
  },
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
