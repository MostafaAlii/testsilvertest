<?php

namespace App\Http\Controllers\Api\Setting\Scooter;

use App\Http\Controllers\Controller;
use App\Http\Resources\Scooter\ScooterModelResource;
use App\Models\ScooterModel;
use App\Models\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;

class ScooterModelController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        try {
            return $this->successResponse(ScooterModelResource::collection(ScooterModel::active()), 'data Return Successfully');
        } catch (\Exception $exception) {
            $this->errorResponse('Something went wrong, please try again later');
        }
    }

    public function show($id)
    {
        try {
            return $this->successResponse(new ScooterModelResource(ScooterModel::findorfail($id)), 'data Return Successfully');
        } catch (\Exception $exception) {
            $this->errorResponse('Something went wrong, please try again later');
        }
    }
}
