<?php

namespace App\Http\Controllers\Dashboard\Admin\Tricycle;
use App\Models\TricycleMake;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Dashboard\{Admins\Tricycle\TricycleModelService};
use App\DataTables\Dashboard\Admin\Tricycle\TricycleModelDataTable;

class TricycleModelController extends Controller
{
    public function __construct(protected TricycleModelDataTable $dataTable, protected TricycleModelService $tricycleModelService) {
        $this->dataTable = $dataTable;
        $this->tricycleModelService = $tricycleModelService;
    }
    
    public function index() {
        $data = [
            'title' => 'Tricycle-Model',
            'tricycle_makes' => TricycleMake::active(),
        ];
        return $this->dataTable->render('dashboard.admin.tricycle.tricycleModel.index',  compact('data'));
    }

    public function store(Request $request) {
        try {
            $requestData = $request->all();
            $this->tricycleModelService->create($requestData);
            return redirect()->route('tricycleModel.index')->with('success', 'tricycle model created successfully');
        } catch (\Exception $e) {
            return redirect()->route('tricycleModel.index')->with('error', 'An error occurred while creating the tricycle model');
        }
    }

    public function update(Request $request, $tricycleModelId) {
        try {
            $requestData = $request->all();
            $this->tricycleModelService->update($tricycleModelId, $requestData);
            return redirect()->route('tricycleModel.index')->with('success', 'tricycle model updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('tricycleModel.index')->with('error', 'An error occurred while updating the tricycle model');
        }
    }

    public function updateStatus(Request $request, $tricycleModelId) {
        try {
            $this->tricycleModelService->updateStatus($tricycleModelId, $request->status);
            return redirect()->route('tricycleModel.index')->with('success', 'tricycle model status updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('tricycleModel.index')->with('error', 'An error occurred while updating the tricycle model');
        }
    }

    public function destroy($id) {  
        try {
            $this->tricycleModelService->delete($id);
            return redirect()->route('tricycleModel.index')->with('success', 'tricycle model deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('tricycleModel.index')->with('error', 'An error occurred while deleting the tricycle model');
        }
    }
}