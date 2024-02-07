<?php
namespace App\DataTables\Dashboard\Admin\Tricycle;
use App\Models\TricycleModel;
use App\DataTables\Base\BaseDataTable;
use Yajra\DataTables\EloquentDataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class TricycleModelDataTable extends BaseDataTable {
    public function __construct(DataTableRequest $request) {
        parent::__construct(new TricycleModel());
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (TricycleModel $tricycleModel) {
                return view('dashboard.admin.tricycle.tricycleModel.btn.actions', compact('tricycleModel'));
            })
            ->editColumn('created_at', function (TricycleModel $tricycleModel) {
                return $this->formatBadge($this->formatDate($tricycleModel->created_at));
            })
            ->editColumn('updated_at', function (TricycleModel $tricycleModel) {
                return $this->formatBadge($this->formatDate($tricycleModel->updated_at));
            })
            ->editColumn('status', function (TricycleModel $tricycleModel) {
                return $tricycleModel->status();
            })
            ->editColumn('tricycle_make_id', function (TricycleModel $tricycleModel) {
                return $tricycleModel->tricycle_make->name;
            })
            ->rawColumns(['action', 'created_at', 'updated_at','status', 'tricycle_make_id']);
    }

    public function query(): QueryBuilder {
        return TricycleModel::latest();
    }

    public function getColumns(): array {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false,],
            ['name' => 'name', 'data' => 'name', 'title' => 'Name',],
            ['name' => 'status', 'data' => 'status', 'title' => 'Status', 'orderable' => false, 'searchable' => false,],
            ['name' => 'tricycle_make_id', 'data' => 'tricycle_make_id', 'title' => 'Tricycle Make' , 'orderable' => false, 'searchable' => false,],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => 'Created_at', 'orderable' => false, 'searchable' => false,],
            ['name' => 'updated_at', 'data' => 'updated_at', 'title' => 'Update_at', 'orderable' => false, 'searchable' => false,],
            ['name' => 'action', 'data' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false,],
        ];
    }
}