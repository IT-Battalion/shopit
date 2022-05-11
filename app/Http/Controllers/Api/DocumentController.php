<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentRequest;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use WeasyPrint\Contracts\Factory;

class DocumentController extends Controller
{
    public function bill(DocumentRequest $request, Order $order, Factory $factory)
    {
        $pdf = $factory->prepareSource(view('documents.bill')); // TODO: bill blade file
        $output = $pdf->build();
        if (
            $request->has('download')
        ) {
            return $output->download('bill.pdf');
        } else {
            return $output->inline('bill.pdf');
        }
    }

    public function voucher(DocumentRequest $request, Order $order)
    {
        $pdf = Pdf::loadView('documents.voucher', ['order' => $order]);

        if ($request->has('download')) {
            return $pdf->download('voucher.pdf');
        } else {
            return $pdf->stream('voucher.pdf');
        }
    }
}
