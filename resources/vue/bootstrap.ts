import { AxiosInstance, default as axios } from "axios";

declare global {
    interface Window {
        axios: AxiosInstance,
        _: LoDashStatic,
        pusher: Pusher,
        echo: Echo,
        config: GlobalConfig,
    }
}

window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = axios.create({
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
    },
    baseURL: '/api'
});

window.axios.interceptors.response.use(res => res, err => {
    if (err.response.status === 401) {
        redirectToLogin().then(r => console.log(r));
        return Promise.reject(err);
    }

    return err;
});

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';
import { LoDashStatic } from "lodash";
import Pusher from "pusher-js";
import { GlobalConfig } from "./types/config";

window.pusher = require('pusher-js');

window.echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    wsHost: window.location.hostname,
    wsPort: process.env.MIX_PUSHER_APP_PORT,
    useTLS: false,
    forceTLS: false,
    disableStats: true,
});

require('jszip');
require('pdfmake');

// Init csrf
window.axios.get('/sanctum/csrf-cookie').catch(_ => {
    console.error("CSRF couldn't be fetched");
});

import {
    createApp
} from "vue";
import App from "./App.vue";
import router from "./router";
import { createI18n, I18n } from "vue-i18n";
import { redirectToLogin } from "./util";
import { Vue3Mq, MqResponsive } from "vue3-mq";
import { Skeletor } from "vue-skeletor";
import 'vue-skeletor/dist/vue-skeletor.css';

export const SUPPORT_LOCALES = ['de', 'en'];

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
});

let createdApp = createApp(App);
createdApp
    .use(router)
    .use(i18n)
    .use(Vue3Mq, { preset: "tailwind" })
    .component('mq-responsive', MqResponsive)
    .component(Skeletor.name, Skeletor)
    .mount("#app");

createdApp.config.globalProperties.$http = window.axios;

loadLocale(i18n, userLocale);
