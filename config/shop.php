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

    'money' => [
        'decimal_points' => 8,
        'max_digits' => 8,
        'currency' => '€',
    ],

    'category' => [
        'colors' => ['ff7651', '31a8e2', '6c5fcf'],
    ],

    'image' => [
        'allowedMimeTypes' => ['image/jpeg', 'image/png'],
        'temporaryPath' => 'tmp' . DIRECTORY_SEPARATOR . 'images',
        'permanentPath' => 'product' . DIRECTORY_SEPARATOR . 'images',
        'disk' => 'local',
    ]
];
