<?php
namespace App\Services\Dashboard\Admins\CMS;
use App\Models\Cms\CmsService;
class ServiceService {
    public function create($data) {
        $data['admin_id'] = get_user_data()->id;
        return CmsService::create($data);
    }

    public function update($serviceId, $data) {
        $data['admin_id'] = get_user_data()->id;
        $service = CmsService::findOrFail($serviceId);
        $service->fill($data);
        $service->save();
        return $service;
    }

    public function delete($serviceId) {
        $service = CmsService::findOrFail($serviceId);
        $service->delete();
        return $service;
    }
}