<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 4/3/2024
 * Time: 17:40
 */

namespace App\Helpers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiResponse
{
    public static function success($data = null, $message = null, $statusCode = 200)
    {
        return response()->json([
            'finalizado' => true,
            'datos' => $data,
            'mensaje' => $message,
        ], $statusCode);
    }

    public static function error($message = null, $statusCode = 400)
    {
        return response()->json([
            'finalizado' => false,
            'mensaje' => $message,
        ], $statusCode);
    }

    public static function exception(\Exception $exception)
    {
        $statusCode = 400;

        if ($exception instanceof ModelNotFoundException) {
            $message = 'Recurso no encontrado';
            $statusCode = 404;
        } elseif ($exception instanceof ValidationException) {
            $message = $exception->validator->errors()->first();
        } elseif ($exception instanceof HttpException) {
            $statusCode = $exception->getStatusCode();
            $message = $exception->getMessage();
        } else {
            $message = $exception->getMessage();
        }

        return response()->json([
            'finalizado' => false,
            'mensaje' => $message,
        ], $statusCode);
    }
}