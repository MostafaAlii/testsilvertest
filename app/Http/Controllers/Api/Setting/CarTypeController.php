<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarTypeDayResources;
use App\Http\Resources\CarTypeResources;
use App\Models\CarType;
use App\Models\CarTypeDay;
use App\Models\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;

class CarTypeController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {

        try {
            return $this->successResponse(CarTypeResources::collection(CarType::active()), 'data Return Successfully');
        } catch (\Exception $exception) {
            return $this->errorResponse('Something went wrong, please try again later');
        }
    }

    public function show($id)
    {
        try {
            return $this->successResponse(new CarTypeResources(CarType::findorfail($id)), 'data Return Successfully');
        } catch (\Exception $exception) {
            $this->errorResponse('Something went wrong, please try again later');
        }
    }





    public function index_day()
    {
        try {
            return $this->successResponse(CarTypeDayResources::collection(CarTypeDay::active()), 'data Return Successfully');
        } catch (\Exception $exception) {
            $this->errorResponse('Something went wrong, please try again later');
        }
    }




    public function show_day($id)
    {
        try {
            return $this->successResponse(new CarTypeDayResources(CarTypeDay::findorfail($id)), 'data Return Successfully');
        } catch (\Exception $exception) {
            $this->errorResponse('Something went wrong, please try again later');
        }
    }
}
