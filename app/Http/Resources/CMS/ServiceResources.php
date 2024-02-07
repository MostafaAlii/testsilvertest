<?php
namespace App\Http\Resources\CMS;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
class ServiceResources extends JsonResource {
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'title' => $this->translations->keyBy('locale')->map->only('title'),
            'body' => $this->translations->keyBy('locale')->map->only('body'),
            'description' => $this->translations->keyBy('locale')->map->only('description')
        ];
    }
}