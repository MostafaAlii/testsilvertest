<?php
namespace App\DataTables\Dashboard\Admin\Scooter;
use App\Models\ScooterMake;
use App\DataTables\Base\BaseDataTable;
use Yajra\DataTables\EloquentDataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class ScooterMakeDataTable extends BaseDataTable {
    public function __construct(DataTableRequest $request) {
        parent::__construct(new ScooterMake());
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (ScooterMake $scooterMake) {
                return view('dashboard.admin.scooter.scooterMake.btn.actions', compact('scooterMake'));
            })
            ->editColumn('created_at', function (ScooterMake $scooterMake) {
                return $this->formatBadge($this->formatDate($scooterMake->created_at));
            })
            ->editColumn('updated_at', function (ScooterMake $scooterMake) {
                return $this->formatBadge($this->formatDate($scooterMake->updated_at));
            })
            ->editColumn('status', function (ScooterMake $scooterMake) {
                return $scooterMake->status();
            })
            ->rawColumns(['action', 'created_at', 'updated_at','status']); 
    }

    public function query(): QueryBuilder {
        return ScooterMake::latest();
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