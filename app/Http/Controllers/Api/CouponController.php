<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCouponRequest;
use App\Models\CouponCode;
use Illuminate\Http\JsonResponse;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $coupons = CouponCode::all();
        return response()->json($coupons);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCouponRequest $request
     * @return JsonResponse
     */
    public function store(StoreCouponRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['discount'] /= 100;

        $coupon = CouponCode::create($data);
        $coupon = CouponCode::find($coupon->id);
        return response()->json($coupon);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CouponCode $couponCode
     * @return JsonResponse
     */
    public function destroy(CouponCode $couponCode): JsonResponse
    {
        $couponCode->delete();
    }
}
