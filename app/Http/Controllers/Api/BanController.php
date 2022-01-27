<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Users\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Request;

class BanController extends Controller
{
    public function info(User $user): JsonResponse
    {
        $ban = [
            'disabled_at' => $user->disabled_at,
            'disabled_by' => $user->disabled_by,
            'disabled_for' => $user->reason_for_disabling,
        ];

        return response()->json($ban);
    }

    public function ban(User $user, UserServiceInterface $userService, Request $request): JsonResponse
    {
        $userService->ban($user, $request->get('reason'));
        $ban = [
            'disabled_at' => $user->disabled_at,
            'disabled_by' => $user->disabled_by,
            'disabled_for' => $user->reason_for_disabling,
        ];
        return response()->json($ban);
    }

    public function unban(User $user, UserServiceInterface $userService): JsonResponse
    {
        $userService->unban($user);
        $ban = [
            'disabled_at' => $user->disabled_at,
            'disabled_by' => $user->disabled_by,
            'disabled_for' => $user->reason_for_disabling,
        ];
        return response()->json($ban);
    }
}
