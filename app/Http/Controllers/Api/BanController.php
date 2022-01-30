<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ActionNotAllowedForAdministratorException;
use App\Exceptions\UserBannedException;
use App\Exceptions\UserNotBannedException;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Users\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BanController extends Controller
{
    public function info(User $user): JsonResponse
    {
        $ban = [
            'disabled_at' => $user->disabled_at,
            'disabled_by' => $user->disabled_by,
            'reason' => $user->reason_for_disabling,
        ];

        return response()->json($ban);
    }

    public function ban(Request $request, User $user, UserServiceInterface $userService): JsonResponse
    {
        $data = $request->validate([
            'reason' => ['required'],
        ]);

        try {
            $userService->ban($user, $data['reason']);
            $ban = [
                'disabled_at' => $user->disabled_at,
                'disabled_by' => $user->disabled_by,
                'reason' => $user->reason_for_disabling,
            ];
            return response()->json($ban);
        } catch (ActionNotAllowedForAdministratorException) {
            return response()->json(['errors' => ['user' => ['Dieser User ist ein Administrator und kann daher nicht verändert werden.']]], 400);
        } catch (UserBannedException) {
            return response()->json(['errors' => ['user' => ['Dieser User ist bereits gebannt.']]], 400);
        }
    }

    public function unban(User $user, UserServiceInterface $userService): JsonResponse
    {
        try {
            $userService->unban($user);
            $ban = [
                'disabled_at' => $user->disabled_at,
                'disabled_by' => $user->disabled_by,
                'reason' => $user->reason_for_disabling,
            ];
            return response()->json($ban);
        } catch (ActionNotAllowedForAdministratorException) {
            return response()->json(['errors' => ['user' => ['Dieser User ist ein Administrator und kann daher nicht verändert werden.']]], 400);
        } catch (UserNotBannedException) {
            return response()->json(['errors' => ['user' => ['Dieser User ist nicht gebannt.']]], 400);
        }
    }
}
