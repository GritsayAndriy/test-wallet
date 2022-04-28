<?php

namespace App\Exceptions;

use App\Http\Controllers\Api\HasApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;

class UnexpectedException extends Exception
{
    use HasApiResponse;

    public function render($request)
    {
        return $this->setStatusCode(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->respond(['message' => $this->message], 'error');
    }
}
