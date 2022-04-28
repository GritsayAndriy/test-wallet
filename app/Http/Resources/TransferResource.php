<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransferResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'from' => $this->whenLoaded('from')->user->name ?? null,
            'to' => $this->whenLoaded('to')->user->name ?? null,
            'amount' => $this->amount,
            'created_at' => $this->created_at->format('d-m-Y H:m')
        ];
    }
}
