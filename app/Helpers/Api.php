<?php

namespace App\Helpers;

use Illuminate\Http\Response;

class Api
{
    public static function response(
        mixed $data,
        string $message,
        int $statusCode = Response::HTTP_OK,
        array $meta = [],
        ?string $status = null,
    ): \Illuminate\Http\JsonResponse {
        $status ??= $statusCode >= 400 ? 'error' : 'success';

        return response()->json([
            'meta' => array_merge([
                'code'    => $statusCode,
                'status'  => $status,
                'message' => $message,
            ], $meta),
            'data' => $data,
        ], $statusCode);
    }

    public static function success(
        mixed $data = null,
        string $message = 'Success'
    ): \Illuminate\Http\JsonResponse {
        return self::response($data, $message, Response::HTTP_OK);
    }

    public static function created(
        mixed $data = null,
        string $message = 'Data berhasil dibuat'
    ): \Illuminate\Http\JsonResponse {
        return self::response($data, $message, Response::HTTP_CREATED);
    }

    public static function error(
        string $message = 'Terjadi kesalahan',
        mixed $data = null,
        int $statusCode = Response::HTTP_BAD_REQUEST
    ): \Illuminate\Http\JsonResponse {
        return self::response($data, $message, $statusCode);
    }

    public static function notFound(
        string $message = 'Data tidak ditemukan'
    ): \Illuminate\Http\JsonResponse {
        return self::response(null, $message, Response::HTTP_NOT_FOUND);
    }

    public static function unauthorized(
        string $message = 'Unauthorized'
    ): \Illuminate\Http\JsonResponse {
        return self::response(null, $message, Response::HTTP_UNAUTHORIZED);
    }

    public static function forbidden(
        string $message = 'Akses ditolak'
    ): \Illuminate\Http\JsonResponse {
        return self::response(null, $message, Response::HTTP_FORBIDDEN);
    }

    public static function validationError(
        mixed $errors,
        string $message = 'Validasi gagal'
    ): \Illuminate\Http\JsonResponse {
        return self::response($errors, $message, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public static function withPagination(
        mixed $paginator,
        string $message = 'Success'
    ): \Illuminate\Http\JsonResponse {
        return self::response($paginator->items(), $message, Response::HTTP_OK, [
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
                'last_page'    => $paginator->lastPage(),
            ],
        ]);
    }
}
