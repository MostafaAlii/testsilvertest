<?php
namespace App\DataTables\Dashboard\Admin\Trunk;
use App\Models\TrunkModel;
use App\DataTables\Base\BaseDataTable;
use Yajra\DataTables\EloquentDataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class TrunkModelDataTable extends BaseDataTable {
    public function __construct(DataTableRequest $request) {
        parent::__construct(new TrunkModel());
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (TrunkModel $trunkModel) {
                return view('dashboard.admin.trunk.trunkModel.btn.actions', compact('trunkModel'));
            })
            ->editColumn('created_at', function (TrunkModel $trunkModel) {
                return $this->formatBadge($this->formatDate($trunkModel->created_at));
            })
            ->editColumn('updated_at', function (TrunkModel $trunkModel) {
                return $this->formatBadge($this->formatDate($trunkModel->updated_at));
            })
            ->editColumn('status', function (TrunkModel $trunkModel) {
                return $trunkModel->status();
            })
            ->editColumn('trunk_make_id', function (TrunkModel $trunkModel) {
                return $trunkModel->trunk_make->name;
            })
            ->rawColumns(['action', 'created_at', 'updated_at','status', 'trunk_make_id']);
    }

    public function query(): QueryBuilder {
        return TrunkModel::latest();
    }

    public function getColumns(): array {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false,],
            ['name' => 'name', 'data' => 'name', 'title' => 'Name',],
            ['name' => 'status', 'data' => 'status', 'title' => 'Status', 'orderable' => false, 'searchable' => false,],
            ['name' => 'trunk_make_id', 'data' => 'trunk_make_id', 'title' => 'Truck Make' , 'orderable' => false, 'searchable' => false,],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => 'Created_at', 'orderable' => false, 'searchable' => false,],
            ['name' => 'updated_at', 'data' => 'updated_at', 'title' => 'Update_at', 'orderable' => false, 'searchable' => false,],
            ['name' => 'action', 'data' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false,],
        ];
    }
}