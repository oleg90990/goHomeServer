<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function errorResponse(string $message, $code = 403)
    {
        return response()->json([
            'errors' => [
                'message' => $message
            ]
        ], $code); 
    }

    public function successResponse(array $data, $code = 200)
    {
        return response()->json($data, $code); 
    }
}
