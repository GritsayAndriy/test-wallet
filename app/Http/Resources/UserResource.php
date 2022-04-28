<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'email' => $this->maskEmail($this->email),
            'balance' => $this->whenLoaded('wallet')->balance ?? '0',
        ];
    }

    private function maskEmail($email)
    {
        $positionLast = strpos($this->email,'@');
        return Str::mask($this->email, '*', 1, $positionLast-2);
    }
}
