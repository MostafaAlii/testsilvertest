<?php

namespace App\Http\Controllers\Dashboard\Admin\Scooter;
use App\Models\ScooterMake;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Dashboard\{Admins\Scooter\ScooterModelService};
use App\DataTables\Dashboard\Admin\Scooter\ScooterModelDataTable;

class ScooterModelController extends Controller
{
    public function __construct(protected ScooterModelDataTable $dataTable, protected ScooterModelService $scooterModelService) {
        $this->dataTable = $dataTable;
        $this->scooterModelService = $scooterModelService;
    }
    
    public function index() {
        $data = [
            'title' => 'Scooter-Model',
            'scooter_makes' => ScooterMake::active(),
        ];
        return $this->dataTable->render('dashboard.admin.scooter.scooterModel.index',  compact('data'));
    }

    public function store(Request $request) {
        try {
            $requestData = $request->all();
            $this->scooterModelService->create($requestData);
            return redirect()->route('scooterModel.index')->with('success', 'scooter model created successfully');
        } catch (\Exception $e) {
            return redirect()->route('scooterModel.index')->with('error', 'An error occurred while creating the scooter model');
        }
    }

    public function update(Request $request, $scooterModelId) {
        try {
            $requestData = $request->all();
            $this->scooterModelService->update($scooterModelId, $requestData);
            return redirect()->route('scooterModel.index')->with('success', 'scooter model updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('scooterModel.index')->with('error', 'An error occurred while updating the scooter model');
        }
    }

    public function updateStatus(Request $request, $scooterModelId) {
        try {
            $this->scooterModelService->updateStatus($scooterModelId, $request->status);
            return redirect()->route('scooterModel.index')->with('success', 'scooter model status updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('scooterModel.index')->with('error', 'An error occurred while updating the scooter model');
        }
    }

    public function destroy($id) {  
        try {
            $this->scooterModelService->delete($id);
            return redirect()->route('scooterModel.index')->with('success', 'scooter model deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('scooterModel.index')->with('error', 'An error occurred while deleting the scooter model');
        }
    }
}