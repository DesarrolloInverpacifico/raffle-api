<?php

namespace App\Traits;

trait ApiResponser
{
    protected function successResponse($data, $code = 200)
    {
        return response()->json([
            'status'    => $code,
            'data'      =>  $data
        ], $code);
    }

    protected function errorResponse($data = null, $message = null, $code = 422)
    {
        return response()->json([
            'status'        =>  $code,
            'message'       =>  $message,
            'errors'        =>  $data
        ], $code);
    }
}
