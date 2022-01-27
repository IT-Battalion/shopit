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

    public function userAll(User $user): JsonResponse
    {
        if (!isset($user)) {
            $user = Auth::user();
        }
        $orders = Order::whereCustomerId($user->id)->get();
        return response()->json($orders);
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
