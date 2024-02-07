<?php
namespace App\DataTables\Dashboard\Admin\Scooter;
use App\Models\ScooterModel;
use App\DataTables\Base\BaseDataTable;
use Yajra\DataTables\EloquentDataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class ScooterModelDataTable extends BaseDataTable {
    public function __construct(DataTableRequest $request) {
        parent::__construct(new ScooterModel());
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (ScooterModel $scooterModel) {
                return view('dashboard.admin.scooter.scooterModel.btn.actions', compact('scooterModel'));
            })
            ->editColumn('created_at', function (ScooterModel $scooterModel) {
                return $this->formatBadge($this->formatDate($scooterModel->created_at));
            })
            ->editColumn('updated_at', function (ScooterModel $scooterModel) {
                return $this->formatBadge($this->formatDate($scooterModel->updated_at));
            })
            ->editColumn('status', function (ScooterModel $scooterModel) {
                return $scooterModel->status();
            })
            ->editColumn('scooter_make_id', function (ScooterModel $scooterModel) {
                return $scooterModel->scooter_make->name;
            })
            ->rawColumns(['action', 'created_at', 'updated_at','status', 'scooter_make_id']);
    }

    public function query(): QueryBuilder {
        return ScooterModel::latest();
    }

    public function getColumns(): array {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false,],
            ['name' => 'name', 'data' => 'name', 'title' => 'Name',],
            ['name' => 'status', 'data' => 'status', 'title' => 'Status',],
            ['name' => 'scooter_make_id', 'data' => 'scooter_make_id', 'title' => 'Scooter Make',],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => 'Created_at', 'orderable' => false, 'searchable' => false,],
            ['name' => 'updated_at', 'data' => 'updated_at', 'title' => 'Update_at', 'orderable' => false, 'searchable' => false,],
            ['name' => 'action', 'data' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false,],
        ];
    }
}