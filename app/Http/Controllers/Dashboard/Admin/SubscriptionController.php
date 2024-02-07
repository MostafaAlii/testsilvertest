<?php

namespace App\Http\Controllers\Dashboard\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Dashboard\{Admins\SubscriptionService};
use App\DataTables\Dashboard\Admin\SubscriptionDataTable;
class SubscriptionController extends Controller
{
    public function __construct(protected SubscriptionDataTable $dataTable, protected SubscriptionService $subscriptionService) {
        $this->dataTable = $dataTable;
        $this->subscriptionService = $subscriptionService;
    }
    
    public function index() {
        $data = [
            'title' => 'Subscriptions',
        ];
        return $this->dataTable->render('dashboard.admin.subscriptions.index',  compact('data'));
    }

    public function store(Request $request) {
        try {
            $requestData = $request->all();
            $this->subscriptionService->create($requestData);
            return redirect()->route('subscriptions.index')->with('success', 'subscription created successfully');
        } catch (\Exception $e) {
            return redirect()->route('subscriptions.index')->with('error', 'An error occurred while creating the subscription');
        }
    }

    public function update(Request $request, $subscriptionId) {
        try {
            $requestData = $request->all();
            $this->subscriptionService->update($subscriptionId, $requestData);
            return redirect()->route('subscriptions.index')->with('success', 'subscription updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('subscriptions.index')->with('error', 'An error occurred while updating the subscription');
        }
    }

    public function destroy($id) {  
        try {
            $this->subscriptionService->delete($id);
            return redirect()->route('subscriptions.index')->with('success', 'subscription deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('subscriptions.index')->with('error', 'An error occurred while deleting the subscription');
        }
    }
}