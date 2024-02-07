<?php
namespace App\Http\Controllers\Dashboard\Admin\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\Orders\OrderDayDataTable;
use App\Http\Requests\Dashboard\Admin\AdminRequestValidation;
use App\Models\OrderDay;
class OrderDayController extends Controller {
    public function __construct(protected OrderDayDataTable $dataTable) {
        $this->dataTable = $dataTable;
    }
    public function index() {
        $title = 'Order Days';
        return $this->dataTable->render('dashboard.admin.orders.orderDay.index', ['title' => $title]);
    }

    public function show($orderCode) {
        $order = OrderDay::where('order_code', $orderCode)->first();
        $orderTracking = OrderDay::where('id', $order->id)->get(['user_id', 'captain_id', 'trip_type_id','id', 'lat_user', 'long_user', 'status_price', 'car_type_day_id', 'type_duration', 'start_day', 'end_day', 'number_day', 'start_time']);
        $locations = [];
        foreach ($orderTracking as $orderTrack) {
            $locations[] = [
                'id' => $orderTrack->id,
                'lat' => $orderTrack->lat_user,
                'lng' => $orderTrack->long_user,
                'user_id' => $orderTrack->user->name,
                'captain_id' => $orderTrack->captain->name,
                'trip_type_id' => $orderTrack->trip_type->name,
            ];
        }
        return view('dashboard.admin.orders.orderDay.show', ['order' => $order, 'data' => json_encode($locations)]);
    }
}