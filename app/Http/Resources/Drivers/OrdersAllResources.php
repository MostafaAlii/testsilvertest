<?php

namespace App\Http\Resources\Drivers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrdersAllResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'OrderCode' => $this->order_code,
            'status' => $this->status,
            'total_price' => getTotalPrice($this->total_price),
            'distance' => $this->distance ?? null,
            'address_now' => $this->address_now ?? null,
            'address_going' => $this->address_going ?? null,
            'trip_type_id' => $this->trip_type_id,
            'create_dates' => [
                'created_at_human' => $this->created_at->diffForHumans(),
               'created_at' => $this->created_at->format('y-m-d h:i:s')
            ],
            'update_dates' => [
                'updated_at_human' => $this->updated_at->diffForHumans(),
               'updated_at' => $this->updated_at->format('y-m-d h:i:s')
            ]
        ];
    }

}
