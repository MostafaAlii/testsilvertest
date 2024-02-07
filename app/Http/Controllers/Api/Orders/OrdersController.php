<?php

namespace App\Http\Controllers\Api\Orders;

use App\Http\Controllers\Controller;
use App\Http\Resources\Orders\AllOrdersSavedRentResources;
use App\Http\Resources\Orders\OrdersDayResources;
use App\Http\Resources\Orders\OrdersHoursResources;
use App\Http\Resources\Orders\OrdersResources;
use App\Models\CanselOrder;
use App\Models\CanselOrderHoursDay;
use App\Models\Captain;
use App\Models\CaptainProfile;
use App\Models\CaptionActivity;
use App\Models\Order;
use App\Models\OrderDay;
use App\Models\OrderHour;
use App\Models\SaveRentDay;
use App\Models\SaveRentHour;
use App\Models\TakingOrder;
use App\Models\Traits\Api\ApiResponseTrait;
use App\Models\User;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use function Symfony\Component\String\b;

class OrdersController extends Controller
{

    use ApiResponseTrait;


//    public function rest()
//    {
//        Order::query()->delete();
//        OrderHour::query()->delete();
//        OrderDay::query()->delete();
//        CanselOrder::query()->delete();
//        TakingOrder::query()->delete();
//        CaptionActivity::where('captain_id', 3)->update([
//            'type_captain' => 'active',
//            'status_captain' => 'active',
//            'status_captain_work' => 'active',
//        ]);
//        return response()->json('ok');
//    }


    //    public function OrderExiting(Request $request)
    //    {
    //        $validator = Validator::make($request->all(), [
    //            'user_id' => 'required_if:type,user|exists:users,id',
    //            'captain_id' => 'required_if:type,captains|exists:captains,id',
    //            'type' => 'required|in:captains,user',
    //        ]);
    //
    //        if ($validator->fails()) {
    //            return $this->errorResponse($validator->errors(), 400);
    //        }
    //
    //        $type = $request->type;
    //        $orderQuery = Order::whereNotIn('status', ['done', 'cancel', 'accepted'])->latest();
    //
    //        $orderCode = $orderQuery->when($type == "captains", function ($query) use ($request) {
    //            return $query->where('captain_id', $request->captain_id);
    //        }, function ($query) use ($request) {
    //            return $query->where('user_id', $request->user_id);
    //        })->firstOr(fn() => null);
    //
    //        $orderCodeValue = optional($orderCode)->order_code  . ' (Trip_Id) '.optional($orderCode)->trip_type_id;
    //
    //        return $this->successResponse($orderCodeValue ? $orderCodeValue : "", 'Data returned successfully');
    //
    //    }

    public function OrderExiting(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required_if:type,user|exists:users,id',
            'captain_id' => 'required_if:type,captains|exists:captains,id',
            'type' => 'required|in:captains,user',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 400);
        }


        $type = $request->type;

        $orderQuery = Order::whereNotIn('status', ['done', 'cancel'])->latest();
        $orderQuery2 = OrderHour::whereNotIn('status', ['done', 'cancel'])->latest();
        $orderQuery3 = OrderDay::whereNotIn('status', ['done', 'cancel'])->latest();

        $captainIdFromOrder = $orderQuery->pluck('captain_id')->first();
        $captainIdFromOrderHour = $orderQuery2->pluck('captain_id')->first();
        $captainIdFromOrderDay = $orderQuery3->pluck('captain_id')->first();

        $captionActivity = CaptionActivity::where('captain_id', $captainIdFromOrder)->first();
        $captionActivityHours = CaptionActivity::where('captain_id', $captainIdFromOrderHour)->first();
        $captionActivityDay = CaptionActivity::where('captain_id', $captainIdFromOrderDay)->first();


        $orderCode = $orderQuery->when($type == "captains", function ($query) use ($request) {
            return $query->where('captain_id', $request->captain_id);
        }, function ($query) use ($request) {
            return $query->where('user_id', $request->user_id);
        })->firstOr(function () {
            return null;
        });

        if ($orderCode) {
            $orderCodeValue = optional($orderCode)->order_code;
            $trip_type_id = optional($orderCode)->trip_type_id;
            $responseData = [
                'orderCodeValue' => "$orderCodeValue" ? "$orderCodeValue" : "",
                'trip_type_id' => "$trip_type_id" ? "$trip_type_id" : "",
                'longitude' => "$captionActivity->longitude" ? "$captionActivity->longitude" : "",
                'latitude' => "$captionActivity->latitude" ? "$captionActivity->latitude" : "",

            ];
            return $this->successResponse($responseData != null ? $responseData : "", 'Data returned successfully');
        }

        $orderCode2 = $orderQuery2->when($type == "captains", function ($query) use ($request) {
            return $query->where('captain_id', $request->captain_id);
        }, function ($query) use ($request) {
            return $query->where('user_id', $request->user_id);
        })->firstOr(function () {
            return null;
        });

        if ($orderCode2) {
            $orderCodeValue = optional($orderCode2)->order_code;
            $trip_type_id = optional($orderCode2)->trip_type_id;
            $responseData = [
                'orderCodeValue' => "$orderCodeValue" ? "$orderCodeValue" : "",
                'trip_type_id' => "$trip_type_id" ? "$trip_type_id" : "",
                'longitude' => "$captionActivityHours->longitude" ? "$captionActivityHours->longitude" : "",
                'latitude' => "$captionActivityHours->latitude" ? "$captionActivityHours->latitude" : "",
            ];
            return $this->successResponse($responseData != null ? $responseData : "", 'Data returned successfully');
        }

        $orderCode3 = $orderQuery3->when($type == "captains", function ($query) use ($request) {
            return $query->where('captain_id', $request->captain_id);
        }, function ($query) use ($request) {
            return $query->where('user_id', $request->user_id);
        })->firstOr(function () {
            return null;
        });

        if ($orderCode3) {
            $orderCodeValue = optional($orderCode3)->order_code;
            $trip_type_id = optional($orderCode3)->trip_type_id;
            $responseData = [
                'orderCodeValue' => "$orderCodeValue" ? "$orderCodeValue" : "",
                'trip_type_id' => "$trip_type_id" ? "$trip_type_id" : "",
                'longitude' => "$captionActivityDay->longitude" ? "$captionActivityDay->longitude" : "",
                'latitude' => "$captionActivityDay->latitude" ? "$captionActivityDay->latitude" : "",
            ];
            return $this->successResponse($responseData != null ? $responseData : "", 'Data returned successfully');
        }

        $responsenull = [
            'orderCodeValue' => "",
            'trip_type_id' => "",
            'longitude' => "",
            'latitude' => "",
        ];
        return $this->successResponse($responsenull, 'No data found');
    }

    public function deletedOrder(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'order_code' => 'required|exists:orders,order_code',

        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 400);
        }

        try {
            Order::query()->delete();
            return $this->successResponse('data deleted successfully');
        } catch (\Exception $exception) {
            return $this->errorResponse('Something went wrong, please try again later');
        }
    }

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_code' => 'required',
            'type_order' => 'required|in:order,orderHours,orderDay',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 400);
        }

        try {
            $order = null;

            switch ($request->type_order) {
                case 'order':
                    $order = Order::where('order_code', $request->order_code)->firstOrFail();
                    break;

                case 'orderHours':
                    $order = OrderHour::where('order_code', $request->order_code)->firstOrFail();
                    break;

                case 'orderDay':
                    $order = OrderDay::where('order_code', $request->order_code)->firstOrFail();
                    break;

                default:
                    return $this->errorResponse('Invalid type_order', 400);
            }

            return $this->successResponse($this->getResourceByTypeOrders($order, $request->type_order), 'Data return successfully');

        } catch (\Exception $exception) {
            return $this->errorResponse('Something went wrong, please try again later');
        }
    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'captain_id' => 'required|exists:captains,id',
            'trip_type_id' => 'required|exists:trip_types,id',
            'total_price' => 'required|numeric',
            'payments' => 'required|in:cash,masterCard,wallet',
            'lat_user' => 'required',
            'long_user' => 'required',
            'lat_going' => 'required',
            'long_going' => 'required',
            'address_now' => 'required',
            'address_going' => 'required',
            'time_trips' => 'required',
            'distance' => 'required',
            'lat_caption' => 'required',
            'long_caption' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 400);
        }

        if (Order::where('user_id', $request->user_id)->where('status', 'pending')->exists()) {
            return $this->errorResponse('This client is already on a journey');
        }

        if (Order::where('captain_id', $request->captain_id)->where('status', 'pending')->exists()) {
            return $this->errorResponse('This captain is already on a journey');
        }

        try {
            $latestOrderId = optional(Order::latest()->first())->id;
            $orderCode = 'order_' . $latestOrderId . generateRandomString(5);
            $chatId = 'chat_' . generateRandomString(4);
            $user = User::findorfail($request->user_id);
            $caption = Captain::findorfail($request->captain_id);

            $data = Order::create([
                'address_now' => $request->address_now,
                'address_going' => $request->address_going,
                'user_id' => $request->user_id,
                'captain_id' => $request->captain_id,
                'trip_type_id' => $request->trip_type_id,
                'order_code' => $orderCode,
                'total_price' => $request->total_price,
                'chat_id' => $chatId,
                'status' => 'pending',
                'payments' => $request->payments,
                'lat_user' => $request->lat_user,
                'long_user' => $request->long_user,
                'lat_going' => $request->lat_going,
                'long_going' => $request->long_going,
                'time_trips' => $request->time_trips,
                'distance' => $request->distance,
                'lat_caption' => $request->lat_caption,
                'long_caption' => $request->long_caption,
                'date_created' => Carbon::now()->format('Y-m-d'),
            ]);

            if ($data) {
                CaptionActivity::where('captain_id', $request->captain_id)->update(['type_captain' => 'inorder']);

                $data->takingOrder()->create([
                    'lat_caption' => $request->lat_caption,
                    'long_caption' => $request->long_caption,
                ]);


                sendNotificationCaptain($request->captain_id, 'تم قبول الرحله من قبل العميل  ' . $user->name, 'رحله جديده', true);
                sendNotificationUser($request->user_id, 'تم قبول الرحله من قبل الكابتن ' . $caption->name, 'رحله جديده', true);
                createInFirebase($request->user_id, $request->captain_id, $data->id);
            }

            return $this->successResponse(new OrdersResources($data), 'Data created successfully');
        } catch (\Exception $exception) {
            return $this->errorResponse('Something went wrong, please try again later');
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_code' => 'required',
            'status' => 'required|in:done,waiting,pending,cancel,accepted',
            'type' => 'required|in:order,orderDay,orderHour',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 400);
        }

        try {
            switch ($request->type) {
                case 'order':
                    $order = Order::where('order_code', $request->order_code)->first();
                    break;
                case 'orderDay':
                    $order = OrderDay::where('order_code', $request->order_code)->first();
                    break;
                case 'orderHour':
                    $order = OrderHour::where('order_code', $request->order_code)->first();
                    break;
                default:
                    return $this->errorResponse('Invalid order type', 400);
            }

            if (!$order) {
                return $this->errorResponse('Order not found', 404);
            }

            if ($request->status == 'done') {
                $this->completeOrder($order, $request->type);
            } else {
                $this->updateOrderStatus($order, $request->status, $request->type);
            }

            return $this->successResponse($this->getResourceByType($order, $request->type), 'Data updated successfully');
        } catch (\Exception $exception) {
            return $this->errorResponse('Something went wrong, please try again later');
        }
    }

    private function completeOrder($order, $type)
    {
        CaptionActivity::where('captain_id', $order->captain_id)->update(['type_captain' => 'active']);
        $order->update(['status' => 'done']);
        sendNotificationUser($order->user_id, 'لقد تم انتهاء الرحله بنجاح', 'رحله سعيده', true);
        sendNotificationCaptain($order->captain_id, 'لقد تم انتهاء الرحله بنجاح', 'رحله سعيده كابتن', true);

        switch ($type) {
            case 'order':
                DeletedInFirebase($order->user_id, $order->captain_id, $order->id);
                break;
            case 'orderDay':
                DeletedInFirebaseDay($order->user_id, $order->captain_id, $order->id);
                break;
            case 'orderHour':
                DeletedInFirebaseHours($order->user_id, $order->captain_id, $order->id);
                break;
        }
    }

    private function updateOrderStatus($order, $status, $type)
    {
        $order->update(['status' => $status]);

        sendNotificationUser($order->user_id, 'تغير حاله الطلب', $order->status(), true);
        sendNotificationCaptain($order->captain_id, 'تغير حاله الطلب', $order->status(), true);
    }

    private function getResourceByType($order, $type)
    {
        switch ($type) {
            case 'order':
                return new OrdersResources($order);
            case 'orderDay':
                return new OrdersDayResources($order);
            case 'orderHour':
                return new OrdersHoursResources($order);
        }
    }
    private function getResourceByTypeOrders($order, $type)
    {
        switch ($type) {
            case 'order':
                return new OrdersResources($order);
            case 'orderDay':
                return new OrdersDayResources($order);
            case 'orderHours':
                return new OrdersHoursResources($order);
        }
    }



//    public function update(Request $request)
//    {
//        $validator = Validator::make($request->all(), [
//            'order_code' => 'required|exists:orders,order_code',
//            'status' => 'required|in:done,waiting,pending,cancel,accepted',
//        ]);
//
//        if ($validator->fails()) {
//            return $this->errorResponse($validator->errors(), 400);
//        }
//
//        try {
//            $findOrder = Order::where('order_code', $request->order_code)->first();
//
//            if (!$findOrder) {
//                return $this->errorResponse('Order not found', 404);
//            }
//
//            if ($request->status == 'done') {
//                $this->completeOrder($findOrder);
//            } else {
//                $this->updateOrderStatus($findOrder, $request->status);
//            }
//
//            return $this->successResponse(new OrdersResources($findOrder), 'Data updated successfully');
//        } catch (\Exception $exception) {
//            return $this->errorResponse('Something went wrong, please try again later');
//        }
//    }
//
//    private function completeOrder(Order $order)
//    {
//        CaptionActivity::where('captain_id', $order->captain_id)->update(['type_captain' => 'active']);
//
//        $order->update(['status' => 'done']);
//
//        $this->updateUserProfile($order->user_id);
//        $this->updateCaptainProfile($order->captain_id);
//
//        sendNotificationUser($order->user_id, 'لقد تم انتهاء الرحله بنجاح', 'رحله سعيده', true);
//        sendNotificationCaptain($order->captain_id, 'لقد تم انتهاء الرحله بنجاح', 'رحله سعيده كابتن', true);
//
//        $this->takingCompleted($order->order_code);
//        DeletedInFirebase($order->user_id, $order->captain_id, $order->id);
//    }
//
//    private function updateOrderStatus(Order $order, $status)
//    {
//        $order->update(['status' => $status]);
//
//        sendNotificationUser($order->user_id, 'تغير حاله الطلب', $order->status(), true);
//        sendNotificationCaptain($order->captain_id, 'تغير حاله الطلب', $order->status(), true);
//    }

    private function updateUserProfile($userId)
    {
        $userProfile = UserProfile::where('user_id', $userId)->first();
        if ($userProfile) {
            $userProfile->update(['number_trips' => $userProfile->number_trips + 1]);
        }
    }

    private function updateCaptainProfile($captainId)
    {
        $captainProfile = CaptainProfile::where('captain_id', $captainId)->first();
        if ($captainProfile) {
            $captainProfile->update(['number_trips' => $captainProfile->number_trips + 1]);
        }
    }


    public function takingOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_code' => 'required|exists:orders,order_code',
            'lat_caption' => 'required',
            'long_caption' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 400);
        }

        $findOrder = Order::where('order_code', $request->order_code)->first();

        if (!$findOrder) {
            return $this->errorResponse('Order not found', 404);
        }

        //        $this->sendNotationsCalculator();

        $findOrder->update([
            'lat_caption' => $request->lat_caption,
            'long_caption' => $request->long_caption,
        ]);

        TakingOrder::where('order_id', $findOrder->id)->update([
            'lat_caption' => $request->lat_caption,
            'long_caption' => $request->long_caption,
        ]);

        return $this->successResponse(null, 'Data updated successfully');
    }


    public function takingCompleted($order_code)
    {
        $findOrder = Order::where('order_code', $order_code)->first();
        if ($findOrder) {
            CaptionActivity::where('captain_id', $findOrder->captain_id)->update([
                'longitude' => $findOrder->long_caption,
                'latitude' => $findOrder->lat_caption,
            ]);

            TakingOrder::where('order_id', $findOrder->id)->delete();
        }
    }

//    public function canselOrder(Request $request)
//    {
//        $validator = Validator::make($request->all(), [
//            'order_code' => 'required|exists:orders,order_code',
//            'cansel' => 'required',
//            'type' => 'required|in:user,caption',
//        ]);
//
//        if ($validator->fails()) {
//            return $this->errorResponse($validator->errors(), 400);
//        }
//
//        $findOrder = Order::where('order_code', $request->order_code)->first();
//
//        if (!$findOrder) {
//            return $this->errorResponse('Order not found', 404);
//        }
//
//        $findOrder->update([
//            'status' => 'cancel',
//        ]);
//
//        CanselOrder::create([
//            'type' => $request->type,
//            'order_id' => $findOrder->id,
//            'cansel' => $request->cansel,
//            'user_id' => $findOrder->user_id,
//            'captain_id' => $findOrder->captain_id,
//        ]);
//
//        if ($findOrder->user_id) {
//            $this->updateUserProfileForCancel($findOrder->user_id);
//        }
//
//        if ($findOrder->captain_id) {
//            $this->updateCaptainProfileForCancel($findOrder->captain_id);
//            CaptionActivity::where('captain_id', $findOrder->captain_id)->update([
//                'type_captain' => 'active',
//            ]);
//        }
//
//        sendNotificationUser($findOrder->user_id, 'تم الغاء الطلب', $request->cansel, true);
//        sendNotificationCaptain($findOrder->captain_id, 'تم الغاء الطلب', $request->cansel, true);
//
//        DeletedInFirebase($findOrder->user_id, $findOrder->captain_id, $findOrder->id);
//
//        return $this->successResponse(new OrdersResources($findOrder), 'Data updated successfully');
//    }

    public function cancelOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_code' => 'required',
            'cansel' => 'required',
            'type' => 'required|in:user,caption',
            'type_order' => 'required|in:order,orderDay,orderHour',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 400);
        }

        switch ($request->type_order) {
            case 'order':
                $findOrder = Order::where('order_code', $request->order_code)->first();
                $canselModel = CanselOrder::class;
                $resourceType = OrdersResources::class;
                $firebaseDeletion = 'DeletedInFirebase';
                break;
            case 'orderDay':
                $findOrder = OrderDay::where('order_code', $request->order_code)->first();
                $canselModel = CanselOrderHoursDay::class;
                $resourceType = OrdersDayResources::class;
                $firebaseDeletion = 'DeletedInFirebaseDay';
                break;
            case 'orderHour':
                $findOrder = OrderHour::where('order_code', $request->order_code)->first();
                $canselModel = CanselOrderHoursDay::class;
                $resourceType = OrdersHoursResources::class;
                $firebaseDeletion = 'DeletedInFirebaseHours';
                break;
            default:
                return $this->errorResponse('Invalid order type', 400);
        }

        if (!$findOrder) {
            return $this->errorResponse('Order not found', 404);
        }

        $findOrder->update([
            'status' => 'cancel',
        ]);

        $canselModel::create([
            'type' => $request->type,
            'order_id' => $findOrder->id,
            'cansel' => $request->cansel,
            'user_id' => $findOrder->user_id,
            'captain_id' => $findOrder->captain_id,
        ]);

        if ($findOrder->user_id) {
            $this->updateUserProfileForCancel($findOrder->user_id);
        }

        if ($findOrder->captain_id) {
            $this->updateCaptainProfileForCancel($findOrder->captain_id);
            CaptionActivity::where('captain_id', $findOrder->captain_id)->update([
                'type_captain' => 'active',
            ]);
        }

        sendNotificationUser($findOrder->user_id, 'تم الغاء الطلب', $request->cansel, true);
        sendNotificationCaptain($findOrder->captain_id, 'تم الغاء الطلب', $request->cansel, true);

        $firebaseDeletion($findOrder->user_id, $findOrder->captain_id, $findOrder->id);

        return $this->successResponse(new $resourceType($findOrder), 'Data updated successfully');
    }

    private function updateUserProfileForCancel($userId)
    {
        $userProfile = UserProfile::where('user_id', $userId)->first();
        if ($userProfile) {
            $userProfile->update([
                'number_trips_cansel' => $userProfile->number_trips_cansel + 1
            ]);
        }
    }

    private function updateCaptainProfileForCancel($captainId)
    {
        $captainProfile = CaptainProfile::where('captain_id', $captainId)->first();
        if ($captainProfile) {
            $captainProfile->update([
                'number_trips_cansel' => $captainProfile->number_trips_cansel + 1
            ]);
        }
    }


    public function checkOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_code' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 400);
        }

        $checkOrder = Order::where('order_code', $request->order_code)->first();

        if (!$checkOrder) {
            return $this->errorResponse('Order Code does not exist', 404);
        }

        return $this->successResponse(new OrdersResources($checkOrder), 'Data returned successfully');
    }


    public function getSavedOrders()
    {
        $user = auth('users-api')->user();

        $ordersHourSaved = SaveRentHour::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'accepted'])
            ->orderBy('id', 'DESC')
            ->get();

        $ordersDaySaved = SaveRentDay::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'accepted'])
            ->orderBy('id', 'DESC')
            ->get();

        $ordersHours = OrderHour::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'accepted'])
            ->orderBy('id', 'DESC')
            ->get();

        $ordersDay = OrderDay::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'accepted'])
            ->orderByDesc('date_created')
            ->get();

        $data = $ordersHourSaved->union($ordersDaySaved)->union($ordersHours)->union($ordersDay);

        return $this->successResponse(AllOrdersSavedRentResources::collection($data), 'Data returned successfully');

    }
}
