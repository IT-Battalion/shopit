import router from "./router";

export function redirectToLogin() {
  return router.push({
    name: 'Login',
    params: { nextUrl: router.currentRoute.value.fullPath },
  });
}
