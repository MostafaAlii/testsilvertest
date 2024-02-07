<?php

namespace App\Http\Resources\Orders;

use App\Http\Resources\CarTypeDayResources;
use App\Http\Resources\Drivers\CaptionResources;
use App\Http\Resources\TripTypeResources;
use App\Http\Resources\Users\UsersResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrdersDayResources extends JsonResource
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
            'captain_id' => new CaptionResources($this->captain),
            'trip_type_id' => new TripTypeResources($this->trip_type),
            'order_code' => $this->order_code,
            'total_price' => $this->total_price,
            'chat_id' => $this->chat_id,
            'status' => $this->status,
            'payments' => $this->payments,
            'lat_user' => $this->lat_user,
            'long_user' => $this->long_user,
            'address_now' => $this->address_now,
            'start_day'=>$this->start_day,
            'end_day'=>$this->end_day,
            'number_day'=>$this->number_day,
            'start_time'=>$this->start_time,
            'commit'=>$this->commit,
            'type_duration'=>$this->type_duration,
            'status_price'=>$this->status_price,
            'type_duration'=>$this->type_duration,
            'car_type_day'=> new CarTypeDayResources($this->car_type_day),

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
