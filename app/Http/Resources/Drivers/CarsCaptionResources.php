<?php

namespace App\Http\Resources\Drivers;

use App\Http\Resources\CarMakeResources;
use App\Http\Resources\CarModelResources;
use App\Http\Resources\CarTypeResources;
use App\Http\Resources\CategoryCarResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarsCaptionResources extends JsonResource
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
            'car_make_id' => new CarMakeResources($this->car_make),
            'car_model_id' => new CarModelResources($this->car_model),
            'car_type_id' => new CarTypeResources($this->car_type),
            'category_car_id' => new CategoryCarResources($this->category_car),
            'number_car' => $this->number_car,
            'color_car' => $this->color_car,
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
