<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HoursResources extends JsonResource
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
            'number_hours' => $this->number_hours,
            'discount_hours' => $this->discount_hours,
            'offer_price' => $this->offer_price,
            'price_hours' => $this->price_hours,
            'price_premium' => $this->price_premium,
            'offer_price_premium' => $this->offer_price_premium,
            'car_type' => CarTypeResources::collection($this->hour_car_type) ,
            'category_car' => new CategoryCarResources($this->category_car),
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
