<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\User;
use App\Services\Orders\OrderServiceInterface;
use Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{

    public function all(): Collection|array
    {
        return Order::all();
    }

    public function userAll(): JsonResponse
    {
        $orders = Order::whereCustomerId(Auth::user()->id)->get();
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
     * Update the specified resource in storage.
     *
     * @param UpdateOrderRequest $request
     * @param Order $order
     * @return JsonResponse
     */
    public function update(UpdateOrderRequest $request, Order $order): JsonResponse
    {
        $data = $request->validated();
        $order->update($data);
        $order->refresh();
        return response()->json($order);
    }
}
