<?php

namespace App\Http\Resources\Drivers;

use App\Http\Resources\Orders\CanselOrderResources;
use App\Http\Resources\Orders\ComplaintResponse;
use App\Http\Resources\Orders\TakingOrderResources;
use App\Http\Resources\TripTypeResources;
use App\Http\Resources\Users\RateCommentUserResources;
use App\Http\Resources\Users\UsersResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrdersResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' => new UsersResources($this->user) ?? null,
            'captain_id' => new CaptionResources($this->captain) ?? null,
            'trip_type_id' => new TripTypeResources($this->trip_type) ?? null,
            'complaints' => ComplaintResponse::collection($this->complaints) ?? null,
            'order_code' => $this->order_code ?? null,
            'total_price' => $this->total_price ?? null,
//            'total_profit' => getTotalAmount($this->id)??null,
            'chat_id' => $this->chat_id ?? null,
            'status' => $this->status ?? null,
            'payments' => $this->payments ?? null,
            'lat_user' => $this->lat_user ?? null,
            'long_user' => $this->long_user ?? null,
            'lat_going' => $this->lat_going ?? null,
            'long_going' => $this->long_going ?? null,
            'address_now' => $this->address_now ?? null,
            'address_going' => $this->address_going ?? null,
            'time_trips' => $this->time_trips ?? null,
            'distance' => $this->distance ?? null,
            'lat_caption' => $this->lat_caption ?? null,
            'long_caption' => $this->long_caption ?? null,
            'takingOrder' => new TakingOrderResources($this->takingOrder) ?? null,
            'Rate' => new RateCommentUserResources($this->rates) ?? null,
            'canselOrders' => new CanselOrderResources($this->canselOrder) ?? null,
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
