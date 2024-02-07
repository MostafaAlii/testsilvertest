<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarTypeResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status(),
            'price_normal' => $this->price_normal,
            'price_premium' => $this->price_premium,
            'before_price_normal' => $this->before_price_normal,
            'discount_price_normal' => $this->discount_price_normal,
            'discount_price_premium' => $this->discount_price_premium,
            'before_price_premium' => $this->before_price_premium,
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
