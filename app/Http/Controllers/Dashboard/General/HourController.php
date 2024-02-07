<?php

namespace App\Http\Controllers\Dashboard\General;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Dashboard\{General\HourService};
use App\DataTables\Dashboard\General\HourDataTable;
class HourController extends Controller
{
    public function __construct(protected HourDataTable $dataTable, protected HourService $hourService) {
        $this->dataTable = $dataTable;
        $this->hourService = $hourService;
    }
    
    public function index() {
        return $this->dataTable->render('dashboard.general.hours.index',  ['title' => 'Hours']);
    }

    public function store(Request $request) {
        try {
            $validatedData = $request->all();
            $this->hourService->create($validatedData);
            return redirect()->route('hours.index')->with('success', 'hour created successfully');
        } catch (\Exception $e) {
            return redirect()->route('hours.index')->with('error', 'An error occurred while creating the hour');
        }
    }

    public function update(Request $request, $hourId) {
        try {
            $requestData = $request->all();
            $this->hourService->update($hourId, $requestData);
            return redirect()->route('hours.index')->with('success', 'hour updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('hours.index')->with('error', 'An error occurred while updating the hour');
        }
    }

    public function destroy($id) {  
        try {
            $this->hourService->delete($id);
            return redirect()->route('hours.index')->with('success', 'hour deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('hours.index')->with('error', 'An error occurred while deleting the hour');
        }
    }
}
