<?php

namespace App\Http\Controllers\Dashboard\CallCenter;

use App\DataTables\Dashboard\CallCenter\CaptainSearchDataTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\Dashboard\CallCenter\CaptainDataTable;
use App\DataTables\Dashboard\CallCenter\MyCaptainDataTable;
use App\Services\Dashboard\{CallCenter\CaptainService, General\GeneralService};
use App\Models\{ScooterImage, CaptainTricycle,ScooterMake, ScooterModel,CaptainScooter, Color, CaptainProfile, CarsCaptionStatus, Captain, Image, Order, OrderDay, OrderHour, CarMake, CarModel, CarType, CategoryCar, CarsCaption};
use Illuminate\Support\Facades\DB;

class CaptainController extends Controller
{
    public function __construct(protected MyCaptainDataTable $myCaptainDataTable, protected CaptainDataTable $dataTable, protected CaptainService $captainService, protected GeneralService $generalService) {
        $this->dataTable = $dataTable;
        $this->myCaptainDataTable = $myCaptainDataTable;
        $this->captainService = $captainService;
        $this->generalService = $generalService;
    }

    public function index($id = null) {
        $data = [
            'title' => 'Captions',
            'countries' => $this->generalService->getCountries(),
            'captains' => Captain::active(),
            'carMakes' => CarMake::with(['carModel' => function ($query) {
                $query->where('status', true);
            }])->whereStatus(true)->select('id', 'name')->get()->toArray(),
            'carTypes' => CarType::active(),
            'carCategories' => CategoryCar::active(),
        ];
        return $this->dataTable->render('dashboard.call-center.captains.index', compact('data'));
    }

    public function getCarModelsByMakeId($carMakeId) {
        $carModels = CarModel::where('car_make_id', $carMakeId)->whereStatus(true)->pluck('id', 'name');
        return response()->json($carModels);
    }

    public function getScooterModelsByMakeId($scooterMakeId) {
        $scooterModels = ScooterModel::where('scooter_make_id', $scooterMakeId)->whereStatus(true)->pluck('id', 'name');
        return response()->json($scooterModels);
    }

    public function store(Request $request) {
        try {
            $requestData = $request->all();
            $captain = $this->captainService->create($requestData);
            $captain->profile()->firstOrCreate(['captain_id' => $captain->id]);
            $captain->invite()->firstOrCreate([
                'captain_id' => $captain->id,
                'type' => 'caption',
            ], [
                'code_invite' => str_replace(' ', '_', $captain->name) . generateRandom(3),
                'data' => date('Y-m-d'),
            ]);

            return redirect()->route('CallCenterCaptains.index')->with('success', 'captain created successfully');
        } catch (\Exception $e) {
            return redirect()->route('CallCenterCaptains.index')->with('error', 'An error occurred while creating the captain');
        }
    }


    public function show($captainId)
    {

        try {
            $data = [
                'captain' => $this->captainService->getProfile($captainId),
                'title' => 'Captain Details',
            ];

            $findCaptions = CaptainProfile::where('uuid', $captainId)->first();
            $check = Captain::where('id', optional($findCaptions)->captain_id)->first();

            if ($check) {
                $checkStatus = optional(get_user_data())->type == "manager";

                if ($checkStatus) {
                    return view('dashboard.call-center.captains.show', compact('data'));

                }

                $userCallCenterId = optional(get_user_data())->id;
                $captainCallCenterId = $check->callcenter_id;

                if ($captainCallCenterId && $captainCallCenterId == $userCallCenterId) {
                    return view('dashboard.call-center.captains.show', compact('data'));

                } elseif (empty($captainCallCenterId)) {

                    $check->update([
                        'callcenter_id' => auth('call-center')->id(),
                    ]);

                    return view('dashboard.call-center.captains.show', compact('data'));

                } else {
                    return redirect()->route('CallCenterCaptains.index')->with('error', 'There is a problem. Please try again later');
                }


            }
        } catch (\Exception $e) {
            return redirect()->route('CallCenterCaptains.index')->with('error', 'An error occurred while getting the captain details');
        }
    }

    public function uploadPersonalMedia(Request $request)
    {
        if ($request->hasFile('personal_avatar'))
            $this->storeImage($request, 'personal_avatar', $request->get('imageable_id'), $request->get('type'));
        if ($request->hasFile('id_photo_front'))
            $this->storeImage($request, 'id_photo_front', $request->get('imageable_id'), $request->get('type'));
        if ($request->hasFile('id_photo_back'))
            $this->storeImage($request, 'id_photo_back', $request->get('imageable_id'), $request->get('type'));
        if ($request->hasFile('criminal_record'))
            $this->storeImage($request, 'criminal_record', $request->get('imageable_id'), $request->get('type'));
        if ($request->hasFile('captain_license_front'))
            $this->storeImage($request, 'captain_license_front', $request->get('imageable_id'), $request->get('type'));
        if ($request->hasFile('captain_license_back'))
            $this->storeImage($request, 'captain_license_back', $request->get('imageable_id'), $request->get('type'));
        return redirect()->back()->with('success', 'Upload Personal Media Succesfully');
    }

    public function uploadCarMedia(Request $request)
    {
        if ($request->hasFile('car_license_front'))
            $this->storeImage($request, 'car_license_front', $request->get('imageable_id'), $request->get('type'));
        if ($request->hasFile('car_license_back'))
            $this->storeImage($request, 'car_license_back', $request->get('imageable_id'), $request->get('type'));
        if ($request->hasFile('car_front'))
            $this->storeImage($request, 'car_front', $request->get('imageable_id'), $request->get('type'));
        if ($request->hasFile('car_back'))
            $this->storeImage($request, 'car_back', $request->get('imageable_id'), $request->get('type'));
        if ($request->hasFile('car_right'))
            $this->storeImage($request, 'car_right', $request->get('imageable_id'), $request->get('type'));
        if ($request->hasFile('car_left'))
            $this->storeImage($request, 'car_left', $request->get('imageable_id'), $request->get('type'));
        if ($request->hasFile('car_inside'))
            $this->storeImage($request, 'car_inside', $request->get('imageable_id'), $request->get('type'));
        return redirect()->back()->with('success', 'Upload Car Media Succesfully');
    }

    private function storeImage(Request $request, $field, $imageable, $type)
    {

        $checkImage = Image::where('imageable_type', 'App\Models\Captain')->where('imageable_id', json_decode($imageable)->id)->where('photo_type', $field)->first();
        if (!$checkImage) {
            $image = new Image();
            $image->photo_type = $field;
            $image->imageable_type = 'App\Models\Captain';
            $imageable = json_decode($imageable);
            if ($request->file($field)->isValid()) {
                $captainProfile = CaptainProfile::whereCaptainId($imageable->id)->select('uuid')->first();
                if ($captainProfile) {
                    $nameWithoutSpaces = str_replace(' ', '_', $imageable->name);
                    $request->file($field)->storeAs(
                        $nameWithoutSpaces . '_' . $captainProfile->uuid . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR,
                        $field . '.' . $request->file($field)->getClientOriginalExtension(),
                        'upload_image'
                    );
                    $image->photo_status = 'accept';
                    $image->type = $type;
                    $image->filename = $field . '.' . $request->file($field)->getClientOriginalExtension();
                    $image->imageable_id = $imageable->id;
                    $image->created_by_callcenter_id = get_user_data()->id;
                    $image->created_at_callcenter = now();
                    $image->save();
                }
            }
        } else {

            $checkImage->photo_type = $field;
            $checkImage->imageable_type = 'App\Models\Captain';
            $checkImageAble = json_decode($imageable);
            if ($request->file($field)->isValid()) {
                $captainProfile = CaptainProfile::whereCaptainId($checkImageAble->id)->select('uuid')->first();
                if ($captainProfile) {
                    $nameWithoutSpaces = str_replace(' ', '_', $checkImageAble->name);
                    $request->file($field)->storeAs(
                        $nameWithoutSpaces . '_' . $captainProfile->uuid . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR,
                        $field . '.' . $request->file($field)->getClientOriginalExtension(),
                        'upload_image'
                    );
                    $checkImage->photo_status = 'accept';
                    $checkImage->type = $type;
                    $checkImage->filename = $field . '.' . $request->file($field)->getClientOriginalExtension();
                    $checkImage->imageable_id = json_decode($imageable)->id;
                    $checkImage->created_by_callcenter_id = get_user_data()->id;
                    $checkImage->created_at_callcenter = now();
                    $checkImage->save();
                }
            }
        }


    }

    public function updatePersonalMediaStatus(Request $request, $id)
    {

        try {
            $columns = [
                'personal_avatar' => [
                    'ar' => 'الصوره الشخصية',
                    'en' => 'personal avatar',
                ],
                'id_photo_front' => [
                    'ar' => 'صوره الهوية امام',
                    'en' => 'Nationality ID front',
                ],
                'id_photo_back' => [
                    'ar' => 'صوره الهوية خلف',
                    'en' => 'Nationality ID back',
                ],
                'criminal_record' => [
                    'ar' => 'السجل الجنائى',
                    'en' => 'Criminal Record',
                ],
                'captain_license_front' => [
                    'ar' => 'رخصة السائق امام',
                    'en' => 'captain license front',
                ],
                'captain_license_back' => [
                    'ar' => 'رخصة السائق خلف',
                    'en' => 'captain license back',
                ],
            ];


            $messages = [
                'Reject' => [
                    'ar' => 'مرفوضه',
                    'en' => 'Reject',
                ],
                'Accept' => [
                    'ar' => 'مقبول',
                    'en' => 'Accept',
                ],
            ];
            $image = Image::find($id);
            $captain = Captain::findOrfail($request->imageable_id);
            $accept = array_key_exists('Accept', $messages) ? $messages['Accept']['ar'] : null;
            $reject = array_key_exists('Reject', $messages) ? $messages['Reject']['ar'] : null;

            $specificName = array_key_exists($image->photo_type, $columns) ? $columns[$image->photo_type]['ar'] : null;
            if (!$image)
                return redirect()->back()->with('error', 'Image not found');
            $updateData = [];
            if ($request->has('photo_status')) {
                $updateData['photo_status'] = $request->input('photo_status');
                $updateData['updated_by_callcenter_id'] = get_user_data()->id;
                $updateData['updated_at_callcenter'] = now();
            }

            if ($request->has('reject_reson'))
                $updateData['reject_reson'] = $request->input('reject_reson');


            $image->update($updateData);
            $body = ($request->input('photo_status') === 'accept') ? 'Good Your ' . $specificName . ' Successfully' : 'Sorry this image ' . $specificName;
            $title = ($request->input('photo_status') === 'accept') ? $accept . ' ' . $specificName : ' ' . $reject . ' ' . $specificName;


            if ($request->photo_status == "accept") {
                sendNotificationCaptain($request->imageable_id, 'تم الموافقه على الورق', '');
            } else {
                sendNotificationCaptain($request->imageable_id, 'هناك خظأ ما', $request->input('reject_reson'));
            }


            return redirect()->back()->with('success', 'Image ' . ucfirst(str_replace('_', ' ', $image->photo_type)) . ' updated status successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred during the update: ' . $e->getMessage());
        }
    }

    public function updateCarStatus(Request $request, $id)
    {
        try {
            $captainId = $request->input('captain_id');
            $fieldName = $request->input('field_name');
            $newStatus = $request->input('status');
            $status = CarsCaptionStatus::findOrFail($id);
            if ($newStatus === 'reject') {
                $captain_profile_uuid = $request->input('captain_profile_uuid');
                $captain_name = $request->input('captain_name');
                $rejectReason = $request->input('reject_message');
                $status->status = $newStatus;
                $status->reject_message = $rejectReason;
                $status->save();
                sendNotificationCaptain($status->captain_profile->owner->fcm_token, 'reject', $status->reject_message);
                return redirect()->back()->with('success', 'Captain car media updated status successfully');
            } else {
                $status->status = $newStatus;
                $status->save();
                sendNotificationCaptain($status->captain_profile->owner->fcm_token, $newStatus, $status->status);
                return redirect()->back()->with('success', 'Captain car media updated status successfully');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating Captain car media status');
        }
    }

    public function updateActivityStatus(Request $request, $id)
    {
        try {
            $captain = Captain::findOrFail($id);
            $captain->captainActivity->status_captain_work = $request->input('status_captain_work');
            $captain->captainActivity->save();
            return back()->with('success', 'captain activity status updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating Captain activity status');
        }
    }

    public function blockCaptain(Request $request, Captain $captain)
    {
        try {
            $captain->captainActivity->status_captain_work = 'block';
            $captain->captainActivity->save();
            DB::table('captain_callcenter_blocks')->insert([
                'call_center_id' => get_user_data()->id,
                'captain_id' => $captain->id,
                'block_reason' => $request->input('block_reason'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return back()->with('success', 'Captain activity status updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating Captain activity status');
        }
    }


    public function sendNotificationAll(Request $request) {
        try {
            sendNotificatioAll($request->type, $request->body, $request->title);
            return redirect()->back();

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'An error occurred');

        }
    }


    public function captains_searchNumber(Request $request) {
        try {
            $dataIn = CaptainProfile::where('number_personal', 'like', '%' . $request->number . '%')->orderBy('created_at', 'desc')->paginate(50);
            if ($dataIn) {
                return view('dashboard.call-center.captains.search', compact('dataIn'));
            }

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'An error occurred');

        }
    }


    public function trips($captainId) {
        $id = CaptainProfile::where('uuid', $captainId)->first()->captain_id;
        $orders = Order::where('captain_id', $id)->orderBy('created_at', 'desc')->paginate(50);
        $orderHours = OrderHour::where('captain_id', $id)->orderBy('created_at', 'desc')->paginate(50);
        $orderDay = OrderDay::where('captain_id', $id)->orderBy('created_at', 'desc')->paginate(50);
        $data = $orders->concat($orderHours)->concat($orderDay);
        $types = ['Orders', 'Order Hours', 'Order Days'];
        return view('dashboard.call-center.captains.trip.trip', compact('data', 'types'));
    }

    public function showOrder($orderCode) {
        $order = Order::where('order_code', $orderCode)->first();
        $orderTracking = Order::where('id', $order->id)->get(['user_id', 'captain_id', 'trip_type_id', 'id', 'lat_user', 'long_user', 'lat_going', 'long_going']);
        $locations = [];
        foreach ($orderTracking as $orderTrack) {
            $locations[] = [
                'id' => $orderTrack->id,
                'lat_user' => $orderTrack->lat_user,
                'long_user' => $orderTrack->long_user,
                'lat_going' => $orderTrack->lat_going,
                'long_going' => $orderTrack->long_going,
                'user_id' => $orderTrack->user->name,
                'captain_id' => $orderTrack->captain->name,
                'trip_type_id' => $orderTrack->trip_type->name,
            ];
        }
        return view('dashboard.call-center.orders.showOrder', ['order' => $order, 'data' => json_encode($locations)]);
    }

    public function showOrderDay($orderCode) {
        $order = OrderDay::where('order_code', $orderCode)->first();
        $orderTracking = OrderDay::where('id', $order->id)->get(['user_id', 'captain_id', 'trip_type_id', 'id', 'lat_user', 'long_user', 'status_price', 'car_type_day_id', 'type_duration', 'start_day', 'end_day', 'number_day', 'start_time']);
        $locations = [];
        foreach ($orderTracking as $orderTrack) {
            $locations[] = [
                'id' => $orderTrack->id,
                'lat' => $orderTrack->lat_user,
                'lng' => $orderTrack->long_user,
                'user_id' => $orderTrack->user->name,
                'captain_id' => $orderTrack->captain->name,
                'trip_type_id' => $orderTrack->trip_type->name,
            ];
        }
        return view('dashboard.call-center.orders.showOrderDay', ['order' => $order, 'data' => json_encode($locations)]);
    }

    public function showOrderHour($orderCode) {
        $order = OrderHour::where('order_code', $orderCode)->first();
        $orderTracking = OrderHour::where('id', $order->id)->get(['user_id', 'captain_id', 'trip_type_id', 'id', 'lat_user', 'long_user', 'status_price', 'car_type_id', 'type_duration', 'time_duration']);
        $locations = [];
        foreach ($orderTracking as $orderTrack) {
            $locations[] = [
                'id' => $orderTrack->id,
                'lat' => $orderTrack->lat_user,
                'lng' => $orderTrack->long_user,
                'user_id' => $orderTrack->user->name,
                'captain_id' => $orderTrack->captain->name,
                'trip_type_id' => $orderTrack->trip_type->name,
            ];
        }
        return view('dashboard.call-center.orders.showOrderHour', ['order' => $order, 'data' => json_encode($locations)]);
    }


    public function updateProfile(Request $request, $id) {
        try {
            $address = $request->input('address');
            $bio = $request->input('bio');
            $number_personal = $request->input('number_personal');
            DB::table('captain_profiles')
                ->where('captain_id', $id)
                ->update([
                    'address' => $address,
                    'bio' => $bio,
                    'number_personal' => $number_personal,
                ]);
            return redirect()->back()->with('success', 'Profile updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating Captain profile');
        }
    }

    public function createNewCar(Request $request) {
        try {
            $captainCar = CarsCaption::where('captain_id', $request->captain_id)->first();
            if (!$captainCar) {
                $captainCar = CarsCaption::create([
                    'captain_id' => $request->captain_id,
                    'car_make_id' => $request->car_make_id,
                    'car_model_id' => $request->car_model_id,
                    'car_type_id' => $request->car_type_id,
                    'category_car_id' => $request->category_car_id,
                    'number_car' => $request->number_car,
                    'color_car' => $request->color_car,
                    'year_car' => $request->year_car,
                ]);
                return redirect()->route('CallCenterCaptains.index')->with('success', 'Captain car created successfully');
            }
            $captainCar->update([
                'car_make_id' => $request->car_makeId,
                'car_model_id' => $request->car_modelId,
                'car_type_id' => $request->car_type_id,
                'category_car_id' => $request->category_car_id,
                'number_car' => $request->number_car,
                'color_car' => $request->color_car,
                'year_car' => $request->year_car,
            ]);
            return redirect()->route('CallCenterCaptains.index')->with('success', 'Captain car updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('CallCenterCaptains.index')->with('error', 'An error occurred while creating/updating the captain car');
        }
    }

    public function newCar($captainId) {
        $captain = Captain::find($captainId);
        $data = [
            'carMakes' => CarMake::with(['carModel' => function ($query) {
                $query->where('status', true);
            }])->whereStatus(true)->select('id', 'name')->get()->toArray(),
            'carTypes' => CarType::active(),
            'carCategories' => CategoryCar::active(),
            'colors' => Color::pluck('name', 'id'),
            'title' => 'New Car',
        ];
        //dd($data);
        return view('dashboard.call-center.captains.new_car', compact('captain', 'data'));
    }
    
    public function createNewScooter(Request $request) {
        try {
            $captain = Captain::find($request->captain_id);
            if (!$captain) 
                return redirect()->route('CallCenterCaptains.index')->with('error', 'Captain not found');
    
            CaptainScooter::updateOrCreate(
                ['captain_id' => $request->captain_id],
                [
                    'scooter_make_id' => $request->scooter_make_id,
                    'scooter_model_id' => $request->scooter_model_id,
                    'scooter_number' => $request->scooter_number,
                    'scooter_color' => $request->scooter_color,
                    'scooter_year' => $request->scooter_year,
                ]
            );
            return redirect()->route('CallCenterCaptains.show', $captain->profile->uuid)->with('success', 'Captain scooter created successfully');
        } catch (\Exception $e) {
            return redirect()->route('CallCenterCaptains.index')->with('error', 'An error occurred while creating the captain scooter');
        }
    }


    public function myCar($id) {
        $data = [
            'captain' => Captain::findOrFail($id),
            'carCaption' => DB::table('cars_captions')->where('captain_id', $id)->first(),
            'carMakes' => CarMake::active(),
            'carModels' => CarModel::active(),
            'carTypes' => CarType::active(),
            'carCategories' => CategoryCar::active(),
            'emptyFields' => collect(DB::table('cars_captions')->where('captain_id', $id)->first())
            ->filter(function ($value, $key) {
                return empty($value);
            })->keys()->all(),
        ];

        $title = $data['captain']->name . ' Car';
        return view('dashboard.call-center.captains.myCar', compact('data', 'title'));
    }

    public function updateMyCar(Request $request, $id) {
        $carCaption = DB::table('cars_captions')->where('captain_id', $id)->first();
        if (!$carCaption) 
            return redirect()->back()->with('error', 'There is a problem. Please try again later');
        DB::table('cars_captions')->where('captain_id', $id)->update([
            'car_make_id' => $request->input('car_make_id'),
            'car_model_id' => $request->input('car_model_id'),
            'car_type_id' => $request->input('car_type_id'),
            'category_car_id' => $request->input('category_car_id'),
            'number_car' => $request->input('number_car'),
            'year_car' => $request->input('year_car'),
            'color_car' => $request->input('color_car'),
        ]);
        return redirect()->route('CallCenterCaptains.myCar', $id)->with('success', 'Car Updated Succesfully');
    }

    public function updateScooterMediaStatus(Request $request, $id) {
        $requestData = $request->all();
        $queryConditions = ['id' => $requestData['image_id'],'imageable_id' => $requestData['imageable_id'],];
        $imageRaw = DB::table('scooter_images')->where($queryConditions)->first();
        $relatedScooter = CaptainScooter::find($request->imageable_id);
        $captainId = $relatedScooter->captain->id;
        $columns = [
            'personal_avatar' => [
                'ar' => 'الصوره الشخصية',
                'en' => 'personal avatar',
            ],
            'id_photo_front' => [
                'ar' => 'صوره الهوية امام',
                'en' => 'Nationality ID front',
            ],
            'id_photo_back' => [
                'ar' => 'صوره الهوية خلف',
                'en' => 'Nationality ID back',
            ],
            'criminal_record' => [
                'ar' => 'السجل الجنائى',
                'en' => 'Criminal Record',
            ],
            'captain_license_front' => [
                'ar' => 'رخصة السائق امام',
                'en' => 'captain license front',
            ],
            'captain_license_back' => [
                'ar' => 'رخصة السائق خلف',
                'en' => 'captain license back',
            ],
            'scooter_license_front' => [
                'ar' => 'رخصة الدراجة امام',
                'en' => 'scooter license front'
            ],
            'scooter_license_back' => [
                'ar' => 'رخصة الدراجة خلف',
                'en' => 'scooter license back'
            ]
        ];
        $messages = [
            'Reject' => [
                'ar' => 'مرفوضه',
                'en' => 'Reject',
            ],
            'Accept' => [
                'ar' => 'مقبول',
                'en' => 'Accept',
            ],
        ];
        $accept = array_key_exists('Accept', $messages) ? $messages['Accept']['ar'] : null;
        $reject = array_key_exists('Reject', $messages) ? $messages['Reject']['ar'] : null;
        $specificName = array_key_exists($imageRaw->photo_type, $columns) ? $columns[$imageRaw->photo_type]['ar'] : null;
        if ($imageRaw) {
            $updateData = [];
            if ($request->has('photo_status')) {
                $updateData += [
                    'photo_status' => $requestData['photo_status'],
                    'updated_by_callcenter_id' => get_user_data()->id,
                    'updated_at_callcenter' => now(),
                ];
            }
            if ($request->has('reject_reson')) 
                $updateData['reject_reson'] = $request->input('reject_reson');
            if (!empty($updateData)) 
                DB::table('scooter_images')->where($queryConditions)->update($updateData);
            $body = ($request->input('photo_status') === 'accept') ? 'Good Your ' . $specificName . ' Successfully' : 'Sorry this image ' . $specificName;
            $title = ($request->input('photo_status') === 'accept') ? $accept . ' ' . $specificName : ' ' . $reject . ' ' . $specificName;
            if ($request->photo_status == "accept") {
                sendNotificationCaptain($captainId, 'تم الموافقه على الورق', '');
            } else {
                sendNotificationCaptain($captainId, 'هناك خظأ ما', $request->input('reject_reson'));
            }
            return redirect()->back()->with('success', 'Image ' . ucfirst(str_replace('_', ' ', $imageRaw->photo_type)) . ' updated status successfully');
        }
    }

    public function uploadScooterRejectedImage(Request $request) {
        try {
            $existingImage = DB::table('scooter_images')->whereId($request->image_id)->first();
            $relatedScooter = CaptainScooter::find($request->imageable_id);
            if (!$relatedScooter || !$existingImage) {
                throw new \Exception('Invalid scooter or image.');
            }
            $photoType = str_replace('_', ' ', $existingImage->photo_type);
            $captainName = str_replace(' ', '_', $relatedScooter->captain->name);
            $captainProfileUUid = $relatedScooter->captain->profile->uuid;
            $captainNameWithUUid = $captainName . '_' . $captainProfileUUid;
            $path = $captainNameWithUUid . '/' . $relatedScooter->captain->status_caption_type . '/' . $relatedScooter->scooter_number;
            $oldImagePath = public_path($path . '/' . $existingImage->type . '/' . $existingImage->filename);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            $newImage = $request->file('filename');
            $newImagePath = $newImage->storeAs($path . '/' . $existingImage->type, $newImage->getClientOriginalName(), 'upload_image');
            DB::table('scooter_images')->whereId($request->image_id)->update([
                'filename' => $newImage->getClientOriginalName(),
                'type' => $existingImage->type,
                'photo_type' => $existingImage->photo_type,
                'photo_status' => 'not_active',
                'imageable_type' => $existingImage->imageable_type,
                'reject_reson' => null,
                'imageable_id'  => $existingImage->imageable_id,
                'updated_by_callcenter_id' => get_user_data()->id,
                'updated_at_callcenter' => now(),
            ]);
            return redirect()->back()->with('success', "Update {$photoType} Successfully");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function newScooter($captainId) {
        $captain = Captain::find($captainId);
        $data = [
            'scooterMakes' => ScooterMake::with(['scooterModel' => function ($query) {
                $query->where('status', true);
            }])->whereStatus(true)->select('id', 'name')->get()->toArray(),
            'title' => 'New Scooter',
        ];
        return view('dashboard.call-center.captains.new_scooter', compact('captain', 'data'));
    }

    public function myScooter($id) {
        $data = [
            'captain' => Captain::findOrFail($id),
            'scooterCaption' => DB::table('captain_scooters')->where('captain_id', $id)->latest()->first(),
            'scooterMakes' => ScooterMake::active(),
            'scooterModels' => ScooterModel::active(),
            'emptyFields' => collect(DB::table('captain_scooters')->where('captain_id', $id)->latest()->first())
            ->filter(function ($value, $key) {
                return empty($value);
            })->keys()->all(),
        ];

        $title = $data['captain']->name . ' Scooter';
        return view('dashboard.call-center.captains.myScooter', compact('data', 'title'));
    }

    public function updateMyScooter(Request $request, $id) {
        $scooterCaption = DB::table('captain_scooters')->where('captain_id', $id)->latest()->first();
        if (!$scooterCaption) 
            return redirect()->back()->with('error', 'There is a problem. Please try again later');
        DB::table('captain_scooters')->where('captain_id', $id)->update([
            'scooter_make_id' => $request->input('scooter_make_id'),
            'scooter_model_id' => $request->input('scooter_model_id'),
            'scooter_number' => $request->input('scooter_number'),
            'scooter_color' => $request->input('scooter_color'),
            'scooter_year' => $request->input('scooter_year'),
        ]);
        return redirect()->route('CallCenterCaptains.myScooter', $id)->with('success', 'Scooter Updated Succesfully');
    }
    
    public function uploadScooterPersonalMedia(Request $request) {
        if ($request->hasFile('personal_avatar'))
            $this->storeScooterImage($request, 'personal_avatar', $request->get('imageable_id'), $request->get('type'));
        if ($request->hasFile('id_photo_front'))
            $this->storeScooterImage($request, 'id_photo_front', $request->get('imageable_id'), $request->get('type'));
        if ($request->hasFile('id_photo_back'))
            $this->storeScooterImage($request, 'id_photo_back', $request->get('imageable_id'), $request->get('type'));
        if ($request->hasFile('criminal_record'))
            $this->storeScooterImage($request, 'criminal_record', $request->get('imageable_id'), $request->get('type'));
        if ($request->hasFile('captain_license_front'))
            $this->storeScooterImage($request, 'captain_license_front', $request->get('imageable_id'), $request->get('type'));
        if ($request->hasFile('captain_license_back'))
            $this->storeScooterImage($request, 'captain_license_back', $request->get('imageable_id'), $request->get('type'));
        if ($request->hasFile('scooter_license_front'))
            $this->storeScooterImage($request, 'scooter_license_front', $request->get('imageable_id'), $request->get('type'));
        if ($request->hasFile('scooter_license_back'))
            $this->storeScooterImage($request, 'scooter_license_back', $request->get('imageable_id'), $request->get('type'));
        return redirect()->back()->with('success', 'Upload Scooter Personal Media Succesfully');
    }
    
    public function uploadScooterMedia(Request $request) {
        if ($request->hasFile('scooter_front'))
            $this->storeScooterImage($request, 'scooter_front', $request->get('imageable_id'), $request->get('type'));
        if ($request->hasFile('scooter_back'))
            $this->storeScooterImage($request, 'scooter_back', $request->get('imageable_id'), $request->get('type'));
        return redirect()->back()->with('success', 'Upload Scooter Media Succesfully');
    }
    
    private function storeScooterImage(Request $request, $field, $imageable, $type) {
        $checkImage = ScooterImage::where('imageable_type', 'App\Models\CaptainScooter')->where('imageable_id', $imageable)->where('photo_type', $field)->first();
        $scooter = CaptainScooter::whereId($imageable)->first();
        if (!$checkImage) {
            $image = new ScooterImage();
            $image->photo_type = $field;
            $image->imageable_type = 'App\Models\CaptainScooter';
            $imageable = json_decode($imageable);
            if ($request->file($field)->isValid()) {
                $scooterNumber = $scooter->scooter_number;
                $captainId = $scooter->captain_id;
                $captainName = $scooter->captain->name;
                $captainProfile = $scooter->captain->profile->uuid;
                //dd($scooterNumber);
                
                if ($captainProfile) {
                    $nameWithoutSpaces = str_replace(' ', '_', $captainName);
                    $request->file($field)->storeAs(
                        $nameWithoutSpaces . '_' . $captainProfile . DIRECTORY_SEPARATOR . 'scooter' .  DIRECTORY_SEPARATOR . $scooterNumber . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR,
                        $field . '.' . $request->file($field)->getClientOriginalExtension(),
                        'upload_image'
                    );
                    $image->photo_status = 'accept';
                    $image->type = $type;
                    $image->filename = $field . '.' . $request->file($field)->getClientOriginalExtension();
                    $image->imageable_id = $imageable;
                    $image->created_by_callcenter_id = get_user_data()->id;
                    $image->created_at_callcenter = now();
                    $image->save();
                }
            }
        } /*else {

            $checkImage->photo_type = $field;
            $checkImage->imageable_type = 'App\Models\Captain';
            $checkImageAble = json_decode($imageable);
            if ($request->file($field)->isValid()) {
                $captainProfile = CaptainProfile::whereCaptainId($checkImageAble->id)->select('uuid')->first();
                if ($captainProfile) {
                    $nameWithoutSpaces = str_replace(' ', '_', $checkImageAble->name);
                    $request->file($field)->storeAs(
                        $nameWithoutSpaces . '_' . $captainProfile->uuid . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR,
                        $field . '.' . $request->file($field)->getClientOriginalExtension(),
                        'upload_image'
                    );
                    $checkImage->photo_status = 'accept';
                    $checkImage->type = $type;
                    $checkImage->filename = $field . '.' . $request->file($field)->getClientOriginalExtension();
                    $checkImage->imageable_id = json_decode($imageable)->id;
                    $checkImage->created_by_callcenter_id = get_user_data()->id;
                    $checkImage->created_at_callcenter = now();
                    $checkImage->save();
                }
            }
        }*/
    }
    
    /*********************** Triucycle *********************** */

    public function updateTricycleMediaStatus(Request $request, $id) {
        $requestData = $request->all();
        $queryConditions = ['id' => $requestData['image_id'],'imageable_id' => $requestData['imageable_id'],];
        $imageRaw = DB::table('tricycle_images')->where($queryConditions)->first();
        $relatedTricycle = CaptainTricycle::find($request->imageable_id);
        $captainId = $relatedTricycle->captain->id;
        $columns = [
            'personal_avatar' => [
                'ar' => 'الصوره الشخصية',
                'en' => 'personal avatar',
            ],
            'id_photo_front' => [
                'ar' => 'صوره الهوية امام',
                'en' => 'Nationality ID front',
            ],
            'id_photo_back' => [
                'ar' => 'صوره الهوية خلف',
                'en' => 'Nationality ID back',
            ],
            'criminal_record' => [
                'ar' => 'السجل الجنائى',
                'en' => 'Criminal Record',
            ],
            'captain_license_front' => [
                'ar' => 'رخصة السائق امام',
                'en' => 'captain license front',
            ],
            'captain_license_back' => [
                'ar' => 'رخصة السائق خلف',
                'en' => 'captain license back',
            ],
            'tricycle_license_front' => [
                'ar' => 'رخصة المركبه امام',
                'en' => 'tricycle license front'
            ],
            'tricycle_license_back' => [
                'ar' => 'رخصة المركبه خلف',
                'en' => 'tricycle license back'
            ],
            'tricycle_back' => [
                'ar' => ' المركبه خلف',
                'en' => 'tricycle back'
            ],
            'tricycle_front' => [
                'ar' => ' المركبه امام',
                'en' => 'tricycle  front'
            ],
            'tricycle_right' => [
                'ar' => ' المركبه يمين',
                'en' => 'tricycle  right'
            ],
            'tricycle_left' => [
                'ar' => ' المركبه يسار',
                'en' => 'tricycle  left'
            ],
        ];
        $messages = [
            'Reject' => [
                'ar' => 'مرفوضه',
                'en' => 'Reject',
            ],
            'Accept' => [
                'ar' => 'مقبول',
                'en' => 'Accept',
            ],
        ];
        $accept = array_key_exists('Accept', $messages) ? $messages['Accept']['ar'] : null;
        $reject = array_key_exists('Reject', $messages) ? $messages['Reject']['ar'] : null;
        $specificName = array_key_exists($imageRaw->photo_type, $columns) ? $columns[$imageRaw->photo_type]['ar'] : null;
        if ($imageRaw) {
            $updateData = [];
            if ($request->has('photo_status')) {
                $updateData += [
                    'photo_status' => $requestData['photo_status'],
                    'updated_by_callcenter_id' => get_user_data()->id,
                    'updated_at_callcenter' => now(),
                ];
            }
            if ($request->has('reject_reson')) 
                $updateData['reject_reson'] = $request->input('reject_reson');
            if (!empty($updateData)) 
                DB::table('tricycle_images')->where($queryConditions)->update($updateData);
            $body = ($request->input('photo_status') === 'accept') ? 'Good Your ' . $specificName . ' Successfully' : 'Sorry this image ' . $specificName;
            $title = ($request->input('photo_status') === 'accept') ? $accept . ' ' . $specificName : ' ' . $reject . ' ' . $specificName;
            if ($request->photo_status == "accept") {
                sendNotificationCaptain($captainId, 'تم الموافقه على الورق', '');
            } else {
                sendNotificationCaptain($captainId, 'هناك خظأ ما', $request->input('reject_reson'));
            }
            return redirect()->back()->with('success', 'Image ' . ucfirst(str_replace('_', ' ', $imageRaw->photo_type)) . ' updated status successfully');
        }
    }
    
    public function uploadTricycleRejectedImage(Request $request) {
        try {
            $existingImage = DB::table('tricycle_images')->whereId($request->image_id)->first();
            $relatedTricycle = CaptainTricycle::find($request->imageable_id);
            if (!$relatedTricycle || !$existingImage) {
                throw new \Exception('Invalid tricycle or image.');
            }
            $photoType = str_replace('_', ' ', $existingImage->photo_type);
            $captainName = str_replace(' ', '_', $relatedTricycle->captain->name);
            $captainProfileUUid = $relatedTricycle->captain->profile->uuid;
            $captainNameWithUUid = $captainName . '_' . $captainProfileUUid;
            $path = $captainNameWithUUid . '/' . $relatedTricycle->captain->status_caption_type . '/' . $relatedTricycle->tricycle_number;
            $oldImagePath = public_path($path . '/' . $existingImage->type . '/' . $existingImage->filename);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            $newImage = $request->file('filename');
            $newImagePath = $newImage->storeAs($path . '/' . $existingImage->type, $newImage->getClientOriginalName(), 'upload_image');
            DB::table('tricycle_images')->whereId($request->image_id)->update([
                'filename' => $newImage->getClientOriginalName(),
                'type' => $existingImage->type,
                'photo_type' => $existingImage->photo_type,
                'photo_status' => 'not_active',
                'imageable_type' => $existingImage->imageable_type,
                'reject_reson' => null,
                'imageable_id'  => $existingImage->imageable_id,
                'updated_by_callcenter_id' => get_user_data()->id,
                'updated_at_callcenter' => now(),
            ]);
            return redirect()->back()->with('success', "Update {$photoType} Successfully");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /*********************************************** */
    /*public function switchType(Request $request, $id) {
        $captain = Captain::findOrFail($id);
        if ($request->has('scooter')) {
            $captain->update(['status_caption_type' => 'scooter']);
            $captain->captainActivity->update(['status_caption_type' => 'scooter']);
            return redirect()->route('CallCenterCaptains.index')->with('success', "captain update scooter successfully");
        }
        if ($request->has('car')) {
            $captain->update(['status_caption_type' => 'car']);
            $captain->captainActivity->update(['status_caption_type' => 'car']);
            return redirect()->route('CallCenterCaptains.index')->with('success', "captain update  car successfully");
        }
    }*/
    public function switchType(Request $request, $id) {
        $captain = Captain::findOrFail($id);
        DB::transaction(function () use ($captain, $request) {
            if ($request->has('scooter')) {
                $captain->update(['status_caption_type' => 'scooter']);
                $captain->captainActivity->update(['status_caption_type' => 'scooter']);
                if ($captain->car) 
                    $captain->car->delete();
            }
            if ($request->has('car')) {
                $captain->update(['status_caption_type' => 'car']);
                $captain->captainActivity->update(['status_caption_type' => 'car']);
                if (!$captain->car) {
                    $captain->scooters->each->delete();
                    $captain->car()->create([]);
                }
            }
        });
        return redirect()->route('CallCenterCaptains.index')->with('success', "Captain updated type successfully");
    }
}