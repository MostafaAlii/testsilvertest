<?php
namespace App\DataTables\Dashboard\Admin\Captain;
use App\Models\CaptionBonus;
use App\DataTables\Base\BaseDataTable;
use Yajra\DataTables\EloquentDataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Utilities\Request as DataTableRequest;
class CaptainBounesDataTable extends BaseDataTable {
    public function __construct(DataTableRequest $request) {
        parent::__construct(new CaptionBonus());
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (CaptionBonus $bonus) {
                return view('dashboard.admin.captains.bouns.btn.actions', compact('bonus'));
            })
            ->editColumn('created_at', function (CaptionBonus $bonus) {
                return $this->formatBadge($this->formatDate($bonus->created_at));
            })
            ->editColumn('updated_at', function (CaptionBonus $bonus) {
                return $this->formatBadge($this->formatDate($bonus->updated_at));
            })
            ->editColumn('status', function (CaptionBonus $bonus) {
                return $this->formatStatus($bonus->status);
            })
            ->editColumn('captain_id', function (CaptionBonus $bonus) {
                return '<a href="'.route('captains.show', $bonus->captain->profile->uuid).'">'. optional($bonus->captain)->name .'</a>';
            })
            ->rawColumns(['created_at', 'updated_at','status', 'captain_id', 'action']);
    }

    public function query(): QueryBuilder {
        return CaptionBonus::query()->with(['captain']);
    }

    public function getColumns(): array {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false,],
            ['name' => 'captain_id', 'data' => 'captain_id', 'title' => 'Captain',],
            ['name' => 'bout', 'data' => 'bout', 'title' => 'Bounes',],
            ['name' => 'status', 'data' => 'status', 'title' => 'Status',],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => 'Created_at', 'orderable' => false, 'searchable' => false,],
            ['name' => 'updated_at', 'data' => 'updated_at', 'title' => 'Update_at', 'orderable' => false, 'searchable' => false,],
            ['name' => 'action', 'data' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false,],
        ];
    }
}
