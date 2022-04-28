<?php

namespace App\Exceptions;

use App\Http\Controllers\Api\HasApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;

class ValidationException extends Exception
{
    use HasApiResponse;

    protected $errors;

    public function setErrors($errors)
    {
        $this->errors = $errors;
        return $this;
    }

    public function render($request)
    {
        foreach ($this->errors as $field => $error){
            $data[$field] = [__($error, ['attribute' => $field])];
        }

        return $this->setStatusCode(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->respond(['errors' => $data], 'error');
    }
}
