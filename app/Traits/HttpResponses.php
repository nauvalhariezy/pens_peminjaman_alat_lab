<?php

namespace App\Traits;

trait HttpResponses {
    protected function success($data, $message = null, $code = 200)
    {
        return response()->json([
           'success' => "Request Success.",
           'data' => $data,
           'message' => $message,
           'code' => $code,
        ], $code);
    }

    protected function error($data, $message = null, $code)
    {
        return response()->json([
            'success' => "Error has occured...",
            'data' => $data,
            'message' => $message,
            'code' => $code,
        ], $code);
    }
}