import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router";
import Login from "../views/Login.vue";
import Main from "../views/layout/Main.vue";
import { user } from "../stores/user";
import { endLoad, endLoad as complete, initLoad, onLoaded, reset } from "../loader";
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
        component: Home,

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
            path: "products/:name",
            name: "Product",
            component: () =>
              import("../views/ProductOverview.vue"),
            meta: {
              initLoad: false,
              endLoad: false,
            }
          }
        ]
      },
      {
        path: "/profile/",
        name: "profile",
        component: () =>
          import("../views/layout/Profile.vue"),
        children: [
          {
            path: "",
            name: "Profile",
            component: () =>
              import("../views/ProfilePage.vue"),
          },
          {
            path: "order-history",
            name: "OrderHistory",
            component: () =>
              import("../views/OrderHistory.vue"),
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
            path: "",
            name: "Admin",
            component: () =>
              import("../views/ProfilePage.vue"),
          },
          {
            path: "invoices/",
            name: "Invoices",
            component: () =>
              import("../views/Bills.vue"),
            children: [
              {
                path: ":id",
                name: "Invoice detail",
                component: () => import("../views/Bills.vue")
              },
            ]
          },
          {
            path: "orders",
            name: "Orders",
            component: () =>
              import("../views/Orders.vue"),
          },
          {
            path: "orders/:id",
            name: "Order detail",
            component: () =>
              import("../views/layout/Order.vue")
          },
          {
            path: "coupons",
            name: "Coupons",
            component: () =>
              import("../views/Coupons.vue"),
          },
          {
            path: "categories",
            name: "CategoryManagement",
            component: () =>
              import("../views/EditCategories.vue"),
          },
          {
            path: "users/",
            name: "UserManagement",
            component: () =>
              import("../views/UserManagement.vue"),
            children: [{
              path: ":id",
              name: "User detail",
              component: () => import("../views/UserManagementDetail.vue"),
            }],
          },
          {
            path: "products/edit",
            name: "Edit Product",
            component: () =>
              import("../views/ProductListAdmin.vue"),
          },
          {
            path: "products/add/",
            name: "Add Product",
            component: () =>
              import("../views/UploadProductImages.vue"),
            children: [
              {
                path: "categoriesAttributes",
                name: "categoriesAttributes",
                component: () =>
                  import("../components/CategoriesAttributes.vue"),
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
      },
      {
        path: "/credits/",
        name: "credits",
        component: () =>
          import("../views/Credits.vue"),
      },
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
        params: { nextUrl: to.fullPath }
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
