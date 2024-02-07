<?php
namespace App\Services\Dashboard\Admins;
use App\Models\SubscriptionCaption;
class SubscriptionService {
    public function create($data) {
        return SubscriptionCaption::create($data);
    }
    
    public function update($subscriptionId, $data) {
        $subscription = SubscriptionCaption::findOrFail($subscriptionId);
        $subscription->fill($data);
        $subscription->save();
        return $subscription;
    }

    public function delete($subscriptionId) {
        $subscription = SubscriptionCaption::findOrFail($subscriptionId);
        $subscription->delete();
        return $subscription;
    }
}