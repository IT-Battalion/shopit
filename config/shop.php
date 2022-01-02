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

    'shopping_cart' => [
        'max_product_amount' => env('MAX_PRODUCT_AMOUNT', 100),
    ],

    'money' => [
        'decimal_points' => 8,
        'max_digits' => 8,
        'currency' => '€',
    ],
];
