<?php
namespace App\Services\Dashboard\Admins\Order;
use App\Models\SaveRentDay;

class UpcamingOrderDayService {

    public function updateDate($orderId, $start_day, $end_day) {
        $order = SaveRentDay::findOrFail($orderId);
        $order->start_day = $start_day;
        $order->end_day = $end_day;
        $order->save();
        return $order;
    }

    public function updateTime($orderId, $start_time) {
        $order = SaveRentDay::findOrFail($orderId);
        $order->start_time = $start_time;
        $order->save();
        return $order;
    }
}