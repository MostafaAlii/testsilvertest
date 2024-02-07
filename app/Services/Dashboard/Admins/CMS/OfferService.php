<?php
namespace App\Services\Dashboard\Admins\CMS;
use App\Models\Cms\CmsOffer;
class OfferService {
    public function create($data) {
        $data['admin_id'] = get_user_data()->id;
        return CmsOffer::create($data);
    }

    public function update($offerId, $data) {
        $data['admin_id'] = get_user_data()->id;
        $offer = CmsOffer::findOrFail($offerId);
        $offer->fill($data);
        $offer->save();
        return $offer;
    }

    public function delete($offerId) {
        $offer = CmsOffer::findOrFail($offerId);
        $offer->delete();
        return $offer;
    }
}