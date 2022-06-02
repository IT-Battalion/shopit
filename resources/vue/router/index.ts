import {createRouter, createWebHistory, RouteLocationRaw, RouteRecordRaw} from "vue-router";
import {endLoad, endLoad as complete, initLoad, onLoaded, reset} from "../loader";
import {store} from "../store";
import {pick} from "lodash";

export function redirectRouteAfterLogin(): RouteLocationRaw {
  const lastActiveRoute = history.state.to!;
  return lastActiveRoute ? JSON.parse(lastActiveRoute) : {name: "Home"};
}

const routes: Array<RouteRecordRaw> = [
  {
    path: "/login",
    name: "Login",
    component: () =>
      import(/* webpackChunkName: "login" */ "../views/Login.vue"),
    meta: {
      redirectWhenAuthenticated: true,
      redirectTo: "Home",
    }
  },
  {
    path: "/",
    name: "Main",
    component: () =>
      import(/* webpackChunkName: "products" */ "../views/layout/Main.vue"),
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
          import(/* webpackChunkName: "products" */ "../views/layout/Home.vue"),

        children: [
          {
            path: "",
            name: "Products",
            component: () =>
              import(/* webpackChunkName: "products" */ "../views/Products.vue"),
            meta: {
              initLoad: false,
              endLoad: false,
            }
          },
          {
            path: "products/:name",
            name: "Product",
            component: () =>
              import(/* webpackChunkName: "products" */ "../views/ProductPage.vue"),
            meta: {
              initLoad: false,
              endLoad: false,
            }
          },
          {
            path: "/shopping-cart",
            name: "Create Order",
            component: () =>
              import(/* webpackChunkName: "products" */ "../views/OrderCreateForm.vue"),
          },
        ]
      },
      {
        path: "/profile/",
        name: "profile",
        component: () =>
          import(/* webpackChunkName: "profile" */ "../views/layout/Profile.vue"),
        children: [
          {
            path: "",
            name: "Profile",
            component: () =>
              import(/* webpackChunkName: "profile" */ "../views/ProfilePage.vue"),
          },
          {
            path: "order-history",
            name: "OrderHistory",
            component: () =>
              import(/* webpackChunkName: "profile" */ "../views/OrderHistory.vue"),
          },
          {
            path: "orders/:id",
            name: "Order Detail",
            component: () =>
              import(/* webpackChunkName: "profile" */ "../views/Order.vue"),
          },
        ]
      },
      {
        path: "/admin/",
        name: "admin",
        component: () =>
          import(/* webpackChunkName: "admin" */ "../views/layout/Admin.vue"),
        meta: {
          requiresAdmin: true,
        },

        children: [
          {
            path: "",
            name: "Admin",
            component: () =>
              import(/* webpackChunkName: "admin" */ "../views/Dashboard.vue"),
          },
          {
            path: "invoices",
            name: "Invoices",
            component: () =>
              import(/* webpackChunkName: "admin" */ "../views/Bills.vue"),
            children: []
          },
          {
            path: "invoices/:id",
            name: "Invoice detail",
            component: () =>
              import(/* webpackChunkName: "admin" */ "../views/Bills.vue")
          },
          {
            path: "orders",
            name: "Admin Orders",
            component: () =>
              import(/* webpackChunkName: "admin" */ "../views/Orders.vue"),
          },
          {
            path: "orders/:id",
            name: "Admin Order Detail",
            component: () =>
              import(/* webpackChunkName: "admin" */ "../views/Order.vue"),
          },
          {
            path: "coupons",
            name: "Coupons",
            component: () =>
              import(/* webpackChunkName: "admin" */ "../views/Coupons.vue"),
          },
          {
            path: "categories",
            name: "CategoryManagement",
            component: () =>
              import(/* webpackChunkName: "admin" */ "../views/EditCategories.vue"),
          },
          {
            path: "users/",
            name: "UserManagement",
            component: () =>
              import(/* webpackChunkName: "admin" */ "../views/UserManagement.vue"),
            children: [],
          },
          {
            path: "users/:id",
            name: "User detail",
            component: () =>
              import(/* webpackChunkName: "admin" */ "../views/UserManagementDetail.vue"),
          },
          {
            path: "products/edit",
            name: "Edit Product",
            component: () =>
              import(/* webpackChunkName: "admin" */ "../views/ProductListAdmin.vue"),
          },
          {
            path: "products/add/",
            name: "Add Product",
            component: () =>
              import(/* webpackChunkName: "admin" */ "../views/AddProduct.vue"),
          },
        ]
      },
      {
        path: "/credits/",
        name: "credits",
        component: () =>
          import(/* webpackChunkName: "credits" */ "../views/Credits.vue"),
      },
      {
        path: "/contributors/",
        name: "contributors",
        component: () => import(/* webpackChunkName: "credits" */ "../components/Contributors.vue")
      },
      {
        path: "/impressum/",
        name: "impressum",
        component: () => import(/* webpackChunkName: "credits" */ "../views/Impressum.vue")
      },
      {
        path: "/agb/",
        name: "agb",
        component: () => import(/* webpackChunkName: "credits" */ "../views/AGB.vue")
      }
    ],
  },
];

const router = createRouter({
  history: createWebHistory(),
  scrollBehavior: (to, from, savedPosition) => {
    const sameSite = to.path == from.path && from.hash && Object.entries(from.meta).length;
    if (sameSite) {
      if (savedPosition) {
        return savedPosition;
      } else if (to.hash) {
        return {
          el: to.hash,
          behavior: "smooth",
        };
      } else {
        return {
          top: 0,
          left: 0,
          behavior: "smooth",
        };
      }
    } else {
      if (savedPosition) {
        window.scroll(savedPosition);
      } else if (to.hash) {
        document.querySelector(to.hash)?.scrollIntoView({
          behavior: "smooth",
        });
      } else {
        window.scroll({
          top: 0,
          left: 0,
          behavior: "smooth",
        });
      }
      return onLoaded().then(() => {
        if (savedPosition) {
          return savedPosition;
        } else if (to.hash) {
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
  reset();
  const showLoader = "initLoad" in to.meta ? to.meta.initLoad : true;
  if (showLoader) {
    initLoad();
  }

  next();
});

router.beforeEach(async (to, from, next) => {
  await (store as any).restored;
  next();
});

router.beforeEach((to, from, next) => {
  const {user, isLoggedIn} = store.state.userState;

  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!isLoggedIn) {
      router.push({
        name: "Login",
        state: {to: JSON.stringify(pick(to, ["query", "hash", "path", "replace", "force", "state", "name", "params"]))},
      }).then(next);
      return;
    }

    if (to.matched.some(record => record.meta.requiresAdmin) && !user?.isAdmin) {
      next(false);
      return;
    }
  }
  if (to.matched.some(record => record.meta.redirectWhenAuthenticated)
    && isLoggedIn) {
    next(redirectRouteAfterLogin());
    return;
  }
  next();
});

router.afterEach(route => {
  const showLoader = "initLoad" in route.meta ? route.meta.initLoad : true;
  const endLoad = showLoader && ("endLoad" in route.meta ? route.meta.endLoad : true);
  if (endLoad) {
    complete();
  }
});

export default router;
