<?php
namespace App\Helpers\Traits;

trait RespondsWithHttpStatus
{
    protected function success($message, $status = 200)
    {
        return response([
            'success' => true,
            'message' => $message,
        ], $status);
    }

    protected function failure($message, $status = 422)
    {
        return response([
            'success' => false,
            'message' => $message,
        ], $status);
    }
}
