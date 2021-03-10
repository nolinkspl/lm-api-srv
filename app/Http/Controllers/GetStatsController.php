<?php

namespace App\Http\Controllers;

use App\Services\CodesKeeper;
use Illuminate\Http\JsonResponse;

class GetStatsController extends Controller
{
    private $codesKeeper;

    public function __construct(CodesKeeper $codesKeeper)
    {
        $this->codesKeeper = $codesKeeper;
    }

    /**
     * @return JsonResponse
     */
    public function __invoke()
    {
        try {
            $stats = $this->codesKeeper->getStats();
        } catch (\Throwable $e) {
            return $this->jsonSystemErrorResponse(
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ],
                $e->getCode()
            );
        }

        return response()->json($stats);
    }
}
