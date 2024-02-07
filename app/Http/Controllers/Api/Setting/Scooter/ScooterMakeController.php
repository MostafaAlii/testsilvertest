<?php

namespace App\Http\Controllers\Api\Setting\Scooter;

use App\Http\Controllers\Controller;
use App\Http\Resources\Scooter\ScooterMakeResource;
use App\Models\ScooterMake;
use App\Models\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;

class ScooterMakeController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        try {
            return $this->successResponse(ScooterMakeResource::collection(ScooterMake::active()), 'data Return Successfully');
        } catch (\Exception $exception) {
            return  $this->errorResponse('Something went wrong, please try again later');
        }
    }

    public function show($id)
    {
        try {
            return $this->successResponse(new ScooterMakeResource(ScooterMake::findorfail($id)), 'data Return Successfully');
        } catch (\Exception $exception) {
            return $this->errorResponse('Something went wrong, please try again later');
        }
    }
}
