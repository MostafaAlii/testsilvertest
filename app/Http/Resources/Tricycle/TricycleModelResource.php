<?php

namespace App\Http\Resources\Tricycle;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TricycleModelResource extends JsonResource {
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status(),
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