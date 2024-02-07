<?php

namespace App\Http\Controllers\Api\Orders;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Captain;
use App\Models\OrderTakingScooter;
use App\Models\OrderCanselScooter;
use App\Models\UserProfile;
use App\Models\CaptainProfile;
use App\Models\CaptionActivity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Traits\Api\ApiResponseTrait;
use App\Models\OrderScooter;
use App\Http\Resources\Orders\OrdersScooterResources;

class OrdersScooterController extends Controller
{
    use ApiResponseTrait;

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

        $orderQuery = OrderScooter::whereNotIn('status', ['done', 'cancel'])->latest();


        $captainIdFromOrder = $orderQuery->pluck('captain_id')->first();


        $captionActivity = CaptionActivity::where('captain_id', $captainIdFromOrder)->first();



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


        $responsenull = [
            'orderCodeValue' => "",
            'trip_type_id' => "",
            'longitude' => "",
            'latitude' => "",
        ];
        return $this->successResponse($responsenull, 'No data found');
    }

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_code' => 'required|exists:order_scooters,order_code',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 400);
        }

        try {
            $order = OrderScooter::where('order_code', $request->order_code)->firstOrFail();
            return $this->successResponse(new OrdersScooterResources($order), 'Data created successfully');
        }catch (\Exception $exception){
            return $this->errorResponse('Something went wrong, please try again later');
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'captain_id' => 'required|exists:captains,id',

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

        if (OrderScooter::where('user_id', $request->user_id)->where('status', 'pending')->exists()) {
            return $this->errorResponse('This client is already on a journey');
        }

        if (OrderScooter::where('captain_id', $request->captain_id)->where('status', 'pending')->exists()) {
            return $this->errorResponse('This captain is already on a journey');
        }

        try {
            $latestOrderId = optional(OrderScooter::latest()->first())->id;
            $orderCode = 'order_' . $latestOrderId . generateRandomString(5);
            $chatId = 'chat_' . generateRandomString(4);
            $user = User::findorfail($request->user_id);
            $caption = Captain::findorfail($request->captain_id);

            $data = OrderScooter::create([
                'address_now' => $request->address_now,
                'address_going' => $request->address_going,
                'user_id' => $request->user_id,
                'captain_id' => $request->captain_id,
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
                sendNotificationCaptain($request->captain_id, 'تم قبول الرحله من قبل العميل  ' . $user->name, 'رحله جديده', true);
                sendNotificationUser($request->user_id, 'تم قبول الرحله من قبل الكابتن ' . $caption->name, 'رحله جديده', true);
                createInFirebaseScooter($request->user_id, $request->captain_id, $data->id);

                $data->takingOrder()->create([
                    'lat_caption' => $request->lat_caption,
                    'long_caption' => $request->long_caption,
                ]);
            }

            return $this->successResponse(new OrdersScooterResources($data), 'Data created successfully');
        } catch (\Exception $exception) {
            return $this->errorResponse('Something went wrong, please try again later');
        }
    }


    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_code' => 'required|exists:order_scooters,order_code',
            'status' => 'required|in:done,waiting,pending,cancel,accepted',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 400);
        }

        try {
            $order = OrderScooter::where('order_code', $request->order_code)->first();
            if (!$order) {
                return $this->errorResponse('Order not found', 404);
            }

            if ($request->status == 'done') {
                $this->completeOrder($order, $request->type);
            } else {
                $this->updateOrderStatus($order, $request->status, $request->type);
            }

            return $this->successResponse(new OrdersScooterResources($order), 'Data updated successfully');
        } catch (\Exception $exception) {
            return $this->errorResponse('Something went wrong, please try again later');
        }
    }


    private function completeOrder($order, $type)
    {
        CaptionActivity::where('captain_id', $order->captain_id)->update(['type_captain' => 'active']);
        $order->update(['status' => 'done']);
        $this->takingCompleted($order->order_code);
        sendNotificationUser($order->user_id, 'لقد تم انتهاء الرحله بنجاح', 'رحله سعيده', true);
        sendNotificationCaptain($order->captain_id, 'لقد تم انتهاء الرحله بنجاح', 'رحله سعيده كابتن', true);
        DeletedInFirebaseScooter($order->user_id, $order->captain_id, $order->id);
    }

    private function updateOrderStatus($order, $status, $type)
    {
        $order->update(['status' => $status]);
        sendNotificationUser($order->user_id, 'تغير حاله الطلب', $order->status(), true);
        sendNotificationCaptain($order->captain_id, 'تغير حاله الطلب', $order->status(), true);
    }

    public function cancelOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_code' => 'required|exists:order_scooters,order_code',
            'cansel' => 'required',
            'type' => 'required|in:user,caption',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 400);
        }

        $findOrder = OrderScooter::where('order_code', $request->order_code)->first();
        $canselModel = OrderCanselScooter::class;
        $firebaseDeletion = 'DeletedInFirebaseScooter';
        $resourceType = OrdersScooterResources::class;

        if (!$findOrder) {
            return $this->errorResponse('Order not found', 404);
        }

        $findOrder->update([
            'status' => 'cancel',
        ]);

        $canselModel::create([
            'type' => $request->type,
            'order_scooter_id' => $findOrder->id,
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
            'order_code' => 'required|exists:order_scooters,order_code',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 400);
        }

        $checkOrder = OrderScooter::where('order_code', $request->order_code)->first();

        if (!$checkOrder) {
            return $this->errorResponse('Order Code does not exist', 404);
        }

        return $this->successResponse(new OrdersScooterResources($checkOrder), 'Data returned successfully');
    }


    public function takingOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_code' => 'required|exists:order_scooters,order_code',
            'lat_caption' => 'required',
            'long_caption' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 400);
        }

        $findOrder = OrderScooter::where('order_code', $request->order_code)->first();

        if (!$findOrder) {
            return $this->errorResponse('Order not found', 404);
        }

        //        $this->sendNotationsCalculator();

        $findOrder->update([
            'lat_caption' => $request->lat_caption,
            'long_caption' => $request->long_caption,
        ]);

        OrderTakingScooter::where('order_scooter_id', $findOrder->id)->update([
            'lat_caption' => $request->lat_caption,
            'long_caption' => $request->long_caption,
        ]);

        return $this->successResponse(null, 'Data updated successfully');
    }


    public function takingCompleted($order_code)
    {
        $findOrder = OrderScooter::where('order_code', $order_code)->first();
        if ($findOrder) {
            CaptionActivity::where('captain_id', $findOrder->captain_id)->update([
                'longitude' => $findOrder->long_caption,
                'latitude' => $findOrder->lat_caption,
            ]);

            OrderTakingScooter::where('order_scooter_id', $findOrder->id)->delete();

        }
    }

}
