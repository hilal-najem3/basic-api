<?php

namespace App\Traits;

trait JsonErrorReturnTrait
{
    /**
     * This function refines a return of a special case error with
     * the laravel application
     * 
     * @param  int    $code  status of the error
     * @param  string $message response error message
     * 
     * @return array
     */
    public function returnCaseError(int $code, string $message = '')
    {
        if($code == 200) {
            return [
                'status' => 'success',
                'code' => 200,
                'message' => $message
            ];
        }

        return [
            'status' => 'error',
            'code' => $code,
            'message' => $message
        ];
    }

    /**
     * This function fills the response that should be sent to the user
     * then returns a response for it.
     * 
     * @param  int         $status  status of the error
     * @param  string|null $message response error message
     * @param  string $error   Exception message
     * 
     * @return \Illuminate\Http\Response
     */
    public function returnErrorResponse(int $status, string $message = null, string $error = null)
    {
        $result = $this->fillResult($status, $message, $error);

        return response()->json($result, $status);
    }

    /**
     * This function fills the response that should be sent to the user
     * then returns an array of it.
     * 
     * @param  int         $status  status of the error
     * @param  string|null $message response error message
     * @param  string $error   Exception message
     * 
     * @return array
     */
    public function fillResult(int $status, string $message = null, string $error = null)
    {
        $result = [
            'status' => 'error',
        ];

        if($message != null) {
            $result['message'] = $message;
        } else {
            switch ($status) {
                case 404:
                    $result['message'] = 'Not found!';
                    break;

                case 405:
                    $result['message'] = 'Task failed!';
                    break;

                case 422:
                    $result['message'] = 'Unprocessable entity!';
                    break;
                
                default:
                    $result['message'] = 'Bad request!';
                    break;
            }
        }

        if($error != null) {
            $result['error'] = $error;
        } else {
            switch ($status) {
                case 404:
                    $result['error'] = 'Not Found!';
                    break;

                case 405:
                    $result['error'] = 'Method Not Allowed!';
                    break;

                case 422:
                    $result['error'] = 'Unprocessable Entity!';
                    break;
                
                default:
                    $result['error'] = 'Bad Request!';
                    break;
            }
        }

        return $result;
    }
}