<?php

namespace App\Http\Resources\Drivers;

use App\Http\Resources\Scooter\{ScooterMakeResource, ScooterModelResource};
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CaptainScooterResources extends JsonResource
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
            'scooter_make_id' => new ScooterMakeResource($this->scooter_make),
            'scooter_model_id' => new ScooterModelResource($this->scooter_model),
            'scooter_number' => $this->scooter_number,
            'scooter_color' => $this->scooter_color,
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
