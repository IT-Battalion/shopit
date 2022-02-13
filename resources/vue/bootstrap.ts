import {AxiosInstance, default as axios} from "axios";
import Echo from "laravel-echo";
import Pusher from "pusher-js";
import {GlobalConfig} from "./types/config";
import {createApp, reactive} from "vue";
// @ts-ignore
import App from "./App.vue";
import router from "./router";
import {redirectToLogin} from "./util";
import {MqResponsive, Vue3Mq} from "vue3-mq";
import {Skeletor} from "vue-skeletor";
import "vue-skeletor/dist/vue-skeletor.css";
import mitt, {Emitter} from "mitt";
import {UnwrapNestedRefs} from "@vue/reactivity";
import Toast, {useToast} from "vue-toastification";
import "vue-toastification/dist/index.css";
import {getCSRFCookie} from "./request";
import VueGoodTablePlugin from "vue-good-table-next";
import "vue-good-table-next/dist/vue-good-table-next.css"
import {key, store} from "./store";

declare global {
  interface Window {
    axios: AxiosInstance,
    pusher: Pusher,
    echo: Echo,
    initialConfig: GlobalConfig,
    // @ts-ignore
    config: UnwrapNestedRefs<GlobalConfig>,
    eventBus: Emitter<any>,
  }
}

window.config = reactive(window.initialConfig);

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = axios.create({
  headers: {
    "X-Requested-With": "XMLHttpRequest",
  },
  baseURL: "/api"
});

window.axios.interceptors.response.use(res => res, err => {
  if ("response" in err && err.response.status === 401) {
    const toast = useToast();

    store.commit("loggedIn", false);
    toast.info("Der Server hat gemeldet, dass Sie nicht mehr angemeldet sind.");
    return redirectToLogin().then(() => {
      return Promise.reject(err)
    }).then();
  }

  return Promise.reject(err);
});

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

window.pusher = require("pusher-js");

window.echo = new Echo({
  broadcaster: "pusher",
  key: process.env.MIX_PUSHER_APP_KEY,
  cluster: process.env.MIX_PUSHER_APP_CLUSTER,
  wsHost: window.location.hostname,
  wsPort: process.env.MIX_PUSHER_APP_PORT,
  useTLS: false,
  forceTLS: false,
  disableStats: true,
});

// Init csrf
getCSRFCookie();

/*export const SUPPORT_LOCALES = ['de', 'en'];

let userLocale = 'en';

for (let lang of window.navigator.languages) {
    if (lang in SUPPORT_LOCALES) {
        userLocale = lang;
        break;
    }
}

window.axios.defaults.headers.common['Accept-Language'] = userLocale;
// @ts-ignore
document.querySelector<HTMLHtmlElement>('html').setAttribute('lang', userLocale);

export function loadLocale(i18n: I18n, locale: string) {
    window.axios.get(
        `/locales/${userLocale}.json`
    ).then(messages => {
        i18n.global.setLocaleMessage(locale, messages.data);
    });
}
const i18n = createI18n({
    locale: userLocale,
});*/

const bus = mitt();
window.eventBus = bus;

let app = createApp(App);
app
  .use(store, key)
  .use(router)
  //    .use(i18n)
  .use(Vue3Mq, {preset: "tailwind"})
  .use(Toast)
  .use(VueGoodTablePlugin)
  .component("mq-responsive", MqResponsive)
  .component(Skeletor.name, Skeletor)
  .mount("#app");

app.config.globalProperties.$http = window.axios;
app.config.globalProperties.$globalBus = bus;
app.config.globalProperties.$echo = window.echo;

//loadLocale(i18n, userLocale);
