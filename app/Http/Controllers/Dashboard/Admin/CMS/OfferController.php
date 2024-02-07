<?php
namespace App\Http\Controllers\Dashboard\Admin\CMS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Dashboard\Admins\CMS\OfferService;
use App\DataTables\Dashboard\Admin\CMS\OfferDataTable;

class OfferController extends Controller {
    public function __construct(protected OfferDataTable $dataTable, protected OfferService $offerService) {
        $this->dataTable = $dataTable;
        $this->offerService = $offerService;
    }
    public function index() {
        return $this->dataTable->render('dashboard.admin.cms.offers.index', ['title' => 'Offers']);
    }

    public function store(Request $request) {
        try {
            $requestData = $request->all();
            $this->offerService->create($requestData);
            return redirect()->route('offer.index')->with('success', 'offer created successfully');
        } catch (\Exception $e) {
            return redirect()->route('offer.index')->with('error', 'An error occurred while creating the offer');
        }
    }

    public function update(Request $request, $offerId) {
        try {
            $requestData = $request->all();
            $this->offerService->update($offerId, $requestData);
            return redirect()->route('offer.index')->with('success', 'offer updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('offer.index')->with('error', 'An error occurred while updating the offer');
        }
    }

    public function destroy($id) {  
        try {
            $this->offerService->delete($id);
            return redirect()->route('offer.index')->with('success', 'offer deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('offer.index')->with('error', 'An error occurred while deleting the offer');
        }
    }
}