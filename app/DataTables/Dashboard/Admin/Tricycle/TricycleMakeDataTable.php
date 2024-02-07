<?php
namespace App\DataTables\Dashboard\Admin\Tricycle;
use App\Models\TricycleMake;
use App\DataTables\Base\BaseDataTable;
use Yajra\DataTables\EloquentDataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class TricycleMakeDataTable extends BaseDataTable {
    public function __construct(DataTableRequest $request) {
        parent::__construct(new TricycleMake());
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (TricycleMake $tricycleMake) {
                return view('dashboard.admin.tricycle.tricycleMake.btn.actions', compact('tricycleMake'));
            })
            ->editColumn('created_at', function (TricycleMake $tricycleMake) {
                return $this->formatBadge($this->formatDate($tricycleMake->created_at));
            })
            ->editColumn('updated_at', function (TricycleMake $tricycleMake) {
                return $this->formatBadge($this->formatDate($tricycleMake->updated_at));
            })
            ->editColumn('status', function (TricycleMake $tricycleMake) {
                return $tricycleMake->status();
            })
            ->rawColumns(['action', 'created_at', 'updated_at','status']); 
    }

    public function query(): QueryBuilder {
        return TricycleMake::latest();
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