<?php
namespace App\Http\Controllers\Dashboard\Admin\Captains;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\Dashboard\Admin\Captain\{CaptainBounesDataTable};
use App\Models\{Captain, CaptionBonus};
use Illuminate\Support\Facades\DB;
use App\Services\Dashboard\{Admins\BounesService};

class BounesController extends Controller {

    public function __construct(protected CaptainBounesDataTable $dataTable, protected BounesService $bounesService) {
        $this->dataTable = $dataTable;
        $this->bounesService = $bounesService;
    }

    public function index() {
        $data = [
            'title' => 'Captions Bounes',
            'captains' => Captain::active(),
        ];
        return $this->dataTable->render('dashboard.admin.captains.bouns.index', compact('data'));
    }

    public function store(Request $request) {
        $listBounes = $request->listBounes;
        try {
            DB::beginTransaction();
            foreach ($listBounes as $bounes) {
                $bouneses = new CaptionBonus();
                $bouneses->bout = $bounes['bout'];
                $bouneses->captain_id = $bounes['captain_id'];
                $bouneses->status = $bounes['status'];
                $bouneses->save();
            }
            DB::commit();
            return redirect()->route('captain-bouns.index')->with('success', 'bouns created successfully');
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('captain-bouns.index')->with('error', 'An error occurred while creating the bouns');
        }
    }

    public function destroy($id) {  
        try {
            $this->bounesService->delete($id);
            return redirect()->route('captain-bouns.index')->with('success', 'bouns deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('captain-bouns.index')->with('error', 'An error occurred while deleting the bouns');
        }
    }
}
