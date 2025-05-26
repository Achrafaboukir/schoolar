<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * Success response method.
     *
     * @param  mixed  $result
     * @param  string  $message
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message = '')
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    /**
     * Error response method.
     *
     * @param  string  $error
     * @param  array  $errorMessages
     * @param  int  $code
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['errors'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    /**
     * Response with pagination method.
     *
     * @param  mixed  $items
     * @return \Illuminate\Http\Response
     */
    protected function paginatedResponse($items)
    {
        return response()->json([
            'data' => $items->items(),
            'total_pages' => $items->lastPage(),
            'current_page' => $items->currentPage(),
            'total_items' => $items->total(),
            'per_page' => $items->perPage(),
        ]);
    }
} 