<?php
namespace App\Services\Dashboard\Admins;
use App\DataTables\Orders\OrderDataTable;
use App\DataTables\Dashboard\Admin\Captain\CaptainBounesDataTable;
use App\Models\{Captain, CaptainProfile, CarsCaption, CaptionBonus};
use App\Models\Traits\Api\ImageUploadTrait;

class CaptainService {
    use ImageUploadTrait;
    public function create($data) {
        $data['password'] = bcrypt($data['password']);
        $data['admin_id'] = get_user_data()->id;
        $data['register_type'] = 'admin';
        return Captain::create($data);
    }

    public function update($captainId, $data) {
        $data['admin_id'] = get_user_data()->id;
        $captain = Captain::findOrFail($captainId);
        $captain->fill($data);
        $captain->save();
        return $captain;
    }

    public function delete($captainId) {
        $captain = Captain::findOrFail($captainId);
        $captain->delete();
        return $captain;
    }

    public function forceDelete($id) {
        $captain = Captain::findOrFail($id);
        $captain->forceDelete();
        return $captain;
    }

    public function updatePassword($captainId, $password) {
        $captain = Captain::findOrFail($captainId);
        $captain->password = bcrypt($password);
        $captain->save();
        return $captain;
    }

    public function getNotifications($captainId) {
        $captain = Captain::findOrFail($captainId);
        return $captain->notifications;
    }

    public function getProfile($captainId) {
        $relations = [
            'profile',
            'country',
            'car',
            'admin',
            'employee',
            'agent',
            'notifications',
            'captainActivity',
            'captainProfile',
            'scooters',
            'scooters.scooterImages'
        ];
        return Captain::with($relations)->whereHas('profile', function ($query) use ($captainId) {
            $query->where('uuid', $captainId);
        })->firstOrFail();
    }

    public function uploadPersonalMedia($request) {
        $captainId = $request->input('id');
        $captain = CaptainProfile::findOrFail($captainId);
        $namePhotoArray = json_decode($request->input('name_photo'), true);
        $folderName = $captain->uuid . '_' . Captain::whereId($captainId)->first()->name;
        $this->uploadProfileImage($request, $captain, $namePhotoArray, 'personal', $folderName, 'upload_image');
    }

    public function uploadCarMedia($request) {
        $captainId = $request->input('id');
        $captain = CarsCaption::findOrFail($captainId);
        $captainUuid = CaptainProfile::findOrFail($captainId);
        $namePhotoArray = json_decode($request->input('name_photo'), true);
        $folderName = $captainUuid->uuid . '_' . Captain::whereId($captainId)->first()->name;
        $this->uploadCarImage($request, $captain, $namePhotoArray, 'car', $folderName, 'upload_image');
    }

    public function dataTable(OrderDataTable $dataTable)
    {
        return $dataTable;
    }

    public function getBounes($captainId) {
        $captain = CaptionBonus::findOrFail($captainId);
        return $captain;
    }
}
