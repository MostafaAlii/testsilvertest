<?php

namespace App\Http\Resources\Orders;

use App\Http\Resources\CarTypeResources;
use App\Http\Resources\Drivers\CaptionResources;
use App\Http\Resources\HoursResources;
use App\Http\Resources\TripTypeResources;
use App\Http\Resources\Users\UsersResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrdersSaveHoursResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'user_id' => new UsersResources($this->user),
            'trip_type_id' => new TripTypeResources($this->trip_type),
            'hour_id' => new HoursResources($this->hour),
            'cart_type' => new CarTypeResources($this->car_type),
            'order_code' => $this->order_code,
            'total_price' => $this->total_price,
            'chat_id' => $this->chat_id,
            'status' => $this->status,
            'payments' => $this->payments,
            'lat_user' => $this->lat_user,
            'long_user' => $this->long_user,
            'address_now' => $this->address_now,
            'data' => $this->data,
            'hours_from' => $this->hours_from,
            'commit'=>$this->commit,
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
