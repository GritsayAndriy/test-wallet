<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ValidationException;
use Illuminate\Http\JsonResponse;

trait HasApiResponse
{
    private $statusCode;

    protected function setStatusCode($code)
    {
        $this->statusCode = $code;
        return $this;
    }

    protected function respondSuccess($data = [])
    {
        return $this->setStatusCode(JsonResponse::HTTP_OK)
            ->respond($data, 'success');
    }

    protected function respondError($data = [])
    {
        return $this->setStatusCode(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->respond($data, 'error');
    }

    protected function respondFailValidated($errors)
    {
        throw (new ValidationException())->setErrors($errors);
    }

    protected function respond($data, $status)
    {
        $responseData = ['data' => $data, 'status' => $status];
        return response()->json($responseData, $this->statusCode);
    }
}
