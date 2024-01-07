<?php

namespace App\Services;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseService
{
    public static function success($data = null, $message = null, $statusCode = Response::HTTP_OK): JsonResponse
    {
        return response()->json(['success' => true, 'data'=> $data, 'message' => $message], $statusCode);
    }

    public static function fail($message = null, $statusCode = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return response()->json(['success' => false, 'message' => $message], $statusCode);
    }
}
