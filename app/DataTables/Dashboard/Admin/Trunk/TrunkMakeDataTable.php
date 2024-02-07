<?php
namespace App\DataTables\Dashboard\Admin\Trunk;
use App\Models\TrunkMake;
use App\DataTables\Base\BaseDataTable;
use Yajra\DataTables\EloquentDataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class TrunkMakeDataTable extends BaseDataTable {
    public function __construct(DataTableRequest $request) {
        parent::__construct(new TrunkMake());
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (TrunkMake $trunkMake) {
                return view('dashboard.admin.trunk.trunkMake.btn.actions', compact('trunkMake'));
            })
            ->editColumn('created_at', function (TrunkMake $trunkMake) {
                return $this->formatBadge($this->formatDate($trunkMake->created_at));
            })
            ->editColumn('updated_at', function (TrunkMake $trunkMake) {
                return $this->formatBadge($this->formatDate($trunkMake->updated_at));
            })
            ->editColumn('status', function (TrunkMake $trunkMake) {
                return $trunkMake->status();
            })
            ->rawColumns(['action', 'created_at', 'updated_at','status']); 
    }

    public function query(): QueryBuilder {
        return TrunkMake::latest();
    }

    public function getColumns(): array {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false,],
            ['name' => 'name', 'data' => 'name', 'title' => 'Name',],
            ['name' => 'status', 'data' => 'status', 'title' => 'Status',],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => 'Created_at', 'orderable' => false, 'searchable' => false,],
            ['name' => 'updated_at', 'data' => 'updated_at', 'title' => 'Update_at', 'orderable' => false, 'searchable' => false,],
            ['name' => 'action', 'data' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false,],
        ];
    }
}