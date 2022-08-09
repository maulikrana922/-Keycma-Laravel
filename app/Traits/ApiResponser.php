<?php

namespace App\Traits;

trait ApiResponser {

	/**
	 * Return success response.
	 *
	 * @return \Illuminate\Http\Response
	 */
	protected function sendSuccessResponse($data = [], $message = null, $code = 200)
	{
		$response = [
            'success' => true,
            'data'    => $data,
            'message' => $message,
        ];

        return response()->json($response, $code);
	}

	/**
	 * Return error response.
	 *
	 * @return \Illuminate\Http\Response
	 */
	protected function sendErrorResponse($message = null, $errorMessages = [], $code)
	{
		$response = [
            'success' => false,
            'message' => $message,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
	}
}