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
import VMdEditor from "@kangc/v-md-editor/lib/codemirror-editor";
import "@kangc/v-md-editor/lib/style/codemirror-editor.css";
import githubTheme from "@kangc/v-md-editor/lib/theme/github.js";
import "@kangc/v-md-editor/lib/theme/style/github.css";
import hljs from "highlight.js";
// import Highlight  from '@/types/highlight'
import Codemirror from "codemirror";
// mode
import "codemirror/mode/markdown/markdown";
import "codemirror/mode/javascript/javascript";
import "codemirror/mode/css/css";
import "codemirror/mode/htmlmixed/htmlmixed";
import "codemirror/mode/vue/vue";
// edit
import "codemirror/addon/edit/closebrackets";
import "codemirror/addon/edit/closetag";
import "codemirror/addon/edit/matchbrackets";
// placeholder
import "codemirror/addon/display/placeholder";
// active-line
import "codemirror/addon/selection/active-line";
// scrollbar
import "codemirror/addon/scroll/simplescrollbars";
import "codemirror/addon/scroll/simplescrollbars.css";
// style
import "codemirror/lib/codemirror.css";
import enUS from "@kangc/v-md-editor/lib/lang/en-US";
import VMdPreview from "@kangc/v-md-editor/lib/preview";
import "@kangc/v-md-editor/lib/style/preview.css";

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


VMdEditor.Codemirror = Codemirror;
VMdEditor.use(githubTheme, {
  Hljs: hljs,
});
VMdEditor.lang.use("en-US", enUS);

VMdPreview.use(githubTheme, {
  Hljs: hljs,
});

const bus = mitt();
window.eventBus = bus;

let app = createApp(App);
app
  .use(store, key)
  .use(router)
  .use(VMdEditor)
  .use(VMdPreview)
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
