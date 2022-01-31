<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentRequest;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class DocumentController extends Controller
{
    public function bill(DocumentRequest $request, Order $order) {
        $pdf = Pdf::loadView('bill', ['order' => $order]);

        if ($request->has('download'))
            return $pdf->download('bill.pdf');
        else
            return $pdf->stream('bill.pdf');
    }

    public function voucher(DocumentRequest $request, Order $order) {
        $pdf = Pdf::loadView('voucher', ['order' => $order]);

        if ($request->has('download'))
            return $pdf->download('voucher.pdf');
        else
            return $pdf->stream('voucher.pdf');
    }
}
