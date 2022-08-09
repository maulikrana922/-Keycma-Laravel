<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{
    /**
     * Success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
            'status_code' => 200
        ];

        return response()->json($response, 200);
    }

    /**
     * Return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 422)
    {
    	$response = [
            'success' => false,
            'message' => $error,
            'status_code' => 422
        ];

        if(!empty($errorMessages))  {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}