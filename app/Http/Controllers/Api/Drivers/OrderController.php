<?php

namespace App\Http\Controllers\Api\Drivers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Drivers\OrdersAllResources;
use App\Http\Resources\Drivers\OrdersResources;
use App\Http\Resources\Orders\AllOrdersResources;
use App\Models\Order;
use App\Models\OrderDay;
use App\Models\OrderHour;
use App\Models\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    use ApiResponseTrait;

//    public function index()
//    {
//        $captainId = auth('captain-api')->id();
//
//        $orders = Order::byCaptain($captainId)
//            ->whereIn('status', ['done', 'cancel'])
//            ->orderBy('id', 'DESC')
//            ->paginate(5);
//
//        $ordersHours = OrderHour::byCaptain($captainId)
//            ->whereIn('status', ['done', 'cancel'])
//            ->orderBy('id', 'DESC')
//            ->paginate(5);
//
//        $orderDay = OrderDay::byCaptain($captainId)
//            ->whereIn('status', ['done', 'cancel'])
//            ->orderBy('id', 'DESC')
//            ->paginate(5);
//        $allData = $orders->concat($ordersHours)->concat($orderDay);
//
//        $data = OrdersResources::collection($allData);
//        $pagination = $allData->toArray();
//        unset($pagination['data']); // Remove the 'data' key from pagination
//
//        $response = [
//            'data' => $data,
//            'pagination' => $pagination,
//        ];
//
//        return $this->successResponse($response, 'Data returned successfully');
//    }

    public function index()
    {
        $captainId = auth('captain-api')->id();

        $orders = Order::byCaptain($captainId)
            ->whereIn('status', ['done', 'cancel'])
            ->orderByDesc('id')
            ->paginate(3);

        $ordersHours = OrderHour::byCaptain($captainId)
            ->whereIn('status', ['done', 'cancel'])
            ->orderByDesc('id')
            ->paginate(3);

        $orderDay = OrderDay::byCaptain($captainId)
            ->whereIn('status', ['done', 'cancel'])
            ->orderByDesc('id')
            ->paginate(3);

        $allData = $orders->concat($ordersHours)->concat($orderDay);

        $data = AllOrdersResources::collection($allData);
        $pagination = [
            'total' => $orders->total() + $ordersHours->total() + $orderDay->total(),
            'per_page' => ($orders->perPage() ?? 0) + ($ordersHours->perPage() ?? 0) + ($orderDay->perPage() ?? 0),
            'current_page' => ($orders->currentPage() ?? 0) + ($ordersHours->currentPage() ?? 0) + ($orderDay->currentPage() ?? 0),
            'last_page' => ($orders->lastPage() ?? 0) + ($ordersHours->lastPage() ?? 0) + ($orderDay->lastPage() ?? 0),
            'from' => ($orders->firstItem() ?? 0) + ($ordersHours->firstItem() ?? 0) + ($orderDay->firstItem() ?? 0),
            'to' => ($orders->lastItem() ?? 0) + ($ordersHours->lastItem() ?? 0) + ($orderDay->lastItem() ?? 0),
            'next_page_url' => ($orders->nextPageUrl() ?? '')  . ($ordersHours->nextPageUrl() ?? '') .  ($orderDay->nextPageUrl() ?? ''),
        ];

        $response = [
            'data' => $data,
            'pagination' => $pagination,
        ];

        return $this->successResponse($response, 'Data returned successfully');
    }


    public function report(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'start_data' => 'required|date_format:Y-m-d',
            'end_data' => 'nullable|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }

        $captainId = auth('captain-api')->id();


        $orders = Order::where('status', 'done')
            ->where('captain_id', $captainId)
            ->where('date_created', $request->start_data)
            ->get();

        $OrderHour = OrderHour::where('status', 'done')
            ->where('captain_id', $captainId)
            ->where('date_created', $request->start_data)
            ->get();

        $OrderDay = OrderDay::where('status', 'done')
            ->where('captain_id', $captainId)
            ->where('date_created', $request->start_data)
            ->get();

        if ($request->start_data && $request->end_data) {

            $orders = Order::where('captain_id', $captainId)
                ->where('status', 'done')
                ->whereBetween('date_created', [$request->start_data, $request->end_data])
                ->get();

            $OrderHour = OrderHour::where('captain_id', $captainId)
                ->where('status', 'done')
                ->whereBetween('date_created', [$request->start_data, $request->end_data])
                ->get();

            $OrderDay = OrderDay::where('captain_id', $captainId)
                ->where('status', 'done')
                ->whereBetween('date_created', [$request->start_data, $request->end_data])
                ->get();
        }

        $ordersSum = $orders->sum('total_price');
        $OrderHourSum = $OrderHour->sum('total_price');
        $OrderDaySum = $OrderDay->sum('total_price');

        $data = $orders->concat($OrderHour)->concat($OrderDay);
        $total = $ordersSum + $OrderHourSum + $OrderDaySum;

        $responseData = [
            'data' => OrdersAllResources::collection($data),
            'total' => getTotalPrice($total),
        ];

        return $this->successResponse($responseData, 'Data returned successfully');
    }
}
