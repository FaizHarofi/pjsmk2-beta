<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

trait AjaxResponse
{
    public function wantsJson(Request $request): bool
    {
        return $request->wantsJson() || $request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest';
    }

    protected function jsonSuccess(string $message = 'OK', array $data = [], int $code = 200): JsonResponse
    {
        return response()->json([
            'status'  => 'success',
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    protected function jsonError(string $message = 'Error', array $errors = [], int $code = 400): JsonResponse
    {
        return response()->json([
            'status'  => 'error',
            'message' => $message,
            'errors'  => $errors,
        ], $code);
    }
}
