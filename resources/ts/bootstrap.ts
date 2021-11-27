import { AxiosStatic } from "axios";

declare global {
    interface Window {
        axios: AxiosStatic,
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

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

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
