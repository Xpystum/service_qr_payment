<?php

namespace App\Services\Auth\Traits;
use Illuminate\Http\Request;

trait RestExceptionHandlerTrait
{
     /**
     * Determines if request is an api call.
     *
     * If the request URI contains '/api/v'.
     *
     * @param Request $request
     * @return bool
     */
    protected function isApiCall(Request $request)
    {
        return strpos($request->getUri(), '/api/v') !== false;
    }
}
