<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\User;
use App\Services\Orders\OrderServiceInterface;
use App\Types\OrderStatus;
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class OrderController extends Controller
{

    public function index(): JsonResponse
    {
        return response()->json(Order::all());
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
                'discount' => $order->discount,
                'subtotal' => $order->subtotal,
                'tax' => $order->tax,
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
     * @param int $order
     * @return JsonResponse
     */
    public function show(int $order): JsonResponse
    {
        $order = Order::withCount('products')->find($order);
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
        $data = collect($request->validated());
        $status = OrderStatus::from($data['status']);
        debug($status);
        debug($order->status);

        if ($order->status === $status) {
            return response()->json($order);
        }

        try {
            if ($status->value > $order->status->value) { // increment status
                debug('increment');
                $columns = $this->getStatusColums($status, now(), Auth::id());
            } else {
                debug('decrement');
                $columns = $this->getStatusColums($order->status); // empty current status columns
            }
        } catch (Exception $e) {
            return response()->json(['errors' => ['status' => [$e->getMessage()]]], 400);
        }

        $order->update($data->merge($columns)->all());
        $order->refresh();
        return response()->json($order);
    }

    /**
     * @throws Exception
     */
    private function getStatusColums(OrderStatus $status, Carbon $time = null, int $admin_id = null): Collection {
        return match ($status) {
            OrderStatus::CREATED => throw new Exception('Unexpected order status for columns: ' . $status->name),
            OrderStatus::PAID => collect(['paid_at' => $time, 'transaction_confirmed_by_id' => $admin_id]),
            OrderStatus::ORDERED => collect(['products_ordered_at' => $time, 'products_ordered_by_id' => $admin_id]),
            OrderStatus::RECEIVED => collect(['products_received_at' => $time, 'products_received_by_id' => $admin_id]),
            OrderStatus::HANDED_OVER => collect(['handed_over_at' => $time, 'handed_over_by_id' => $admin_id]),
        };
    }
}
