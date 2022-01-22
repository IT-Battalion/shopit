import {createRouter, createWebHistory, RouteRecordRaw} from "vue-router";
import Login from "../views/Login.vue";
import Main from "../views/layout/Main.vue";
import {user} from "../stores/user";
import {endLoad, endLoad as complete, initLoad, onLoaded, reset} from "../loader";
import Home from "../views/layout/Home.vue";

const routes: Array<RouteRecordRaw> = [
  {
    path: "/login",
    name: "Login",
    component: Login,
    meta: {
      redirectWhenAuthenticated: true,
      redirectTo: "Home",
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
          Home,

        children: [
          {
            path: "",
            name: "Products",
            component: () =>
              import("../views/Products.vue"),
            meta: {
              initLoad: false,
              endLoad: false,
            }
          },
          {
            path: "produkte/:name",
            name: "Product",
            component: () =>
              import("../components/ProductOverview.vue"),
            meta: {
              initLoad: false,
              endLoad: false,
            }
          }
        ]
      },
      {
        path: "/user/",
        name: "user",
        component: () =>
          import("../components/ProfilePage.vue"),
        children: [
          {
            path: "bestellverlauf",
            name: "Bestellverlauf",
            component: () =>
              import("../views/layout/OrderHistory.vue"),
          },
        ]
      },
      {
        path: "/admin/",
        name: "admin",
        component: () =>
          import("../views/layout/Admin.vue"),
        meta: {
          requiresAdmin: true,
        },

        children: [
          {
            path: "rechnungen",
            name: "Rechnungen",
            component: () =>
              import("../views/layout/Bills.vue"),
          },
          {
            path: "bestellungen",
            name: "Bestellungen",
            component: () =>
              import("../views/layout/Orders.vue"),
          },
          {
            path: "coupons",
            name: "Coupons",
            component: () =>
              import("../views/layout/Coupons.vue"),
          },
          {
            path: "kategorien",
            name: "Kategorien",
            component: () =>
              import("../components/EditCategories.vue"),
          },
          {
            path: "users/",
            name: "Userverwaltung",
            component: () =>
              import("../views/layout/UserManagement.vue"),
            children: [{
              path: "users/:id",
              name: "User detail",
              component: () => import("../views/layout/UserManagementDetail.vue"),
            }],
          },
          {
            path: "produkte/bearbeiten",
            name: "ProdukteBearbeiten",
            component: () =>
              import("../components/ProductListAdmin.vue"),
          },
          {
            path: "produkte/hinzufuegen/",
            name: "ProdukteHinzufuegen",
            component: () =>
              import("../components/UploadProductImages.vue"),
            children: [
              {
                path: "preisUndTitel",
                name: "PreisUndTitel",
                component: () =>
                  import("../components/UploadProductImages.vue"),
              }
            ]
          },
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
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!user.isLoggedIn) {
      next({
        name: "Login",
        params: {nextUrl: to.fullPath}
      });
      return;
    }

    if (to.matched.some(record => record.meta.requiresAdmin) && !user.isAdmin) {
      next(false);
      return;
    }
  }
  if (to.matched.some(record => record.meta.redirectWhenAuthenticated)
    && user.isLoggedIn) {
    next({
      name: to.meta.redirectTo as string,
    });
    return;
  }
  next();
});

router.beforeEach((to, from, next) => {
  reset();
  const showLoader = "initLoad" in to.meta ? to.meta.initLoad : true;
  if (showLoader) {
    initLoad();
  }

  next();
})

router.afterEach(route => {
  const showLoader = "initLoad" in route.meta ? route.meta.initLoad : true;
  const endLoad = showLoader && ("endLoad" in route.meta ? route.meta.endLoad : true);
  if (endLoad) {
    complete();
  }
});

export default router;
