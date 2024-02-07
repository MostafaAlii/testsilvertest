<?php
namespace App\Http\Resources\CMS;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
class OfferResources extends JsonResource {
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'title' => $this->translations->keyBy('locale')->map->only('title'),
            'note_1' => $this->translations->keyBy('locale')->map->only('note_1'),
            'note_2' => $this->translations->keyBy('locale')->map->only('note_2'),
            'note_3' => $this->translations->keyBy('locale')->map->only('note_3'),
            'note_4' => $this->translations->keyBy('locale')->map->only('note_4'),
            'note_5' => $this->translations->keyBy('locale')->map->only('note_5'),
            'note_6' => $this->translations->keyBy('locale')->map->only('note_6'),
            'note_7' => $this->translations->keyBy('locale')->map->only('note_7'),
            'note_8' => $this->translations->keyBy('locale')->map->only('note_8'),
            'note_9' => $this->translations->keyBy('locale')->map->only('note_9'),
            'note_10' => $this->translations->keyBy('locale')->map->only('note_10'),
            'price' => $this->price,
            'plan' => $this->plan_type
        ];
    }
}