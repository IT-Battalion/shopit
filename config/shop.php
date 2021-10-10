<?php

return [

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
    | from January the 3rd 2013 has to be kept until Dezember the 31st 2020.
    */

    'invoice_retention_period' => 7,
    'delete_after_invoice_retention_period' => false,
];
