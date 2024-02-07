<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\Users\RateCommentUserResources;
use App\Models\CaptainProfile;
use App\Models\Order;
use App\Models\OrderDay;
use App\Models\OrderHour;
use App\Models\User;
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
            $data = RateComment::where('user_id', auth('users-api')->id())->get();
            return $this->successResponse(RateCommentUserResources::collection($data), 'data Return Successfully');
        } catch (\Exception $exception) {
            return $this->errorResponse('Something went wrong, please try again later');
        }
    }


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

            $data = RateComment::create([
                'order_day_id' => optional($findOrderDay)->id,
                'order_hour_id' => optional($findOrderHours)->id,
                'order_id' => optional($findOrder)->id,
                'user_id' => $findOrder->user_id,
                'captain_id' => $findOrder->captain_id,
                'rate' => $request->rate,
                'comment' => $request->comment ?? null,
                'type' => 'user',
            ]);

            if ($data) {
                $this->sendNotificationToUser($findOrder->user_id);
                $this->updateUserRating($findOrder->user_id);
                return $this->successResponse(new RateCommentUserResources($data), 'data Return Successfully');


            }
        } catch (\Exception $exception) {
            return $this->errorResponse('Something went wrong, please try again later');
        }
    }


    private function sendNotificationToUser($captainId)
    {
        $caption = User::findOrFail($captainId);
        sendNotificationUser($caption->id, "شكرا على تقييمكم", '',true);
    }



    private function updateUserRating($userId)
    {
        $rateCaptainCount = RateComment::where('user_id', $userId)->count();
        $rateCaptainSum = RateComment::where('user_id', $userId)->sum('rate');

        if ($rateCaptainCount && $rateCaptainSum) {
            UserProfile::where('user_id', $userId)->update([
                'rate' => number_format($rateCaptainSum / $rateCaptainCount, 1),
            ]);
        }
    }
}
