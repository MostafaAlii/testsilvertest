<?php
namespace App\Http\Controllers\Api\Setting\Trunk;
use App\Http\Controllers\Controller;
use App\Http\Resources\Trunk\TrunkModelResource;
use App\Models\TrunkModel;
use App\Models\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;
class TrunkModelController extends Controller {
    use ApiResponseTrait;
    public function index() {
        try {
            return $this->successResponse(TrunkModelResource::collection(TrunkModel::active()), 'data Return Successfully');
        } catch (\Exception $exception) {
            return  $this->errorResponse('Something went wrong, please try again later');
        }
    }

    public function show($id) {
        try {
            return $this->successResponse(new TrunkModelResource(TrunkModel::findorfail($id)), 'data Return Successfully');
        } catch (\Exception $exception) {
            return $this->errorResponse('Something went wrong, please try again later');
        }
    }
}
