<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResources;
use App\Models\Country;
use App\Models\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        try {
//            return $this->successResponse(CountryResources::collection(Country::whereStatus(true)->get()), 'data Return Successfully');
            $sortedCountries = Country::whereStatus(true)->get()->sortBy(function ($country) {
                return $country->id == 65 ? 0 : 1;
            });

            return $this->successResponse(CountryResources::collection($sortedCountries), 'data Return Successfully');

        } catch (\Exception $exception) {
            $this->errorResponse('Something went wrong, please try again later');
        }
    }

    public function show($id)
    {
        try {
            return $this->successResponse(new CountryResources(Country::findorfail($id)), 'data Return Successfully');
        } catch (\Exception $exception) {
            $this->errorResponse('Something went wrong, please try again later');
        }
    }
}
