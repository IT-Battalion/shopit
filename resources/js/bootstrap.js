window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    window.dt = require( 'datatables.net' )( window, $ );

    require('bootstrap');
} catch (e) {}

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

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

require( 'jszip' );
require( 'pdfmake' );
require( 'datatables.net-dt' )();
require( 'datatables.net-autofill-dt' )();
require( 'datatables.net-buttons-dt' )();
require( 'datatables.net-buttons/js/buttons.colVis.js' )();
require( 'datatables.net-buttons/js/buttons.html5.js' )();
require( 'datatables.net-buttons/js/buttons.print.js' )();
require( 'datatables.net-colreorder-dt' )();
require( 'datatables.net-datetime' )();
require( 'datatables.net-fixedcolumns-dt' )();
require( 'datatables.net-fixedheader-dt' )();
require( 'datatables.net-keytable-dt' )();
require( 'datatables.net-responsive-dt' )();
require( 'datatables.net-rowgroup-dt' )();
require( 'datatables.net-rowreorder-dt' )();
require( 'datatables.net-scroller-dt' )();
require( 'datatables.net-searchbuilder-dt' )();
require( 'datatables.net-searchpanes-dt' )();
require( 'datatables.net-select-dt' )();
