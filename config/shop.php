<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Invoice Configuration
    |--------------------------------------------------------------------------
    | Config values for invoice
    */

    'invoice' => [

        /*
        |--------------------------------------------------------------------------
        | Invoice retention Period
        |--------------------------------------------------------------------------
        |
        | In years.
        |
        | This value is used to delete invoices that don't have to be retained
        | any more. In Austria this period starts with the end of the year in
        | which the payment was done and ends after 7 years e.g. an invoice
        | from January the 3rd 2013 has to be kept until December the 31st 2020.
        */

        'invoice.invoice_retention_period' => 7,

        /*
        | Delete invoices after the invoice retention period runs out?
        */

        'invoice.delete_after_invoice_retention_period' => false,

    ],

    /*
    |--------------------------------------------------------------------------
    | Icon APIs
    |--------------------------------------------------------------------------
    |
    | Configure the icon API Service.
    */

    'icon' => [

        /*
        | The noun Project API
        | This API uses Oauth 1a for Authentication.
        | Client available via https://packagist.org/packages/maglr/noun-project-php-client
        */


        /*
        |--------------------------------------------------------------------------
        | API key
        |--------------------------------------------------------------------------
        |
        | The API key for the noun project.
        | Get started at: https://thenounproject.com/developers/apps/
        */

        'api_key' => env('NOUN_PROJECT_API_KEY'),

        /*
        |--------------------------------------------------------------------------
        | API Secret
        |--------------------------------------------------------------------------
        |
        | The API key for the noun project.
        | Get started at: https://thenounproject.com/developers/apps/
        */

        'api_secret' => env('NOUN_PROJECT_API_SECRET'),
    ],

];
