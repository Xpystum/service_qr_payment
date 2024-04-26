<?php

namespace App\Services\Auth\App\Exceptions\Error\Trait;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

trait ExceptionResponseTrait{

    public function __construct($message = "Custom exception message", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'message_error' => $this->message,
            'code' => $this->code,
        ], 404);
    }

}
