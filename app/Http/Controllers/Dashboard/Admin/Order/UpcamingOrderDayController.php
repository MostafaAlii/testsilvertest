<?php
namespace App\Http\Controllers\Dashboard\Admin\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\Orders\UpcamingOrderDayDataTable;
use App\Services\Dashboard\Admins\Order\UpcamingOrderDayService;
use App\Models\SaveRentDay;
class UpcamingOrderDayController extends Controller {
    public function __construct(protected UpcamingOrderDayDataTable $dataTable, protected UpcamingOrderDayService $upcamingOrderDayService,) {
        $this->dataTable = $dataTable;
        $this->upcamingOrderDayService = $upcamingOrderDayService;
    }
    public function index() {
        $title = 'Upcaming Order Days';
        return $this->dataTable->render('dashboard.admin.orders.orderDay.upcaming.index', ['title' => $title]);
    }

    public function show($orderCode) {
        $order = SaveRentDay::where('order_code', $orderCode)->first();
        $orderTracking = SaveRentDay::where('id', $order->id)->get(['user_id','trip_type_id','id', 'lat_user', 'long_user', 'status_price', 'car_type_day_id','start_day', 'end_day', 'number_day', 'start_time']);
        $locations = [];
        foreach ($orderTracking as $orderTrack) {
            $locations[] = [
                'id' => $orderTrack->id,
                'lat' => $orderTrack->lat_user,
                'lng' => $orderTrack->long_user,
                'user_id' => $orderTrack->user->name,
                'trip_type_id' => $orderTrack->trip_type->name,
            ];
        }
        return view('dashboard.admin.orders.orderDay.upcaming.show', ['order' => $order, 'data' => json_encode($locations)]);
    }

    public function updateDate(Request $request, $orderId) {
        try {
            $this->upcamingOrderDayService->updateDate($orderId, $request->start_day, $request->end_day);
            return redirect()->route('upcamingOrderDay.index')->with('success', 'Upcaming Order Day updated Date successfully');
        } catch (\Exception $e) {
            return redirect()->route('upcamingOrderDay.index')->with('error', 'An error occurred while updating the Upcaming Order Day Date');
        }
    }

    public function updateTime(Request $request, $orderId) {
        try {
            $this->upcamingOrderDayService->updateTime($orderId, $request->start_time);
            return redirect()->route('upcamingOrderDay.index')->with('success', 'Upcaming Order Day updated Start Time successfully');
        } catch (\Exception $e) {
            return redirect()->route('upcamingOrderDay.index')->with('error', 'An error occurred while updating the Upcaming Order Day Start Time');
        }
    }
}