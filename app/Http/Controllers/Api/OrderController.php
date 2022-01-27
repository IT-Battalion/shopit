<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Services\Orders\OrderServiceInterface;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{

    public function all()
    {
        return Order::all();
    }

    public function userAll(): JsonResponse
    {
        $user = Auth::user();
        $orders = Order::whereCustomerId($user->id)->get();
        return response()->json($orders);
    }

    public function userAdminAll(User $user): JsonResponse
    {
        $orders = Order::whereCustomerId($user->id)->get();
        $jsonOrders = [];
        foreach ($orders as $order) {
            $jsonOrders[] = [
                'id' => $order->id,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
                'status' => $order->status,
                'total' => $order->total,
                'totalDiscount' => $order->totalDiscount,
                'totalGross' => $order->totalGross,
                'totalTax' => $order->totalTax,
                'coupon_code_id' => $order->coupon_code_id,
                'customer_id' => $order->customer_id,
                'paid_at' => $order->paid_at,
                'transaction_confirmed_by_id' => $order->transaction_confirmed_by_id,
                'handed_over_at' => $order->handed_over_at,
                'handed_over_by_id' => $order->handed_over_by_id,
                'products_ordered_at' => $order->products_ordered_at,
                'products_ordered_by_id' => $order->products_ordered_by_id,
                'products_received_at' => $order->products_received_at,
                'products_received_by_id' => $order->products_received_by_id,
                'products_received_by' => $order->products_received_by,
                'products_ordered_by' => $order->products_ordered_by,
                'handed_over_by' => $order->handed_over_by,
                'transaction_confirmed_by' => $order->transaction_confirmed_by,
                'coupon' => $order->coupon_code,
                'customer' => $order->customer,
            ];
        }
        return response()->json($jsonOrders);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OrderServiceInterface $orderService
     * @return JsonResponse
     */
    public function store(OrderServiceInterface $orderService): JsonResponse
    {
        $order = $orderService->createOrder();
        $order = $order->refresh();
        return response()->json($order);
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return JsonResponse
     */
    public function userShow(Order $order): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user->is_admin && $user->id !== $order->customer_id) {
            abort(404);
        }
        return response()->json($order);
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return JsonResponse
     */
    public function show(Order $order): JsonResponse
    {
        return response()->json($order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
