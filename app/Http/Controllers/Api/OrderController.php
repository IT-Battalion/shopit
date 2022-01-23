<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function all()
    {
        $orders = Order::all();
        $orders->map(function (Order $order) {
            $products = OrderProduct::where('order_id', $order->id)->get();
            $prize = 0;
            foreach ($products as $op) {
                $prize += $op->price->getAmount();
            }
            $order->price = $prize . ' EUR';
            $order->status = "Warte auf Zahlung";
            if ($order->isPaid()) $order->status = 'Bezahlt';
            if ($order->isOrdered()) $order->status = 'Bestellt';
            if ($order->isReceived()) $order->status = 'Erhalten';
            if ($order->isHandedOver()) $order->status = 'Abgeholt';
        });
        return $orders;
    }

    //TODO damianik refactor
    public function userAll()
    {
        $orders = Order::where('customer_id', Auth::user()->id)->get();
        $orders->map(function (Order $order) {
            $products = OrderProduct::where('order_id', $order->id)->get();
            $prize = 0;
            foreach ($products as $op) {
                $prize += $op->price->getAmount();
            }
            $order->price = $prize . ' EUR';
            $order->status = "Warte auf Zahlung";
            if ($order->isPaid()) $order->status = 'Bezahlt';
            if ($order->isOrdered()) $order->status = 'Bestellt';
            if ($order->isReceived()) $order->status = 'Erhalten';
            if ($order->isHandedOver()) $order->status = 'Abgeholt';
        });
        return $orders;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
