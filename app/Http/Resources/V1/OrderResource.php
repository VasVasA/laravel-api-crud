<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'number' => $this->number,
            'client_name' => $this->client_name,
            'address' => $this->address,
            'created_at' => $this->created_at,
            'price' => $this->price()
        ];
    }
}
