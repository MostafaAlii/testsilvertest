<?php
namespace App\Services\Dashboard\Admins\Order;
use App\Models\SaveRentHour;

class UpcamingOrderHourService {

    public function updateHour($orderId, $hour_id) {
        $order = SaveRentHour::findOrFail($orderId);
        $order->hour_id = $hour_id;
        $order->save();
        return $order;
    }
}