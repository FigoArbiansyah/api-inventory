<?php

namespace App\Helpers;

class ResponseHelper
{
    /**
     * Generate a success response.
     *
     * @param array|object|string $data
     * @param string $message
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success($data = [], $message = 'Operation successful', $status = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $status);
    }

    /**
     * Generate an error response.
     *
     * @param string $message
     * @param int $status
     * @param array $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error($message = 'Operation failed', $status = 400, $errors = [])
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors
        ], $status);
    }

    /**
     * Generate a paginated response.
     *
     * @param \Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public static function paginated($paginator, $message = 'Operation successful')
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $paginator->items(),
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'total_pages' => $paginator->lastPage(),
                'total_items' => $paginator->total(),
                'items_per_page' => $paginator->perPage(),
                'next_page' => $paginator->nextPageUrl(),
                'previous_page' => $paginator->previousPageUrl()
            ]
        ]);
    }
}
