<?php

namespace App\Http\Controllers\Dashboard\Admin\Trunk;
use App\Models\TrunkMake;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Dashboard\{Admins\Trunk\TrunkModelService};
use App\DataTables\Dashboard\Admin\Trunk\TrunkModelDataTable;

class TrunkModelController extends Controller
{
    public function __construct(protected TrunkModelDataTable $dataTable, protected TrunkModelService $trunkModelService) {
        $this->dataTable = $dataTable;
        $this->trunkModelService = $trunkModelService;
    }
    
    public function index() {
        $data = [
            'title' => 'Truck-Model',
            'trunk_makes' => TrunkMake::active(),
        ];
        return $this->dataTable->render('dashboard.admin.trunk.trunkModel.index',  compact('data'));
    }

    public function store(Request $request) {
        try {
            $requestData = $request->all();
            $this->trunkModelService->create($requestData);
            return redirect()->route('trunkModel.index')->with('success', 'trunk model created successfully');
        } catch (\Exception $e) {
            return redirect()->route('trunkModel.index')->with('error', 'An error occurred while creating the trunk model');
        }
    }

    public function update(Request $request, $trunkModelId) {
        try {
            $requestData = $request->all();
            $this->trunkModelService->update($trunkModelId, $requestData);
            return redirect()->route('trunkModel.index')->with('success', 'trunk model updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('trunkModel.index')->with('error', 'An error occurred while updating the trunk model');
        }
    }

    public function updateStatus(Request $request, $trunkModelId) {
        try {
            $this->trunkModelService->updateStatus($trunkModelId, $request->status);
            return redirect()->route('trunkModel.index')->with('success', 'trunk model status updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('trunkModel.index')->with('error', 'An error occurred while updating the trunk model');
        }
    }

    public function destroy($id) {  
        try {
            $this->trunkModelService->delete($id);
            return redirect()->route('trunkModel.index')->with('success', 'trunk model deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('trunkModel.index')->with('error', 'An error occurred while deleting the trunk model');
        }
    }
}