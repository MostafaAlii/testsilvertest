<?php

namespace App\Http\Controllers\Api\Setting\CMS;
use App\Models\Cms\CmsOffer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Traits\Api\ApiResponseTrait;
use App\Http\Resources\CMS\OfferResources;

class OfferController extends Controller {
    use ApiResponseTrait;

    public function index() {
        try {
            return $this->successResponse(OfferResources::collection(CmsOffer::active()), 'data Return Successfully');
        } catch (\Exception $exception) {
            return $this->errorResponse('Something went wrong, please try again later');
        }
    }

    public function show($id) {
        try {
            return $this->successResponse(new OfferResources(CmsOffer::findorfail($id)), 'data Return Successfully');
        } catch (\Exception $exception) {
            $this->errorResponse('Something went wrong, please try again later');
        }
    }
}