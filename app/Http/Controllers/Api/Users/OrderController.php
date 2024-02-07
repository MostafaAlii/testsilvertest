<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\Orders\AllOrdersResources;
use App\Http\Resources\Orders\OrdersResources;
use App\Models\Order;
use App\Models\OrderDay;
use App\Models\OrderHour;
use App\Models\SaveRentDay;
use App\Models\SaveRentHour;
use App\Models\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ApiResponseTrait;

//    public function index()
//    {
//        $orders = Order::where('user_id', auth('users-api')->id())
//            ->whereIn('status', ['done', 'cancel'])
//            ->paginate(15);
//
//        $orderHours = OrderHour::where('user_id', auth('users-api')->id())
//            ->whereIn('status', ['done', 'cancel'])->paginate(15);
//
//
//        $orderDay = OrderDay::where('user_id', auth('users-api')->id())
//            ->whereIn('status', ['done', 'cancel'])->paginate(15);
//
//        $dataAllOrders = $orders->concat($orderHours)->concat($orderDay);
//
//        $data = OrdersResources::collection($dataAllOrders);
//        $response = [
//            'data' => $data,
//            'pagination' => [
//                'total' => $data->total(),
//                'per_page' => $data->perPage(),
//                'current_page' => $data->currentPage(),
//                'last_page' => $data->lastPage(),
//                'from' => $data->firstItem(),
//                'to' => $data->lastItem(),
//                'next_page_url' => $data->nextPageUrl(),
//            ],
//        ];
//        return $this->successResponse($response, 'data return successfully');
//    }

    public function index()
    {
        $userId = auth('users-api')->id();

        $orders = Order::where('user_id', $userId)
            ->whereIn('status', ['done', 'cancel'])
            ->orderByDesc('date_created')
            ->paginate(5);

        $orderSavesHours = SaveRentHour::where('user_id', $userId)
            ->whereIn('status', ['done', 'cancel'])
            ->orderByDesc('date_created')
            ->paginate(5);

        $orderSaveDay = SaveRentDay::where('user_id', $userId)
            ->whereIn('status', ['done', 'cancel'])
            ->orderByDesc('date_created')
            ->paginate(5);

        $orderHours = OrderHour::where('user_id', $userId)
            ->whereIn('status', ['done', 'cancel'])
            ->orderByDesc('date_created')
            ->paginate(5);

        $orderDay = OrderDay::where('user_id', $userId)
            ->whereIn('status', ['done', 'cancel'])
            ->orderByDesc('date_created')
            ->paginate(5);

        $dataAllOrders = $orders->concat($orderHours)->concat($orderDay)->concat($orderSavesHours)->concat($orderSaveDay);

        $data = AllOrdersResources::collection($dataAllOrders);

        $pagination = [
            'total' => $orders->total() + $orderHours->total() + $orderDay->total() + $orderSavesHours->total() + $orderSaveDay->total(),
            'per_page' => ($orders->perPage() ?? 0) + ($orderHours->perPage() ?? 0) + ($orderDay->perPage() ?? 0) + ($orderSavesHours->perPage() ?? 0) + ($orderSaveDay->perPage() ?? 0),
            'current_page' => ($orders->currentPage() ?? 0) + ($orderHours->currentPage() ?? 0) + ($orderDay->currentPage() ?? 0) + ($orderSavesHours->currentPage() ?? 0) + ($orderSaveDay->currentPage() ?? 0),
            'last_page' => ($orders->lastPage() ?? 0) + ($orderHours->lastPage() ?? 0) + ($orderDay->lastPage() ?? 0) + ($orderSavesHours->lastPage() ?? 0) + ($orderSaveDay->lastPage() ?? 0),
            'from' => ($orders->firstItem() ?? 0) + ($orderHours->firstItem() ?? 0) + ($orderDay->firstItem() ?? 0) + ($orderSavesHours->firstItem() ?? 0) + ($orderSaveDay->firstItem() ?? 0),
            'to' => ($orders->lastItem() ?? 0) + ($orderHours->lastItem() ?? 0) + ($orderDay->lastItem() ?? 0) + ($orderSavesHours->lastItem() ?? 0) + ($orderSaveDay->lastItem() ?? 0),
            'next_page_url' => ($orders->nextPageUrl() ?? '') . ($orderHours->nextPageUrl() ?? '') . ($orderDay->nextPageUrl() ?? '') . ($orderSavesHours->nextPageUrl() ?? '') . ($orderSaveDay->nextPageUrl() ?? ''),
        ];

        $response = [
            'data' => $data,
            'pagination' => $pagination,
        ];

        return $this->successResponse($response, 'Data returned successfully');
    }


    public function lasts()
    {
        $orders = Order::where('user_id', auth('users-api')->id())->latest()->take(2)->get();
        return $this->successResponse(OrdersResources::collection($orders), 'data return successfully');
    }
}
