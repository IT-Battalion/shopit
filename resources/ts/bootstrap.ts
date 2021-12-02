import {AxiosStatic} from "axios";

declare global {
    interface Window {
        axios: AxiosStatic,
        _: LoDashStatic,
        pusher: Pusher,
        echo: Echo,
        config: {
            categories: {
                id: string,
                name: string,
                icon_name: string,
                icon_url: string,
            }[]
        }
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
import {LoDashStatic} from "lodash";
import Pusher from "pusher-js";

window.pusher = require('pusher-js');

window.echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: true,
    disableStats: true,
});

require( 'jszip' );
require( 'pdfmake' );
