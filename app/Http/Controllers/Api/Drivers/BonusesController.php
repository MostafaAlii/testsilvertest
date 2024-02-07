<?php

namespace App\Http\Controllers\Api\Drivers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Drivers\BonusResources;
use App\Models\Bonus;
use App\Models\CaptainProfile;
use App\Models\CaptionBonus;
use App\Models\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BonusesController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        try {
            $data = Bonus::get();
            return $this->successResponse(BonusResources::collection($data), 'data Return Successfully');
        } catch (\Exception $exception) {
            return $this->errorResponse('Something went wrong, please try again later');
        }
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bout' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 400);
        }
        try {

            $Profile = CaptainProfile::where('captain_id', auth('captain-api')->id())->first();

            if ($Profile->point >= $request->bout) {
                $data = CaptionBonus::create([
                    'captain_id' => auth('captain-api')->id(),
                    'bout' => $request->bout,
                    'status' => 'active',
                ]);

                $Profile->update([
                    'point' => $Profile->point - $request->bout,
                ]);

                if ($data) {
                    return $this->successResponse('Caption Created Successfully in bonuses');
                }
            } else {
                return $this->errorResponse('The Caption account is unable to calculate');
            }


        } catch (\Exception $exception) {
            return $this->errorResponse('Something went wrong, please try again later');
        }
    }

}
