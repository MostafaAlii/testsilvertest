<?php

namespace App\Http\Controllers\Dashboard\Admin\Trunk;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Dashboard\{Admins\Trunk\TrunkMakeService};
use App\DataTables\Dashboard\Admin\Trunk\TrunkMakeDataTable;
class TrunkMakeController extends Controller{
    public function __construct(protected TrunkMakeDataTable $dataTable, protected TrunkMakeService $trunkMakeService) {
        $this->dataTable = $dataTable;
        $this->trunkMakeService = $trunkMakeService;
    }

    public function index() {
        $data = [
            'title' => 'Truck-Make',
        ];
        return $this->dataTable->render('dashboard.admin.trunk.trunkMake.index',  compact('data'));
    }

    public function store(Request $request) {
        try {
            $requestData = $request->all();
            $this->trunkMakeService->create($requestData);
            return redirect()->route('trunkMake.index')->with('success', 'truck make created successfully');
        } catch (\Exception $e) {
            return redirect()->route('trunkMake.index')->with('error', 'An error occurred while creating the truck make');
        }
    }

    public function update(Request $request, $trunkMakeId) {
        try {
            $requestData = $request->all();
            $this->trunkMakeService->update($trunkMakeId, $requestData);
            return redirect()->route('trunkMake.index')->with('success', 'truck make updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('trunkMake.index')->with('error', 'An error occurred while updating the truck');
        }
    }

    public function updateStatus(Request $request, $trunkMakeId) {
        try {
            $this->trunkMakeService->updateStatus($trunkMakeId, $request->status);
            return redirect()->route('trunkMake.index')->with('success', 'truck make status updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('trunkMake.index')->with('error', 'An error occurred while updating the truck make');
        }
    }

    public function destroy($id) {  
        
        try {
            $this->trunkMakeService->delete($id);
            return redirect()->route('trunkMake.index')->with('success', 'truck make deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('trunkMake.index')->with('error', 'An error occurred while deleting the truck make');
        }
    }
}