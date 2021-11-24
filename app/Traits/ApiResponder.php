<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponder
{
    /**
     * Return a success JSON response.
     *
     * @param array|string $data
     * @param string|null $message
     * @param int $code
     * @return JsonResponse
     */
    protected function success($data, string $message = null, int $code = 200)
    {
        return response()->json([
            'status' => 'Success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Return an error JSON response.
     *
     * @param int $code
     * @param string|null $message
     * @param null $data
     * @return JsonResponse
     */
    protected function error(int $code, string $message = null, $data = null)
    {
        return response()->setStatusCode($code)->json([
            'status' => 'Error',
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
