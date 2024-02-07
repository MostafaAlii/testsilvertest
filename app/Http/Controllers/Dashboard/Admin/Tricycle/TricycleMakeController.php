<?php

namespace App\Http\Controllers\Dashboard\Admin\Tricycle;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Dashboard\{Admins\Tricycle\TricycleMakeService};
use App\DataTables\Dashboard\Admin\Tricycle\TricycleMakeDataTable;
class TricycleMakeController extends Controller{
    public function __construct(protected TricycleMakeDataTable $dataTable, protected TricycleMakeService $tricycleMakeService) {
        $this->dataTable = $dataTable;
        $this->tricycleMakeService = $tricycleMakeService;
    }

    public function index() {
        $data = [
            'title' => 'Tricycle-Make',
        ];
        return $this->dataTable->render('dashboard.admin.tricycle.tricycleMake.index',  compact('data'));
    }

    public function store(Request $request) {
        try {
            $requestData = $request->all();
            $this->tricycleMakeService->create($requestData);
            return redirect()->route('tricycleMake.index')->with('success', 'tricycle make created successfully');
        } catch (\Exception $e) {
            return redirect()->route('tricycleMake.index')->with('error', 'An error occurred while creating the tricycle make');
        }
    }

    public function update(Request $request, $tricycleMakeId) {
        try {
            $requestData = $request->all();
            $this->tricycleMakeService->update($tricycleMakeId, $requestData);
            return redirect()->route('tricycleMake.index')->with('success', 'tricycle make updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('tricycleMake.index')->with('error', 'An error occurred while updating the tricycle');
        }
    }

    public function updateStatus(Request $request, $tricycleMakeId) {
        try {
            $this->tricycleMakeService->updateStatus($tricycleMakeId, $request->status);
            return redirect()->route('tricycleMake.index')->with('success', 'tricycle make status updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('tricycleMake.index')->with('error', 'An error occurred while updating the tricycle make');
        }
    }

    public function destroy($id) {  
        
        try {
            $this->tricycleMakeService->delete($id);
            return redirect()->route('tricycleMake.index')->with('success', 'tricycle make deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('tricycleMake.index')->with('error', 'An error occurred while deleting the tricycle make');
        }
    }
}