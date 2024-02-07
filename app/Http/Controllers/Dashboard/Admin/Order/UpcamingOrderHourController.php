<?php
namespace App\Http\Controllers\Dashboard\Admin\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\Orders\UpcamingOrderHourDataTable;
use App\Services\Dashboard\Admins\Order\UpcamingOrderHourService;
use App\Models\{SaveRentHour, Hour};
class UpcamingOrderHourController extends Controller {
    public function __construct(protected UpcamingOrderHourDataTable $dataTable, protected UpcamingOrderHourService $upcamingOrderHourService,) {
        $this->dataTable = $dataTable;
        $this->upcamingOrderHourService = $upcamingOrderHourService;
    }
    public function index() {
        $title = 'Upcaming Order Hours';
        return $this->dataTable->render('dashboard.admin.orders.orderHour.upcaming.index', ['title' => $title]);
    }

    public function show($orderCode) {
        $order = SaveRentHour::where('order_code', $orderCode)->first();
        $orderTracking = SaveRentHour::where('id', $order->id)->get();
        //dd($orderTracking);
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
        return view('dashboard.admin.orders.orderHour.upcaming.show', ['order' => $order, 'data' => json_encode($locations)]);
    }

    public function updateHour(Request $request, $orderId) {
        try {
            $this->upcamingOrderHourService->updateHour($orderId, $request->hour_id);
            return redirect()->route('upcamingOrderHour.index')->with('success', 'Upcaming Order Hour updated Date successfully');
        } catch (\Exception $e) {
            return redirect()->route('upcamingOrderHour.index')->with('error', 'An error occurred while updating the Upcaming Order Hour Date');
        }
    }
}