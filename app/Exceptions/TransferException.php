<?php

namespace App\Exceptions;

use App\Http\Controllers\Api\HasApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;

class TransferException extends Exception
{
    use HasApiResponse;

    public function render($request)
    {
        return $this->setStatusCode(JsonResponse::HTTP_CONFLICT)
            ->respondError(['message' => $this->message]);
    }
}
