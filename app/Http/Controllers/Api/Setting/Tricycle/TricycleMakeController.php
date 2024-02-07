<?php

namespace App\Http\Controllers\Api\Setting\Tricycle;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tricycle\TricycleMakeResource;
use App\Models\TricycleMake;
use App\Models\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;

class TricycleMakeController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        try {
            return $this->successResponse(TricycleMakeResource::collection(TricycleMake::active()), 'data Return Successfully');
        } catch (\Exception $exception) {
            return  $this->errorResponse('Something went wrong, please try again later');
        }
    }

    public function show($id)
    {
        try {
            return $this->successResponse(new TricycleMakeResource(TricycleMake::findorfail($id)), 'data Return Successfully');
        } catch (\Exception $exception) {
            return $this->errorResponse('Something went wrong, please try again later');
        }
    }
}
