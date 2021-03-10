<?php

namespace App\Http\Controllers;

use App\Jobs\StatIncrementJob;
use App\Services\CodesKeeper;
use App\Services\CounterIncrementer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WriteStatController extends Controller
{
    private $codesKeeper;
    private $incrementer;

    public function __construct(
        CodesKeeper $codesKeeper,
        CounterIncrementer $incrementer
    ) {
        $this->codesKeeper = $codesKeeper;
        $this->incrementer = $incrementer;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        $code = $request->post('code');
        try {
            $this->codesKeeper->keep($code);
            $this->incrementer->incrementByCode($code);
        } catch (\Throwable $e) {
            /** @TODO нужно хранить джобы где-то в другом месте, иначе они не работают т.к. храним коды в редисе */
            dispatch(new StatIncrementJob($code));

            return $this->jsonSystemErrorResponse(
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ],
                $e->getCode()
            );
        }

        return response()->json();
    }
}
