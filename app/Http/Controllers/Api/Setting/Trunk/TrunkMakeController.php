<?php
namespace App\Http\Controllers\Api\Setting\Trunk;
use App\Http\Controllers\Controller;
use App\Http\Resources\Trunk\TrunkMakeResource;
use App\Models\TrunkMake;
use App\Models\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;
class TrunkMakeController extends Controller {
    use ApiResponseTrait;
    public function index() {
        try {
            return $this->successResponse(TrunkMakeResource::collection(TrunkMake::active()), 'data Return Successfully');
        } catch (\Exception $exception) {
            return  $this->errorResponse('Something went wrong, please try again later');
        }
    }

    public function show($id) {
        try {
            return $this->successResponse(new TrunkMakeResource(TrunkMake::findorfail($id)), 'data Return Successfully');
        } catch (\Exception $exception) {
            return $this->errorResponse('Something went wrong, please try again later');
        }
    }
}
