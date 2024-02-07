<?php

namespace App\Http\Controllers\Api\Drivers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Users\RateCommentUserResources;
use App\Models\CaptainProfile;
use App\Models\Order;
use App\Models\Captain;
use App\Models\OrderDay;
use App\Models\OrderHour;
use App\Models\RateComment;
use App\Models\Traits\Api\ApiResponseTrait;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RateCommentController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        try {
            $data = RateComment::where('captain_id', auth('captain-api')->id())->get();
            return $this->successResponse(RateCommentUserResources::collection($data), 'data Return Successfully');
        } catch (\Exception $exception) {
            return $this->errorResponse('Something went wrong, please try again later');
        }
    }

//    public function store(Request $request)
//    {
//        $validator = Validator::make($request->all(), [
//            'order_code' => [
//                'required',
//                function ($attribute, $value, $fail) {
//                    $foundInOrders = DB::table('orders')->where('order_code', $value)->exists();
//                    $foundInOrderDays = DB::table('order_days')->where('order_code', $value)->exists();
//                    $foundInOrderHours = DB::table('order_hours')->where('order_code', $value)->exists();
//
//                    if (!$foundInOrders && !$foundInOrderDays && !$foundInOrderHours) {
//                        $fail("$attribute is invalid.");
//                    }
//                },
//            ],
//            'rate' => 'required|numeric|between:1,5',
//            'comment' => 'nullable|string',
//        ]);
//
//        if ($validator->fails()) {
//            return $this->errorResponse($validator->errors(), 400);
//        }
//
//        try {
//            $findOrder = Order::where('order_code', $request->order_code)->first();
//            $data = RateComment::create([
//                'order_id' => $findOrder->id,
//                'captain_id' => $findOrder->captain_id,
//                'user_id' => $findOrder->user_id,
//                'rate' => $request->rate,
//                'comment' => $request->comment ?? null,
//                'type' => 'caption',
//            ]);
//
//            if ($data) {
//                $caption = Captain::findorfail($findOrder->captain_id);
//                sendNotificationCaptain($caption->fcm_token, "شكرا على تقيمكم", '');
//                $rateCaptainCount = RateComment::where('captain_id', $findOrder->captain_id)->count();
//                $rateCaptainSum = RateComment::where('captain_id', $findOrder->captain_id)->sum('rate');
//
//                if ($rateCaptainCount && $rateCaptainSum) {
//                    CaptainProfile::where('captain_id', $findOrder->captain_id)->update([
//                        'rate' =>  number_format($rateCaptainSum / $rateCaptainCount , 1),
//                    ]);
//                }
//
//                return $this->successResponse(new RateCommentUserResources($data), 'data Return Successfully');
//
//
//            }
//        } catch (\Exception $exception) {
//            return $this->errorResponse('Something went wrong, please try again later');
//        }
//    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_code' => [
                'required',
                function ($attribute, $value, $fail) {
                    $foundInOrders = DB::table('orders')->where('order_code', $value)->exists();
                    $foundInOrderDays = DB::table('order_days')->where('order_code', $value)->exists();
                    $foundInOrderHours = DB::table('order_hours')->where('order_code', $value)->exists();

                    if (!$foundInOrders && !$foundInOrderDays && !$foundInOrderHours) {
                        $fail("$attribute is invalid.");
                    }
                },
            ],
            'rate' => 'required|numeric|between:1,5',
            'comment' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 400);
        }



        try {
            $findOrder = Order::where('order_code', $request->order_code)->first();
            $findOrderHours = OrderHour::where('order_code', $request->order_code)->first();
            $findOrderDay = OrderDay::where('order_code', $request->order_code)->first();

            if ($findOrder){
                $data = RateComment::create([
                    'order_day_id' => null,
                    'order_hour_id' => null,
                    'order_id' => optional($findOrder)->id,
                    'captain_id' => $findOrder->captain_id,
                    'user_id' => $findOrder->user_id,
                    'rate' => $request->rate,
                    'comment' => $request->comment ?? null,
                    'type' => 'caption',
                ]);

                if ($data) {
                    $this->sendNotificationToCaptain($findOrder->captain_id);
                    $this->updateCaptainRating($findOrder->captain_id);

                    return $this->successResponse(new RateCommentUserResources($data), 'Data returned successfully');
                }
            }

            if ($findOrderHours){
                $data = RateComment::create([
                    'order_day_id' => null,
                    'order_hour_id' => $findOrderHours->id,
                    'order_id' => null,
                    'captain_id' => $findOrderHours->captain_id,
                    'user_id' => $findOrderHours->user_id,
                    'rate' => $request->rate,
                    'comment' => $request->comment ?? null,
                    'type' => 'caption',
                ]);

                if ($data) {
                    $this->sendNotificationToCaptain($findOrderHours->captain_id);
                    $this->updateCaptainRating($findOrderHours->captain_id);

                    return $this->successResponse(new RateCommentUserResources($data), 'Data returned successfully');
                }
            }
            if ($findOrderDay){
                $data = RateComment::create([
                    'order_day_id' => $findOrderDay->id,
                    'order_hour_id' => null,
                    'order_id' => null,
                    'captain_id' => $findOrderDay->captain_id,
                    'user_id' => $findOrderDay->user_id,
                    'rate' => $request->rate,
                    'comment' => $request->comment ?? null,
                    'type' => 'caption',
                ]);

                if ($data) {
                    $this->sendNotificationToCaptain($findOrderDay->captain_id);
                    $this->updateCaptainRating($findOrderDay->captain_id);

                    return $this->successResponse(new RateCommentUserResources($data), 'Data returned successfully');
                }
            }



        } catch (\Exception $exception) {
            return $this->errorResponse('Something went wrong, please try again later');
        }
    }


    private function sendNotificationToCaptain($captainId)
    {
        $caption = Captain::findOrFail($captainId);
        sendNotificationCaptain($caption->id, "شكرا على تقييمكم", '',true);
    }

    private function updateCaptainRating($captainId)
    {
        $rateCaptainCount = RateComment::where('captain_id', $captainId)->count();
        $rateCaptainSum = RateComment::where('captain_id', $captainId)->sum('rate');

        if ($rateCaptainCount && $rateCaptainSum) {
            CaptainProfile::where('captain_id', $captainId)->update([
                'rate' => number_format($rateCaptainSum / $rateCaptainCount, 1),
            ]);
        }
    }


}
