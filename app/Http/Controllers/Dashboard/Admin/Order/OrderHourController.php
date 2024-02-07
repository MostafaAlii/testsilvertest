<?php
namespace App\Http\Controllers\Dashboard\Admin\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\Orders\OrderHourDataTable;
use App\Http\Requests\Dashboard\Admin\AdminRequestValidation;
use App\Models\OrderHour;
class OrderHourController extends Controller {
    public function __construct(protected OrderHourDataTable $dataTable) {
        $this->dataTable = $dataTable;
    }
    public function index() {
        $title = 'Order Hours';
        return $this->dataTable->render('dashboard.admin.orders.orderHour.index', ['title' => $title]);
    }

    public function show($orderCode) {
        $order = OrderHour::where('order_code', $orderCode)->first();
        $orderTracking = OrderHour::where('id', $order->id)->get(['user_id', 'captain_id', 'trip_type_id','id', 'lat_user', 'long_user', 'status_price', 'car_type_id', 'type_duration', 'time_duration']);
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
        return view('dashboard.admin.orders.orderHour.show', ['order' => $order, 'data' => json_encode($locations)]);
    }
}