<?php

namespace App\Http\Controllers\Dashboard\Admin\Scooter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Dashboard\{Admins\Scooter\ScooterMakeService};
use App\DataTables\Dashboard\Admin\Scooter\ScooterMakeDataTable;
class ScooterMakeController extends Controller{
    public function __construct(protected ScooterMakeDataTable $dataTable, protected ScooterMakeService $scooterMakeService) {
        $this->dataTable = $dataTable;
        $this->scooterMakeService = $scooterMakeService;
    }

    public function index() {
        $data = [
            'title' => 'Scooter-Make',
        ];
        return $this->dataTable->render('dashboard.admin.scooter.scooterMake.index',  compact('data'));
    }

    public function store(Request $request) {
        try {
            $requestData = $request->all();
            $this->scooterMakeService->create($requestData);
            return redirect()->route('scooterMake.index')->with('success', 'scooter make created successfully');
        } catch (\Exception $e) {
            return redirect()->route('scooterMake.index')->with('error', 'An error occurred while creating the scooter make');
        }
    }

    public function update(Request $request, $scooterMakeId) {
        try {
            $requestData = $request->all();
            $this->scooterMakeService->update($scooterMakeId, $requestData);
            return redirect()->route('scooterMake.index')->with('success', 'scooter make updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('scooterMake.index')->with('error', 'An error occurred while updating the scooter');
        }
    }

    public function updateStatus(Request $request, $scooterMakeId) {
        try {
            $this->scooterMakeService->updateStatus($scooterMakeId, $request->status);
            return redirect()->route('scooterMake.index')->with('success', 'scooter make status updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('scooterMake.index')->with('error', 'An error occurred while updating the scooter make');
        }
    }

    public function destroy($id) {  
        try {
            $this->scooterMakeService->delete($id);
            return redirect()->route('scooterMake.index')->with('success', 'scooter make deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('scooterMake.index')->with('error', 'An error occurred while deleting the scooter make');
        }
    }
}