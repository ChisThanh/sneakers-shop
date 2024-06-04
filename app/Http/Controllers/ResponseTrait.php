<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

trait ResponseTrait
{
    public function successResponse($data = [], $message = '')
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], 200);
    }

    public function errorResponse($message = '', $status = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $status);
    }
}
