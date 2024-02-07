<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\Users\CaptionActivityUserResources;
use App\Models\Captain;
use App\Models\CaptionActivity;
use App\Models\CarsCaption;
use App\Models\CarType;
use App\Models\CategoryCar;
use App\Models\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CaptionActivityUserController extends Controller
{
    use ApiResponseTrait;

    //    public function captionActivity(Request $request)
    //    {
    //
    //        $validator = Validator::make($request->all(), [
    //            'latitude' => 'required',
    //            'longitude' => 'required',
    //        ]);
    //
    //        if ($validator->fails()) {
    //            return $this->errorResponse($validator->errors()->first(), 422);
    //        }
    //
    //        try {
    //            $latitude = $request->input('latitude');
    //            $longitude = $request->input('longitude');
    //            $radius = 50;
    //            $categoryCars = $request->category_car_id; //  // فئات السيارات ( A , B  , C
    //            $CarTypes = $request->car_type_id;  // انواع السياارت ( سيدان - suv
    //
    //            if ($categoryCars) {
    //                if ($categoryCars == 1) {
    //                    $CarsCaption = CarsCaption::where('category_car_id', 1)->get();
    //                    $captains = CaptionActivity::whereIn('captain_id', $CarsCaption->id)->where('status_captain_work', 'active')->where('status_captain', 'active')->where('type_captain', 'active')->selectRaw(" *,(6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude)))) AS distance")
    //                        ->having('distance', '<', $radius)
    //                        ->orderBy('distance')
    //                        ->get();
    //                    return $this->successResponse(CaptionActivityUserResources::collection($captains), 'Data returned successfully');
    //
    //                }elseif($categoryCars == 2){
    //                    $CarsCaption = CarsCaption::where('category_car_id', 2)->get();
    //                    $captains = CaptionActivity::whereIn('captain_id', $CarsCaption->id)->where('status_captain_work', 'active')->where('status_captain', 'active')->where('type_captain', 'active')->selectRaw(" *,(6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude)))) AS distance")
    //                        ->having('distance', '<', $radius)
    //                        ->orderBy('distance')
    //                        ->get();
    //                    return $this->successResponse(CaptionActivityUserResources::collection($captains), 'Data returned successfully');
    //                }else{
    //                    $CarsCaption = CarsCaption::where('category_car_id', 3)->get();
    //                    $captains = CaptionActivity::whereIn('captain_id', $CarsCaption->id)->where('status_captain_work', 'active')->where('status_captain', 'active')->where('type_captain', 'active')->selectRaw(" *,(6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude)))) AS distance")
    //                        ->having('distance', '<', $radius)
    //                        ->orderBy('distance')
    //                        ->get();
    //                    return $this->successResponse(CaptionActivityUserResources::collection($captains), 'Data returned successfully');
    //                }
    //            }
    //
    //
    //            if ($CarTypes) {
    //                if ($CarTypes == 1) {
    //                    $CarsCaption = CarType::where('category_car_id', 1)->get();
    //                    $captains = CaptionActivity::whereIn('captain_id', $CarsCaption->id)->where('status_captain_work', 'active')->where('status_captain', 'active')->where('type_captain', 'active')->selectRaw(" *,(6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude)))) AS distance")
    //                        ->having('distance', '<', $radius)
    //                        ->orderBy('distance')
    //                        ->get();
    //                    return $this->successResponse(CaptionActivityUserResources::collection($captains), 'Data returned successfully');
    //
    //                }elseif($CarTypes == 2){
    //                    $CarsCaption = CarType::where('category_car_id', 2)->get();
    //                    $captains = CaptionActivity::whereIn('captain_id', $CarsCaption->id)->where('status_captain_work', 'active')->where('status_captain', 'active')->where('type_captain', 'active')->selectRaw(" *,(6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude)))) AS distance")
    //                        ->having('distance', '<', $radius)
    //                        ->orderBy('distance')
    //                        ->get();
    //                    return $this->successResponse(CaptionActivityUserResources::collection($captains), 'Data returned successfully');
    //                }
    //            }
    //
    //
    //            if ($categoryCars && $CarTypes){
    //                if ($categoryCars == 1  &&  $CarTypes == 1) {
    //                    $CarsType = CarType::where('category_car_id', 1)->get();
    //                    $CarsCaption = CarsCaption::where('category_car_id', 1)->get();
    //                    $data = $CarsType->concat($CarsCaption);
    //                    $captains = CaptionActivity::whereIn('captain_id', $data->id)->where('status_captain_work', 'active')->where('status_captain', 'active')->where('type_captain', 'active')->selectRaw(" *,(6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude)))) AS distance")
    //                        ->having('distance', '<', $radius)
    //                        ->orderBy('distance')
    //                        ->get();
    //                    return $this->successResponse(CaptionActivityUserResources::collection($captains), 'Data returned successfully');
    //
    //                }elseif($categoryCars == 2 && $CarTypes == 2){
    //                    $CarsType = CarType::where('category_car_id', 2)->get();
    //                    $CarsCaption = CarsCaption::where('category_car_id', 2)->get();
    //                    $data = $CarsType->concat($CarsCaption);
    //                    $captains = CaptionActivity::whereIn('captain_id', $data->id)->where('status_captain_work', 'active')->where('status_captain', 'active')->where('type_captain', 'active')->selectRaw(" *,(6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude)))) AS distance")
    //                        ->having('distance', '<', $radius)
    //                        ->orderBy('distance')
    //                        ->get();
    //                    return $this->successResponse(CaptionActivityUserResources::collection($captains), 'Data returned successfully');
    //                }
    //            }
    //
    //
    //
    //
    //
    //
    //            $captains = CaptionActivity::where('status_captain_work', 'active')->where('status_captain', 'active')->where('type_captain', 'active')->selectRaw(" *, (6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude)))) AS distance ")
    //                ->having('distance', '<', $radius)
    //                ->orderBy('distance')
    //                ->get();
    //
    //            return $this->successResponse(CaptionActivityUserResources::collection($captains), 'Data returned successfully');
    //
    //        } catch (\Exception $exception) {
    //            return $this->errorResponse('Something went wrong, please try again later');
    //        }
    //
    //
    //    }


    //    public function captionActivity(Request $request)
    //    {
    //        $validator = Validator::make($request->all(), [
    //            'latitude' => 'required',
    //            'longitude' => 'required',
    //        ]);
    //
    //        if ($validator->fails()) {
    //            return $this->errorResponse($validator->errors()->first(), 422);
    //        }
    //
    //        // try {
    //        $latitude = $request->input('latitude');
    //        $longitude = $request->input('longitude');
    //        $radius = 50;
    //        $categoryCars = in_array($request->category_car_id, [1, 2]) ? [1, 2] : [3, 4];
    //        $carTypes = $request->car_type_id;
    //
    //        $captains = CaptionActivity::where('status_captain_work', 'active')
    //            ->where('status_captain', 'active')
    //            ->where('type_captain', 'active')
    //            ->selectRaw("*, (6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude)))) AS distance")
    //            ->whereRaw("(6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude)))) < $radius");
    //
    //        if (!empty($categoryCars)) {
    //            $captains->whereIn('captain_id', CarsCaption::whereIn('category_car_id', $categoryCars)->pluck('id'));
    //        }
    //
    //        if (!empty($carTypes)) {
    //            $captains->whereIn('captain_id', CarsCaption::whereIn('car_type_id', $carTypes)->pluck('id'));
    //        }
    //
    //        if (!empty($categoryCars) && !empty($carTypes)) {
    //            $captains->whereIn(
    //                'captain_id',
    //                CarsCaption::whereIn('category_car_id', $categoryCars)
    //                    ->pluck('id')
    //                    ->concat(CarsCaption::whereIn('category_car_id', $carTypes)->pluck('id'))
    //            );
    //        }
    //
    //        $captains = $captains->orderBy('distance')->get();
    //
    //        return $this->successResponse(CaptionActivityUserResources::collection($captains), 'Data returned successfully');
    //
    //        // } catch (\Exception $exception) {
    //        //     return $this->errorResponse('Something went wrong, please try again later');
    //        // }
    //
    //    }


    // Code
//    public function captionActivity(Request $request)
//    {
//        $validator = Validator::make($request->all(), [
//            'latitude' => 'required',
//            'longitude' => 'required',
//        ]);
//
//        if ($validator->fails()) {
//            return $this->errorResponse($validator->errors()->first(), 422);
//        }
//
//        try {
//            $latitude = $request->input('latitude');
//            $longitude = $request->input('longitude');
//            $radius = 50;
//            $categoryCars = $request->category_car_id == 1 ? [1, 2] : [3, 4];
//            $carTypes = $request->car_type_id;
//            $gender = $request->gender == 1 ? 'male' : ($request->gender == 2 ? 'female' : '');
//
//            $captains = CaptionActivity::where('status_captain_work', 'active')
//                ->where('status_captain', 'active')
//                ->where('type_captain', 'active')
//                ->selectRaw("*, (6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude)))) AS distance")
//                ->whereRaw("(6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude)))) < $radius");
//
//
//            if (!empty($categoryCars)) {
//
//                $categoryCaptions = CarsCaption::whereIn('category_car_id', $categoryCars)->pluck('captain_id')->toArray();
//                $captains->whereIn('captain_id', $categoryCaptions);
//            }
//
//            if (!empty($gender)) {
//                $GenderCaptions = Captain::whereIn('gender', [$gender])->pluck('id')->toArray();
//                $captains->whereIn('captain_id', $GenderCaptions);
//            }
//
//            if (!empty($carTypes)) {
//                $carTypeCaptains = CarsCaption::whereIn('car_type_id', [$carTypes])->pluck('captain_id')->toArray();
//                $captains->whereIn('captain_id', $carTypeCaptains);
//            }
//
//            if (!empty($categoryCars) && !empty($carTypes)) {
//                $categoryCaptions = CarsCaption::whereIn('category_car_id', $categoryCars)->pluck('captain_id')->toArray();
//                $carTypeCaptains = CarsCaption::whereIn('car_type_id', [$carTypes])->pluck('captain_id')->toArray();
//                $combinedCaptains = array_merge($categoryCaptions, $carTypeCaptains);
//                $captains->whereIn('captain_id', $combinedCaptains);
//            }
//
//            $captains = $captains->orderBy('distance')->get();
//
//            return $this->successResponse(CaptionActivityUserResources::collection($captains), 'Data returned successfully');
//        } catch (\Exception $exception) {
//            return $this->errorResponse('Something went wrong, please try again later');
//        }
//    }


    public function captionActivity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required',
            'longitude' => 'required',
            'status_caption_type' => 'required|in:car,scooter'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), 422);
        }

        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radius = 50;
        $gender = $request->gender == 1 ? 'male' : ($request->gender == 2 ? 'female' : '');

        try {
            switch ($request->status_caption_type) {
                case "car":
                    $categoryCars = $request->category_car_id == 1 ? [1, 2] : [3, 4];
                    $carTypes = $request->car_type_id;

                    $captains = CaptionActivity::where('status_captain_work', 'active')
                        ->where('status_captain', 'active')
                        ->where('type_captain', 'active')
                        ->where('status_caption_type', 'car')
                        ->selectRaw("*, (6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude)))) AS distance")
                        ->whereRaw("(6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude)))) < $radius");

                    if (!empty($categoryCars)) {
                        $categoryCaptions = CarsCaption::whereIn('category_car_id', $categoryCars)->pluck('captain_id')->toArray();
                        $captains->whereIn('captain_id', $categoryCaptions);
                    }

                    if (!empty($gender)) {
                        $GenderCaptions = Captain::whereIn('gender', [$gender])->pluck('id')->toArray();
                        $captains->whereIn('captain_id', $GenderCaptions);
                    }

                    if (!empty($carTypes)) {
                        $carTypeCaptains = CarsCaption::whereIn('car_type_id', [$carTypes])->pluck('captain_id')->toArray();
                        $captains->whereIn('captain_id', $carTypeCaptains);
                    }

                    if (!empty($categoryCars) && !empty($carTypes)) {
                        $categoryCaptions = CarsCaption::whereIn('category_car_id', $categoryCars)->pluck('captain_id')->toArray();
                        $carTypeCaptains = CarsCaption::whereIn('car_type_id', [$carTypes])->pluck('captain_id')->toArray();
                        $combinedCaptains = array_merge($categoryCaptions, $carTypeCaptains);
                        $captains->whereIn('captain_id', $combinedCaptains);
                    }

                    $captains = $captains->orderBy('distance')->get();
                    $captains = $captains->mapInto(CaptionActivityUserResources::class);

                    return $this->successResponse($captains, 'Data returned successfully');
                    break;

                case "scooter":
                    $captainsScooter = CaptionActivity::where('status_captain_work', 'active')
                        ->where('status_captain', 'active')
                        ->where('type_captain', 'active')
                        ->where('status_caption_type', 'scooter')
                        ->selectRaw("*, (6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude)))) AS distance")
                        ->whereRaw("(6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude)))) < $radius");

                    if (!empty($gender)) {
                        $GenderCaptions = Captain::whereIn('gender', [$gender])->pluck('id')->toArray();
                        $captainsScooter->whereIn('captain_id', $GenderCaptions);
                    }

                    $captainsScooter = $captainsScooter->orderBy('distance')->get();
                    $captainsScooter = $captainsScooter->mapInto(CaptionActivityUserResources::class);

                    return $this->successResponse($captainsScooter, 'Data returned successfully');
                    break;

                default:
                    return $this->errorResponse('Invalid type_caption provided');
                    break;
            }

        } catch (\Exception $exception) {
            return $this->errorResponse('Something went wrong, please try again later');
        }
    }



//    public function captionActivity(Request $request)
//    {
//        $validator = Validator::make($request->all(), [
//            'latitude' => 'required',
//            'longitude' => 'required',
//        ]);
//
//        if ($validator->fails()) {
//            return $this->errorResponse($validator->errors()->first(), 422);
//        }
//
//        try {
//            $latitude = $request->input('latitude');
//            $longitude = $request->input('longitude');
//            $radius = 50;
//            $categoryCars = $request->category_car_id == 1 ? [1, 2] : [3, 4];
//            $carTypes = $request->car_type_id;
//            $gender = $request->gender == 1 ? 'male' : 'female';
//
//            $captains = CaptionActivity::where('status_captain_work', 'active')
//                ->where('status_captain', 'active')
//                ->where('type_captain', 'active')
//                ->selectRaw("*, (6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude)))) AS distance")
//                ->whereRaw("(6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude)))) < $radius");
//
//            $this->applyFilter($captains, 'captain_id', CarsCaption::whereIn('category_car_id', $categoryCars)->pluck('captain_id'));
//            $this->applyFilter($captains, 'captain_id', Captain::whereIn('gender', [$gender])->pluck('id'));
//            $this->applyFilter($captains, 'captain_id', CarsCaption::whereIn('car_type_id', [$carTypes])->pluck('captain_id'));
//
//            if (!empty($categoryCars) && !empty($carTypes)) {
//                $combinedCaptains = array_merge(
//                    CarsCaption::whereIn('category_car_id', $categoryCars)->pluck('captain_id')->toArray(),
//                    CarsCaption::whereIn('car_type_id', [$carTypes])->pluck('captain_id')->toArray()
//                );
//                $this->applyFilter($captains, 'captain_id', $combinedCaptains);
//            }
//
//            $captains = $captains->orderBy('distance')->get();
//
//            return $this->successResponse(CaptionActivityUserResources::collection($captains), 'Data returned successfully');
//        } catch (\Exception $exception) {
//            return $this->errorResponse('Something went wrong, please try again later');
//        }
//    }
//
//    private function applyFilter($query, $column, $values)
//    {
//        if (!empty($values)) {
//            $query->whereIn($column, $values);
//        }
//    }

}
