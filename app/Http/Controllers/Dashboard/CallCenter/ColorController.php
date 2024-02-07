<?php

namespace App\Http\Controllers\Dashboard\CallCenter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\Dashboard\CallCenter\ColorDataTable;
use App\Services\Dashboard\{CallCenter\ColorService};
use App\Models\{Color};
use Illuminate\Support\Facades\DB;

class ColorController extends Controller {
    public function __construct(protected ColorDataTable $dataTable, protected ColorService $colorService) {
        $this->dataTable = $dataTable;
        $this->colorService = $colorService;
    }

    public function index() {
        $data = ['title' => 'Colors',];
        return $this->dataTable->render('dashboard.call-center.colors.index', compact('data'));
    }

    public function store(Request $request) {
        try {
            $requestData = $request->all();
            $this->colorService->create($requestData);
            return redirect()->route('Colors.index')->with('success', 'Color created successfully');
        } catch (\Exception $e) {
            return redirect()->route('Colors.index')->with('error', 'An error occurred while creating the Color');
        }
    }

    public function update(Request $request, $colorId) {
        try {
            $requestData = $request->all();
            $this->colorService->update($colorId, $requestData);
            return redirect()->route('Colors.index')->with('success', 'color updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('Colors.index')->with('error', 'An error occurred while updating the color');
        }
    }

    public function destroy($id) {  
        try {
            $this->colorService->delete($id);
            return redirect()->route('Colors.index')->with('success', 'color deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('Colors.index')->with('error', 'An error occurred while deleting the color');
        }
    }
}
