<?php

namespace App\Http\Controllers\Api\Drivers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\Dashboard\Admins\CaptainService;
use App\Models\Traits\Api\{ApiResponseTrait, ImageUploadTrait};
use App\Models\{CaptainTricycle,CaptainScooter,TricycleImage,
    ScooterImage, Captain, CaptainProfile, CarsCaption, CarsCaptionStatus};
use App\Http\Resources\Drivers\{CarsCaptionResources, CaptainProfileResources, CarsCaptionStatusResources};
use Illuminate\Support\Facades\Validator;
class CaptainProfileController extends Controller
{
    use ApiResponseTrait, ImageUploadTrait;

    public function __construct(protected CaptainService $captainService)
    {
        $this->captainService = $captainService;
    }

    public function index()
    {
        try {
            $data = CaptainProfile::where('captain_id', auth('captain-api')->id())->first();
            return $this->successResponse(new CaptainProfileResources($data), 'data Return Successfully');
        } catch (\Exception $exception) {
            return $this->errorResponse('Something went wrong, please try again later');
        }
    }

    public function uploadProfile(Request $request)
    {
        try {
            $user = auth('captain-api')->user();
            if (!$user) {
                return $this->errorResponse('Sorry, you are not allowed', 403);
            }

            $numberPersonal = $request->input('number_personal');
            if ($numberPersonal) {
                $user->profile->update(['number_personal' => $numberPersonal]);
            }

            $carData = [
                'captain_id' => $user->id,
                'number_car' => $request->input('number_car'),
                'color_car' => $request->input('color_car'),
                'year_car' => $request->input('year_car'),
                'car_make_id' => $request->input('car_make_id'),
                'car_model_id' => $request->input('car_model_id'),
                'car_type_id' => $request->input('car_type_id'),
                'category_car_id' => checkYears($request->input('year_car')),
            ];

            CarsCaption::updateOrInsert(['captain_id' => $user->id], $carData);

            $allowedPersonalImageTypes = [
                'personal_avatar',
                'id_photo_front',
                'id_photo_back',
                'criminal_record',
                'captain_license_front',
                'captain_license_back',
            ];
            $allowedCarImageTypes = [
                'car_license_front',
                'car_license_back',
                'car_front',
                'car_back',
                'car_right',
                'car_left',
                'car_inside',
            ];
            $imageType = $request->input('type');

            if ($imageType === 'personal') {
                foreach ($allowedPersonalImageTypes as $imageField) {
                    if ($request->hasFile($imageField)) {
                        $this->storeImage($request, $imageField, $imageType, $user);
                    }
                }
            } elseif ($imageType === 'car') {
                foreach ($allowedCarImageTypes as $imageField) {
                    if ($request->hasFile($imageField)) {
                        $this->storeImage($request, $imageField, $imageType, $user);
                    }
                }
            } else {
                return $this->errorResponse('Invalid image type', 400);
            }

            return $this->successResponse('Upload Profile Media Successfully for ' . $user->name);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while uploading the profile media: ' . $e->getMessage());
        }
    }


    public function updateUploadProfile(Request $request) {
        $user = auth('captain-api')->user();
        if (!$user) {
            return $this->errorResponse('Sorry, you are not allowed', 403);
        }
    
        $imageType = $request->input('type');
        $captainFolderName = str_replace(' ', '_', $user->name) . '_' . $user->captainProfile->uuid;
    
        if (!in_array($imageType, ['personal', 'car'])) {
            return $this->errorResponse('Invalid image type', 400);
        }
    
        $path_image = public_path('dashboard/img/' . $captainFolderName . '/' . $imageType);
        $allowedImageTypes = [
            'personal_avatar',
            'id_photo_front',
            'id_photo_back',
            'criminal_record',
            'captain_license_front',
            'captain_license_back',
            'car_license_front',
            'car_license_back',
            'car_front',
            'car_back',
            'car_right',
            'car_left',
            'car_inside',
        ];
        $commonElements = array_intersect(array_keys($request->all()), $allowedImageTypes);
        foreach ($commonElements as $allowedType) {
            $oldImage = Image::where([
                'imageable_type' => 'App\Models\Captain',
                'imageable_id' => $user->id,
                'photo_type' => $allowedType,
            ])->first();
            if ($oldImage) {
                $filePath = $path_image . '/' . $oldImage->filename;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                $oldImage->delete();
            }
            if ($request->hasFile($allowedType)) {
                $newImage = $request->file($allowedType);
                $imageTypePhoto = $allowedType . '.' . $newImage->getClientOriginalExtension();
                $newImage->move($path_image, $imageTypePhoto);
                $image = new Image();
                $image->photo_type = $allowedType;
                $image->imageable_type = 'App\Models\Captain';
                $image->filename = $imageTypePhoto;
                $image->imageable_id = $user->id;
                $image->photo_status = 'not_active';
                $image->type = $request->input('type');
                $image->save();
            }
        }
        return $this->successResponse('Profile images updated successfully');
    }

    public function getRejectMedia(Request $request)
    {
        try {
            $user = auth('captain-api')->user();
            if (!$user) {
                return $this->errorResponse('Sorry, you are not allowed', 403);
            }
            $captainFolderName = str_replace(' ', '_', $user->name) . '_' . $user->captainProfile->uuid;
            $rejectedImages = Image::where([
                'imageable_type' => 'App\Models\Captain',
                'imageable_id' => $user->id,
                'photo_status' => 'rejected',
            ])->get();
            $mediaData = [];

            foreach ($rejectedImages as $image) {
                $imageType = $image->type;
                $imageTypeFolder = $imageType === 'personal' ? 'personal' : 'car';

                $mediaData[] = [
                    'photo_status' => $image?->photo_status,
                    'photo_type' => $image?->photo_type,
                    'reject_reason' => $image?->reject_reson,
                    'type' => $image?->type,
                    'filename' => $image->filename,
                    'image_path' => asset('dashboard/img/' . $captainFolderName . '/' . $imageTypeFolder . '/' . $image->filename),
                ];
            }

            $responseData = [
                'message' => 'Rejected media retrieved successfully',
                'data' => $mediaData,
            ];

            return response()->json($responseData);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while retrieving rejected media: ' . $e->getMessage());
        }
    }

    public function allMedia(Request $request)
    {
        try {
            $user = auth('captain-api')->user();
            if (!$user) {
                return $this->errorResponse('Sorry, you are not allowed', 403);
            }
            $imageType = $request->input('type');
            $imageTypeFolder = in_array($imageType, ['car', 'personal']) ? $imageType : 'default';
            $captainFolderName = str_replace(' ', '_', $user->name) . '_' . $user->captainProfile->uuid;
            $allMedia = Image::where([
                'imageable_type' => 'App\Models\Captain',
                'imageable_id' => $user->id,
                'type' => $imageType,
            ])->get();
            $mediaData = [];
            foreach ($allMedia as $image) {
                $mediaData[] = [
                    'photo_status' => $image->photo_status,
                    'photo_type' => $image->photo_type,
                    'reject_reason' => $image->reject_reson,
                    'image_path' => asset('dashboard/img/' . $captainFolderName . '/' . $imageTypeFolder . '/' . $image->filename),
                ];
            }
            $responseData = [
                'message' => 'All media retrieved successfully',
                'data' => $mediaData,
            ];
            return response()->json($responseData);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while retrieving media: ' . $e->getMessage());
        }
    }

    public function checkImg(Request $request)
    {
        try {
            $user = auth('captain-api')->user();
            $captainFolderName = str_replace(' ', '_', $user->name) . '_' . $user->captainProfile->uuid;
            if (!$user)
                return $this->errorResponse('Sorry, you are not allowed', 403);

            $requiredPersonalFields = [
                'personal_avatar',
                'id_photo_front',
                'id_photo_back',
                'criminal_record',
                'captain_license_front',
                'captain_license_back',
            ];

            $requiredCarFields = [
                'car_license_front',
                'car_license_back',
                'car_front',
                'car_back',
                'car_right',
                'car_left',
                'car_inside',
            ];

            $matchingPersonalImages = Image::where([
                'imageable_type' => 'App\Models\Captain',
                'imageable_id' => $user->id,
            ])->whereIn('photo_type', $requiredPersonalFields)->get();

            $matchingCarImages = Image::where([
                'imageable_type' => 'App\Models\Captain',
                'imageable_id' => $user->id,
            ])->whereIn('photo_type', $requiredCarFields)->get();

            $personalFieldsComplete = count($matchingPersonalImages) === count($requiredPersonalFields);
            $carFieldsComplete = count($matchingCarImages) === count($requiredCarFields);

            $response = [
                'captain_personal' => $personalFieldsComplete,
                'captain_car' => $carFieldsComplete,
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while checking media: ' . $e->getMessage());
        }
    }

    private function storeImage(Request $request, $field, $type, $imageable)
    {
        $image = new Image();
        $image->photo_type = $field;
        $image->imageable_type = 'App\Models\Captain';
        $imageable = json_decode($imageable);

        if ($request->file($field)->isValid()) {
            $captainProfile = CaptainProfile::whereCaptainId($imageable->id)->select('uuid')->first();
            if ($captainProfile) {
                $nameWithoutSpaces = str_replace(' ', '_', $imageable->name);
                $userDirectory = $nameWithoutSpaces . '_' . $captainProfile->uuid;
                $typeDirectory = $type;
                $originalFileName = $request->file($field)->getClientOriginalName();
                $filename = $field . '.' . $request->file($field)->getClientOriginalExtension();
                $path = $userDirectory . '/' . $typeDirectory . '/';
                $request->file($field)->storeAs($path, $originalFileName, 'upload_image');
                $image->photo_status = 'not_active';
                $image->type = $type;
                $image->filename = $originalFileName;
                //$image->filename = $filename;
                $image->imageable_id = $imageable->id;
                $image->save();
            }
        }
    }

    public function uploadCarPhoto(Request $request)
    {
        try {
            $user = auth('captain-api')->user();
            if (!$user)
                return $this->errorResponse('Sorry, you are not allowed', 403);
            $captainCar = $user->car;
            if (!$captainCar)
                return $this->errorResponse('Sorry, you do not have a car');
            $namePhotoArray = ['car_photo_before', 'car_photo_behind', 'car_photo_right', 'car_photo_north', 'car_photo_inside', 'car_license_before', 'car_license_behind'];
            $type_photo = 'car';
            $originalCaptainName = Captain::whereId($captainCar->captain_id)->first()->name;
            $cleanedCaptainName = str_replace(' ', '_', $originalCaptainName);
            $foldername = $user->profile->uuid . '_' . $cleanedCaptainName;
            $disk = 'upload_image';
            CarsCaption::where('captain_id', auth('captain-api')->id())->update([
                'car_make_id' => $request->car_make_id,
                'car_model_id' => $request->car_model_id,
                'car_type_id' => $request->car_type_id,
                'category_car_id' => checkYears($request->years),
                'number_car' => $request->number_car,
                'color_car' => $request->color_car,
            ]);
            $additionalFields = $request->only(['car_make_id', 'car_model_id', 'car_type_id', 'category_car_id', 'number_car', 'color_car']);
            $captainCar->update($additionalFields);
            $this->uploadCarImage($request, $captainCar, $namePhotoArray, $type_photo, $foldername, $disk);
            return $this->successResponse('Upload Car Media Successfully for ' . $user->name);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while uploading the car media: ' . $e->getMessage());
        }
    }

    public function getCar()
    {
        try {
            $data = CarsCaption::where('captain_id', auth('captain-api')->id())->first();
            if (isset($data)) {
                return $this->successResponse(new CarsCaptionResources($data), 'data Return Successfully');
            }
            return $this->successResponse('', 'No Cars In Caption');
        } catch (\Exception $exception) {
            return $this->errorResponse('Something went wrong, please try again later');
        }


    }

    public function getCaptainPhotosWithStatus()
    {
        $captain = CaptainProfile::where('captain_id', auth('captain-api')->id())->first();
        if (!$captain)
            return $this->errorResponse('Captain profile not found', 404);
        $response = [];
        $photoColumns = [
            'photo_id_before',
            'photo_id_behind',
            'photo_driving_before',
            'photo_driving_behind',
            'photo_criminal',
            'photo_personal',
        ];
        foreach ($photoColumns as $column) {
            $mediaFileStatus = CarsCaptionStatus::where('captain_profile_id', $captain->id)
                ->where('type_photo', 'personal')
                ->where('name_photo', $column)
                ->first();
            if ($mediaFileStatus) {
                $cleanedCaptainName = str_replace(' ', '_', $captain->owner->name);
                $response[] = [
                    'name_photo' => $column,
                    'status' => $mediaFileStatus->status,
                    'image' => $captain->{$column} ? asset('dashboard/img/' . $captain->uuid . '_' . $cleanedCaptainName . '/' . 'personal/' . $captain->{$column}) : null,
                    'reject_message' => $mediaFileStatus->reject_message
                ];

            } else {
                return $this->errorResponse('No media file status found for ' . $column, 404);
            }
        }
        return $this->successResponse($response, 'Profile Media files status retrieved successfully for ' . $captain->owner->name);
    }

    public function getCaptainCarsPhotosWithStatus()
    {
        $captain = CarsCaption::with('captain')->where('captain_id', auth('captain-api')->id())->first();
        if (!$captain)
            return $this->errorResponse('Captain cars media not found', 404);
        $response = [];
        $photoColumns = [
            'car_photo_before',
            'car_photo_behind',
            'car_photo_right',
            'car_photo_north',
            'car_photo_inside',
            'car_license_before',
            'car_license_behind',
        ];
        foreach ($photoColumns as $column) {
            $mediaFileStatus = CarsCaptionStatus::where('cars_caption_id', $captain->id)
                ->where('type_photo', 'car')
                ->where('name_photo', $column)
                ->first();
            if ($mediaFileStatus) {
                $cleanedCaptainName = str_replace(' ', '_', $captain->captain->name);
                $response[] = [
                    'name_photo' => $column,
                    'status' => $mediaFileStatus->status,
                    'image' => $captain->{$column} ? asset('dashboard/img/' . $captain->captain->captainProfile->uuid . '_' . $cleanedCaptainName . '/' . 'car/' . $captain->{$column}) : null,
                    'reject_message' => $mediaFileStatus->reject_message
                ];

            } else {
                return $this->errorResponse('No media file status found for ' . $column, 404);
            }
        }
        return $this->successResponse($response, 'Car Media files status retrieved successfully for ' . $captain->captain->name);
    }

    public function checkUploadfilesOrNot()
    {
        $captain = auth('captain-api')->user();
        if (!$captain)
            return $this->errorResponse('Sorry, you are not allowed', 403);
        $profilePhotos = [
            'photo_id_before',
            'photo_id_behind',
            'photo_driving_before',
            'photo_driving_behind',
            'photo_criminal',
            'photo_personal',
        ];
        $carPhotos = [
            'car_photo_before',
            'car_photo_behind',
            'car_photo_right',
            'car_photo_north',
            'car_photo_inside',
            'car_license_before',
            'car_license_behind',
        ];

        $profilePhotosCount = 0;
        $carPhotosCount = 0;

        $captainProfile = CaptainProfile::where('captain_id', $captain->id)->first();
        if ($captainProfile) {
            foreach ($profilePhotos as $column) {
                if ($captainProfile->{$column}) {
                    $profilePhotosCount++;
                }
            }
        }
        $captainCar = CarsCaption::where('captain_id', $captain->id)->first();
        if ($captainCar) {
            foreach ($carPhotos as $column) {
                if ($captainCar->{$column}) {
                    $carPhotosCount++;
                }
            }
        }
        if ($profilePhotosCount > 0 && $carPhotosCount > 0) {
            //return $this->successResponse('data','Captain has uploaded photos.');
            return $response[] = [
                'profilePhotos' => true,
                'carPhotos' => true,
            ];
        } elseif ($profilePhotosCount > 0) {
            //return $this->successResponse('Captain has uploaded photos to captain profiles.');
            return $response[] = [
                'profilePhotos' => true,
                'carPhotos' => false,
            ];
        } elseif ($carPhotosCount > 0) {
            //return $this->successResponse('Captain has uploaded photos to cars captions.');
            return $response[] = [
                'carPhotos' => true,
                'profilePhotos' => false,
            ];
        } else {
            //return $this->errorResponse('Captain has not uploaded any photos.');
            return $response[] = [
                'carPhotos' => false,
                'profilePhotos' => false,
            ];
        }
    }

    public function createNewScooter(Request $request) {
        //try {
            $captain = auth('captain-api')->user();
            //if ($captain->status_caption_type !== 'scooter' || $captain->captainActivity->status_caption_type !== 'scooter')
                //return $this->errorResponse("Sorry, Invalid captain type must be scooter your type is {$captain->status_caption_type}");
            
            $validator = Validator::make($request->all(), [
                'scooter_make_id' => 'required|exists:scooter_makes,id',
                'scooter_model_id' => 'required|exists:scooter_models,id',
                'scooter_number' => 'required|string',
                'scooter_color' => 'required|string',
                'scooter_year' => 'required|numeric',
            ]);
            $existingScooter = $captain->scooters()->where('scooter_number', $request->input('scooter_number'))->first();
            if ($existingScooter) 
                return $this->errorResponse("Sorry, Scooter with the same number already exists for this {$captain->name}");
            $type = 'scooter';
            $scooterType = $captain->scooters->isEmpty() ? 'master' : 'general';
            $validatedData = $validator->validated();
            $validatedData['scooter_type'] = $scooterType;
            $latestScooter = $captain->scooters()->create($validatedData);
            $captainProfile = CaptainProfile::whereCaptainId($captain->id)->select('uuid')->first();
            if ($captainProfile) {
                $nameWithoutSpaces = str_replace(' ', '_', $captain->name);
                $userDirectory = $nameWithoutSpaces . '_' . $captainProfile->uuid;
                $typeDirectory = 'scooter' . DIRECTORY_SEPARATOR  . $latestScooter->scooter_number . DIRECTORY_SEPARATOR . $type;
                $fileKeys = [];
                $photoTypeMapping = [
                    'scooter_license_front' => 'scooter_license_front',
                    'scooter_license_back' => 'scooter_license_back',
                    'scooter_front' => 'scooter_front',
                    'scooter_back' => 'scooter_back',
                ];
                foreach ($request->only(array_keys($photoTypeMapping)) as $key => $file) {
                    if ($file) {
                        $filename = $file->getClientOriginalName();
                        $path = $file->storeAs("{$userDirectory}/{$typeDirectory}", $filename, 'upload_image');
                        $fileKeys[$key] = $path;
                        $photoType = $photoTypeMapping[$key] ?? 'unknown';
                        $existingImage = ScooterImage::where([
                            'imageable_id' => $captain->id,
                            'photo_type' => $photoType,
                        ])->first();
                        if ($existingImage) {
                            return $this->errorResponse("This image '{$photoType}' already exists for this {$captain->name}. and status is {$existingImage->photo_status}");
                        }
                        ScooterImage::create([
                            'filename' => $filename,
                            'type' => $type,
                            'photo_type' => $photoType,
                            'imageable_type' => 'App\Models\ScooterImage',
                            'photo_status' => 'not_active',
                            'imageable_id' => $latestScooter->id,
                        ]);
                    }
                }
            }
            return $this->successResponse("Create Scooter Successfully for {$captain->name}");
        /*} catch (\Exception $e) {
            return $this->errorResponse("Sorry, Something Happen when create {$captain->status_caption_type} for {$captain->name}");
        }*/
    }
    
    public function uploadScooterPersonalImg(Request $request) {
        $user = auth('captain-api')->user();
            if (!$user) 
                return $this->errorResponse('Sorry, you are not allowed', 403);
        $captainProfile = CaptainProfile::whereCaptainId($user->id)->select('uuid')->first();
        $latestScooterNumber = $user->scooters()->latest()->value('scooter_number');
        $latestScooterId = $user->scooters()->latest()->value('id');
        if ($captainProfile) {
            $nameWithoutSpaces = str_replace(' ', '_', $user->name);
            $userDirectory = $nameWithoutSpaces . '_' . $captainProfile->uuid;
            $typeDirectory = 'scooter' . DIRECTORY_SEPARATOR . $latestScooterNumber . DIRECTORY_SEPARATOR . $request->type;
            $directoryPath = public_path("dashboard/img/{$userDirectory}/{$typeDirectory}");
            
            if (!file_exists($directoryPath)) 
                mkdir($directoryPath, 0755, true);
            $fileKeys = [];
            $photoTypeMapping = [
                'personal_avatar' => 'personal_avatar',
                'id_photo_front' => 'id_photo_front',
                'id_photo_back' => 'id_photo_back',
                'criminal_record' => 'criminal_record',
                'captain_license_front' => 'captain_license_front',
                'captain_license_back' => 'captain_license_back',
                'scooter_license_front' => 'scooter_license_front',
                'scooter_license_back' => 'scooter_license_back',
            ];
            foreach ($request->only(array_keys($photoTypeMapping)) as $key => $file) {
                if ($file) {
                    $filename = $file->getClientOriginalName();
                    
                    $path = $file->storeAs("{$userDirectory}/{$typeDirectory}", $filename, 'upload_image');
                    $fileKeys[$key] = $path;
                    $photoType = $photoTypeMapping[$key] ?? 'unknown';
                    $existingImage = ScooterImage::where([
                        'imageable_id' => $user->id,
                        'photo_type' => $photoType,
                    ])->first();
                    if ($existingImage) 
                        return $this->errorResponse("This image '{$photoType}' already exists for this {$user->name}. and status is {$existingImage->photo_status}");
                    ScooterImage::create([
                        'filename' => $filename,
                        'type' => $request->type,
                        'photo_type' => $photoType,
                        'imageable_type' => 'App\Models\ScooterImage',
                        'photo_status' => 'not_active',
                        'imageable_id' => $latestScooterId,
                    ]);
                }
            }
            return $this->successResponse('Image uploaded successfully');
        }
    }

    public function allScooterMedia(Request $request) {
        try {
            $user = auth('captain-api')->user();
            if (!$user) {
                return $this->errorResponse('Sorry, you are not allowed', 403);
            }
            $imageType = $request->input('type');
            $latestScooterId = $user->scooters()->latest()->value('id');
            $imageTypeFolder = in_array($imageType, ['scooter', 'personal']) ? $imageType : 'default';
            $captainFolderName = str_replace(' ', '_', $user->name) . '_' . $user->captainProfile->uuid;
            $latestScooterNumber = $user->scooters()->latest()->value('scooter_number');
            $allMedia = ScooterImage::where([
                'imageable_type' => 'App\Models\ScooterImage',
                'imageable_id' => $latestScooterId,
                'type' => $imageType,
            ])->get();
            $mediaData = [];
            foreach ($allMedia as $image) {
                $mediaData[] = [
                    'photo_status' => $image->photo_status,
                    'photo_type' => $image->photo_type,
                    'reject_reason' => $image->reject_reson,
                    'image_path' => asset('dashboard/img/' . $captainFolderName . '/scooter/' . $latestScooterNumber . '/' . $imageTypeFolder . '/' . $image->filename),
                ];
            }
            $responseData = [
                'message' => 'All media retrieved successfully',
                'data' => $mediaData,
            ];
            return response()->json($responseData);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while retrieving media: ' . $e->getMessage());
        }
    }

    public function checkScooterImg(Request $request)
    {
        try {
            $user = auth('captain-api')->user();
            $scooterId = DB::table('captain_scooters')->where('captain_id', '=', $user->id)->value('id');
            $captainFolderName = str_replace(' ', '_', $user->name) . '_' . $user->captainProfile->uuid;
            if (!$user)
                return $this->errorResponse('Sorry, you are not allowed', 403);

            $requiredPersonalFields = [
                'personal_avatar',
                'id_photo_front',
                'id_photo_back',
                'criminal_record',
                'captain_license_front',
                'captain_license_back',
            ];

            $requiredScooterFields = [
                'scooter_front',
                'scooter_back',
            ];

            $matchingPersonalImages = ScooterImage::where([
                'imageable_type' => 'App\Models\ScooterImage',
                'imageable_id' => $scooterId,
            ])->whereIn('photo_type', $requiredPersonalFields)->get();

            $matchingScooterImages = ScooterImage::where([
                'imageable_type' => 'App\Models\ScooterImage',
                'imageable_id' => $scooterId,
            ])->whereIn('photo_type', $requiredScooterFields)->get();

            $personalFieldsComplete = count($matchingPersonalImages) === count($requiredPersonalFields);
            $scooterFieldsComplete = count($matchingScooterImages) === count($requiredScooterFields);

            $response = [
                'captain_scooter_personal' => $personalFieldsComplete,
                'captain_scooter' => $scooterFieldsComplete,
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while checking media: ' . $e->getMessage());
        }
    }

    public function getScooterRejectMedia(Request $request) {
        try {
            $user = auth('captain-api')->user();
            $scooterId = DB::table('captain_scooters')->where('captain_id', '=', $user->id)->value('id');
            if (!$user) {
                return $this->errorResponse('Sorry, you are not allowed', 403);
            }
            $captainFolderName = str_replace(' ', '_', $user->name) . '_' . $user->captainProfile->uuid;
            $rejectedImages = ScooterImage::where([
                'imageable_type' => 'App\Models\ScooterImage',
                'imageable_id' => $scooterId,
                'photo_status' => 'rejected',
            ])->get();
            $mediaData = [];

            foreach ($rejectedImages as $image) {
                $imageType = $image->type;
                $imageTypeFolder = $imageType === 'personal' ? 'personal' : 'scooter';

                $mediaData[] = [
                    'photo_status' => $image?->photo_status,
                    'photo_type' => $image?->photo_type,
                    'reject_reason' => $image?->reject_reson,
                    'type' => $image?->type,
                    'filename' => $image->filename,
                    'image_path' => asset('dashboard/img/' . $captainFolderName . '/scooter/' . $imageTypeFolder . '/' . $image->filename),
                ];
            }

            $responseData = [
                'message' => 'Rejected media retrieved successfully',
                'data' => $mediaData,
            ];

            return response()->json($responseData);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while retrieving rejected media: ' . $e->getMessage());
        }
    }

    public function updateScooterRejectedImage(Request $request) {
        try {
            $captain = auth('captain-api')->user();
            if (!$captain) {
                return $this->errorResponse('Sorry, you are not allowed', 403);
            }
            //$existingImage = DB::table('scooter_images')->whereId($request->image_id)->first();
            $fileKey = '';
            foreach ($request->all() as $key => $value) {
                if ($value instanceof \Illuminate\Http\UploadedFile) {
                    $fileKey = $key;
                    break;
                }
            }
            $existingImage = DB::table('scooter_images')
                ->where('photo_type', $fileKey)
                ->where('photo_status', '=', 'rejected')
                ->orderBy('id', 'desc')
                ->first();
            //dd($existingImage->photo_type);
            $relatedScooter = CaptainScooter::find($existingImage->imageable_id);
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
            //$newImage = $request->file('filename');
            $newImage = $request->file($fileKey);
            $newImagePath = $newImage->storeAs($path . '/' . $existingImage->type, $newImage->getClientOriginalName(), 'upload_image');
            DB::table('scooter_images')->whereId($existingImage->id)->update([
                'filename' => $newImage->getClientOriginalName(),
                'type' => $existingImage->type,
                'photo_type' => $existingImage->photo_type,
                'photo_status' => 'not_active',
                'imageable_type' => $existingImage->imageable_type,
                'reject_reson' => null,
                'imageable_id'  => $existingImage->imageable_id,
                'updated_by_callcenter_id' => $captain->id,
                'updated_at_callcenter' => now(),
            ]);
            return $this->successResponse("Update {$photoType} Successfully");
        } catch (\Exception $e) {
            return $this->errorResponse("An error occurred while {$photoType} : " . $e->getMessage());
        }
    }

    // Start Tricycle ::
    public function createNewTricycle(Request $request) {
        //dd($request->all());
        try {
            $captain = auth('captain-api')->user();
            //if ($captain->status_caption_type !== 'scooter' || $captain->captainActivity->status_caption_type !== 'scooter')
            //return $this->errorResponse("Sorry, Invalid captain type must be scooter your type is {$captain->status_caption_type}");

            $validator = Validator::make($request->all(), [
                'tricycle_make_id' => 'required|exists:tricycle_makes,id',
                'tricycle_model_id' => 'required|exists:tricycle_models,id',
                'tricycle_number' => 'required|string',
                'tricycle_color' => 'required|string',
                'tricycle_year' => 'required|numeric',
            ]);
            $existingTricycle = $captain->tricycles()->where('tricycle_number', $request->input('tricycle_number'))->first();
            if ($existingTricycle)
                return $this->errorResponse("Sorry, tricycle with the same number already exists for this {$captain->name}");
            $type = 'tricycle';
            $tricyclesType = $captain->tricycles->isEmpty() ? 'master' : 'general';
            $validatedData = $validator->validated();
            $latestTricycle = $captain->tricycles()->create($validatedData);
            $captainProfile = CaptainProfile::whereCaptainId($captain->id)->select('uuid')->first();
            if ($captainProfile) {
                $nameWithoutSpaces = str_replace(' ', '_', $captain->name);
                $userDirectory = $nameWithoutSpaces . '_' . $captainProfile->uuid;
                $typeDirectory = 'tricycle' . DIRECTORY_SEPARATOR  . $latestTricycle->tricycle_number . DIRECTORY_SEPARATOR . $type;
                $fileKeys = [];
                $photoTypeMapping = [
                    'tricycle_front' => 'tricycle_front',
                    'tricycle_back' => 'tricycle_back',
                    'tricycle_right' => 'tricycle_right',
                    'tricycle_left' => 'tricycle_left',
                ];
                foreach ($request->only(array_keys($photoTypeMapping)) as $key => $file) {
                    if ($file) {
                        $filename = $file->getClientOriginalName();
                        $path = $file->storeAs("{$userDirectory}/{$typeDirectory}", $filename, 'upload_image');
                        $fileKeys[$key] = $path;
                        $photoType = $photoTypeMapping[$key] ?? 'unknown';
                        $existingImage = TricycleImage::where([
                            'imageable_id' => $captain->id,
                            'photo_type' => $photoType,
                        ])->first();
                        if ($existingImage) {
                            return $this->errorResponse("This image '{$photoType}' already exists for this {$captain->name}. and status is {$existingImage->photo_status}");
                        }
                        TricycleImage::create([
                            'filename' => $filename,
                            'type' => $type,
                            'photo_type' => $photoType,
                            'imageable_type' => 'App\Models\CaptainTricycle',
                            'photo_status' => 'not_active',
                            'imageable_id' => $latestTricycle->id,
                        ]);
                    }
                }
            }
            return $this->successResponse("Create Tricycle Successfully for {$captain->name}");
        } catch (\Exception $e) {
            return $this->errorResponse("Sorry, Something Happen when create {$captain->status_caption_type} for {$captain->name}");
        }
    }

    public function uploadTricylePersonalImg(Request $request) {
        $user = auth('captain-api')->user();
        if (!$user)
            return $this->errorResponse('Sorry, you are not allowed', 403);
        $captainProfile = CaptainProfile::whereCaptainId($user->id)->select('uuid')->first();
        $latestTricycleNumber = $user->tricycles()->latest()->value('tricycle_number');
        $latestTricycleId = $user->tricycles()->latest()->value('id');
        if ($captainProfile) {
            $nameWithoutSpaces = str_replace(' ', '_', $user->name);
            $userDirectory = $nameWithoutSpaces . '_' . $captainProfile->uuid;
            $typeDirectory = 'tricycle' . DIRECTORY_SEPARATOR . $latestTricycleNumber . DIRECTORY_SEPARATOR . $request->type;
            $directoryPath = public_path("dashboard/img/{$userDirectory}/{$typeDirectory}");

            if (!file_exists($directoryPath))
                mkdir($directoryPath, 0755, true);
            $fileKeys = [];
            $photoTypeMapping = [
                'personal_avatar' => 'personal_avatar',
                'id_photo_front' => 'id_photo_front',
                'id_photo_back' => 'id_photo_back',
                'criminal_record' => 'criminal_record',
                'captain_license_front' => 'captain_license_front',
                'captain_license_back' => 'captain_license_back',
                'tricycle_license_front' => 'tricycle_license_front',
                'tricycle_license_back' => 'tricycle_license_back',
            ];
            foreach ($request->only(array_keys($photoTypeMapping)) as $key => $file) {
                if ($file) {
                    $filename = $file->getClientOriginalName();

                    $path = $file->storeAs("{$userDirectory}/{$typeDirectory}", $filename, 'upload_image');
                    $fileKeys[$key] = $path;
                    $photoType = $photoTypeMapping[$key] ?? 'unknown';
                    $existingImage = TricycleImage::where([
                        'imageable_id' => $latestTricycleId,
                        'photo_type' => $photoType,
                    ])->first();
                    if ($existingImage)
                        return $this->errorResponse("This image '{$photoType}' already exists for this {$user->name}. and status is {$existingImage->photo_status}");
                    TricycleImage::create([
                        'filename' => $filename,
                        'type' => $request->type,
                        'photo_type' => $photoType,
                        'imageable_type' => 'App\Models\CaptainTricycle',
                        'photo_status' => 'not_active',
                        'imageable_id' => $latestTricycleId,
                    ]);
                }
            }
            return $this->successResponse('Image uploaded successfully');
        }
    }

    public function allTricyleMedia(Request $request) {
        try {
            $user = auth('captain-api')->user();
            if (!$user) {
                return $this->errorResponse('Sorry, you are not allowed', 403);
            }
            $imageType = $request->input('type');
            $latestTricycleId = $user->tricycles()->latest()->value('id');
            $imageTypeFolder = in_array($imageType, ['tricycle', 'personal']) ? $imageType : 'default';
            $captainFolderName = str_replace(' ', '_', $user->name) . '_' . $user->captainProfile->uuid;
            $latestTricycleNumber = $user->tricycles()->latest()->value('tricycle_number');
            $allMedia = TricycleImage::where([
                'imageable_type' => 'App\Models\CaptainTricycle',
                'imageable_id' => $latestTricycleId,
                'type' => $imageType,
            ])->get();
            $mediaData = [];
            foreach ($allMedia as $image) {
                $mediaData[] = [
                    'photo_status' => $image->photo_status,
                    'photo_type' => $image->photo_type,
                    'reject_reason' => $image->reject_reson,
                    'image_path' => asset('dashboard/img/' . $captainFolderName . '/tricycle/' . $latestTricycleNumber . '/' . $imageTypeFolder . '/' . $image->filename),
                ];
            }
            $responseData = [
                'message' => 'All media retrieved successfully',
                'data' => $mediaData,
            ];
            return response()->json($responseData);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while retrieving media: ' . $e->getMessage());
        }
    }

    public function checkTricyleImg(Request $request) {
        try {
            $user = auth('captain-api')->user();
            $tricycleId = DB::table('captain_tricycles')->where('captain_id', '=', $user->id)->value('id');
            $captainFolderName = str_replace(' ', '_', $user->name) . '_' . $user->captainProfile->uuid;
            if (!$user)
                return $this->errorResponse('Sorry, you are not allowed', 403);

            $requiredPersonalFields = [
                'personal_avatar',
                'id_photo_front',
                'id_photo_back',
                'criminal_record',
                'captain_license_front',
                'captain_license_back',
            ];
            $requiredTricycleFields = [
                'tricycle_license_front',
                'tricycle_license_back',
                'tricycle_front',
                'tricycle_back',
                'tricycle_right',
                'tricycle_left'
            ];

            $matchingPersonalImages = TricycleImage::where([
                'imageable_type' => 'App\Models\CaptainTricycle',
                'imageable_id' => $tricycleId,
            ])->whereIn('photo_type', $requiredPersonalFields)->get();

            $matchingTricycleImages = TricycleImage::where([
                'imageable_type' => 'App\Models\CaptainTricycle',
                'imageable_id' => $tricycleId,
            ])->whereIn('photo_type', $requiredTricycleFields)->get();

            $personalFieldsComplete = count($matchingPersonalImages) === count($requiredPersonalFields);
            $tricycleFieldsComplete = count($matchingTricycleImages) === count($requiredTricycleFields);

            $response = [
                'captain_tricycle_personal' => $personalFieldsComplete,
                'captain_tricycle' => $tricycleFieldsComplete,
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while checking media: ' . $e->getMessage());
        }
    }

    public function getTricyleRejectMedia(Request $request) {
        try {
            $user = auth('captain-api')->user();
            $tricycleId = DB::table('captain_tricycles')->where('captain_id', '=', $user->id)->value('id');

            $tricycleNumber = DB::table('captain_tricycles')->where('captain_id', '=', $user->id)->value('tricycle_number');
            if (!$user) {
                return $this->errorResponse('Sorry, you are not allowed', 403);
            }
            $captainFolderName = str_replace(' ', '_', $user->name) . '_' . $user->captainProfile->uuid;
            $rejectedImages = TricycleImage::where([
                'imageable_type' => 'App\Models\CaptainTricycle',
                'imageable_id' => $tricycleId,
                'photo_status' => 'rejected',
            ])->get();

            $mediaData = [];

            foreach ($rejectedImages as $image) {
                $imageType = $image->type;
                $imageTypeFolder = $imageType === 'personal' ? 'personal' : 'tricycle';

                $mediaData[] = [
                    'photo_status' => $image?->photo_status,
                    'photo_type' => $image?->photo_type,
                    'reject_reason' => $image?->reject_reson,
                    'type' => $image?->type,
                    'filename' => $image->filename,
                    'image_path' => asset('dashboard/img/' . $captainFolderName . '/tricycle/' . $tricycleNumber . '/' . $imageTypeFolder . '/' . $image->filename),
                ];
            }

            $responseData = [
                'message' => 'Rejected media retrieved successfully',
                'data' => $mediaData,
            ];

            return response()->json($responseData);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while retrieving rejected media: ' . $e->getMessage());
        }
    }

    public function updateTricyleRejectedImage(Request $request) {
        try {
            $captain = auth('captain-api')->user();
            if (!$captain) {
                return $this->errorResponse('Sorry, you are not allowed', 403);
            }
            $fileKey = '';
            foreach ($request->all() as $key => $value) {
                if ($value instanceof \Illuminate\Http\UploadedFile) {
                    $fileKey = $key;
                    break;
                }
            }
            $existingImage = DB::table('tricycle_images')
                ->where('photo_type', $fileKey)
                ->where('photo_status', '=', 'rejected')
                ->orderBy('id', 'desc')
                ->first();
            $relatedTricycle = CaptainTricycle::find($existingImage->imageable_id);
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
            $newImage = $request->file($fileKey);
            $newImagePath = $newImage->storeAs($path . '/' . $existingImage->type, $newImage->getClientOriginalName(), 'upload_image');
            DB::table('tricycle_images')->whereId($existingImage->id)->update([
                'filename' => $newImage->getClientOriginalName(),
                'type' => $existingImage->type,
                'photo_type' => $existingImage->photo_type,
                'photo_status' => 'not_active',
                'imageable_type' => $existingImage->imageable_type,
                'reject_reson' => null,
                'imageable_id'  => $existingImage->imageable_id,
                'updated_by_callcenter_id' => null,
                'updated_at_callcenter' => now(),
            ]);
            return $this->successResponse("Update {$photoType} Successfully");
        } catch (\Exception $e) {
            return $this->errorResponse("An error occurred while {$photoType} : " . $e->getMessage());
        }
    }

}
