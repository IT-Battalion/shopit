import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router";
import Login from "../views/Login.vue";
import Products from "../views/Products.vue";
import Main from "../views/layout/Main.vue";
import { user } from "../stores/user";
import ProductOverview from "../components/ProductOverview.vue";
import {endLoad as complete, initLoad, onLoaded} from "../loader";

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
            meta: {
              initLoad: false,
              endLoad: false,
            }
          },
          {
            path: "product/:name",
            name: "product",
            component: ProductOverview,
            meta: {
              endLoad: false,
            }
          }
        ]
      },
      {
        path: "/admin/",
        name: "admin",
        component: () =>
          import("../views/layout/Admin.vue"),

        children: [
          {
            path: "",
            name: "ProfilePage",
            component: () =>
              import("../components/ProfilePage.vue"),
          }
        ]
      },
      {
        path: "/order/",
        name: "order",
        component: () =>
          import("../views/layout/Order.vue"),
      }
    ],
  },
];

const router = createRouter({
  history: createWebHistory(),
  scrollBehavior: (to, from, savedPosition) => {
    const sameSite = to.path == from.path && (from.hash || Object.entries(from.meta).length);
    console.log('startScroll');
    console.log(to, from, savedPosition, sameSite);
    if (sameSite) {
      console.log('scroll');
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
        };
      } else {
        return {
          top: 0,
          left: 0,
          behavior: 'smooth',
        };
      }
    } else {
      window.scroll({top: 0, left: 0,});
      return onLoaded().then(() => {
        console.log('loaded');
        console.log('scroll');
        if (savedPosition) {
          console.log('saved');
          return savedPosition;
        } else if (to.hash) {
          console.log('element');
          return {
            el: to.hash,
          };
        } else {
          return {
            top: 0,
            left: 0,
          };
        }
      });
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

router.beforeEach((to, from, next) => {
  const showLoader = 'initLoad' in to.meta ? to.meta.initLoad : true;
  if (showLoader) {
    initLoad();
  }

  next();
})

router.afterEach(route => {
  const showLoader = 'initLoad' in route.meta ? route.meta.initLoad : true;
  const endLoad = showLoader && ('endLoad' in route.meta ? route.meta.endLoad : true);
  if (endLoad) {
    complete();
  }
});

export default router;
