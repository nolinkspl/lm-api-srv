<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @param array $data
     * @param int $statusCode
     * @return JsonResponse
     */
    public function jsonSystemErrorResponse(array $data, int $statusCode = 500): JsonResponse
    {
        return response()->json(
            env('APP_DEBUG') ? $data : [
                'error' => 'System error',
            ],
            $statusCode
        );
    }
}
