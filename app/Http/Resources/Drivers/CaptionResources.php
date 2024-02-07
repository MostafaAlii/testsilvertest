<?php

namespace App\Http\Resources\Drivers;

use App\Http\Resources\CountryResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class CaptionResources extends JsonResource {
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'gender' => $this->gender,
            'status_caption_type' => $this->status_caption_type,
            'inviteFriend' =>  $this->invite->code_invite ?? null,
            'captaincar' => new CarsCaptionResources($this->captaincar) ?? null,
            'scooters' => CaptainScooterResources::collection($this->scooters) ?? null,
            'profile' => new CaptainProfileResources($this->profile) ?? null,
            'country' => new CountryResources($this->country) ?? null,
            'fcm_token' => $this->fcm_token,
            'status' => $this->status,
            'avatar' => getImageCaption($this->id),
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
