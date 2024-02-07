<?php
namespace App\Http\Controllers\Dashboard\Admin\CMS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Dashboard\Admins\CMS\ServiceService;
use App\DataTables\Dashboard\Admin\CMS\ServiceDataTable;

class ServiceController extends Controller {
    public function __construct(protected ServiceDataTable $dataTable, protected ServiceService $serviceService) {
        $this->dataTable = $dataTable;
        $this->serviceService = $serviceService;
    }
    public function index() {
        return $this->dataTable->render('dashboard.admin.cms.services.index', ['title' => 'Services']);
    }

    public function store(Request $request) {
        try {
            $requestData = $request->all();
            $this->serviceService->create($requestData);
            return redirect()->route('service.index')->with('success', 'Service created successfully');
        } catch (\Exception $e) {
            return redirect()->route('service.index')->with('error', 'An error occurred while creating the Service');
        }
    }

    public function update(Request $request, $serviceId) {
        try {
            $requestData = $request->all();
            $this->serviceService->update($serviceId, $requestData);
            return redirect()->route('service.index')->with('success', 'service updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('service.index')->with('error', 'An error occurred while updating the service');
        }
    }

    public function destroy($id) {  
        try {
            $this->serviceService->delete($id);
            return redirect()->route('service.index')->with('success', 'service deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('service.index')->with('error', 'An error occurred while deleting the service');
        }
    }
}