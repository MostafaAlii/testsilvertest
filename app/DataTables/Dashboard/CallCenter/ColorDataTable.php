<?php
namespace App\DataTables\Dashboard\CallCenter;
use App\Models\Color;
use App\DataTables\Base\BaseDataTable;
use Yajra\DataTables\EloquentDataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Utilities\Request as DataTableRequest;
class ColorDataTable extends BaseDataTable {
    public function __construct(DataTableRequest $request) {
        parent::__construct(new Color());
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable {
        return (new EloquentDataTable($query))
        ->addColumn('action', function (Color $color) {
            return view('dashboard.call-center.colors.btn.actions', compact('color'));
        })
            ->editColumn('created_at', function (Color $color) {
                return $color->created_at;
            })
            ->editColumn('updated_at', function (Color $color) {
                return $color->updated_at;
            })
            ->rawColumns(['action', 'created_at', 'updated_at']);
    }

    public function query() {
        return Color::query()->latest();
    }

    public function getColumns(): array {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false,],
            ['name' => 'name', 'data' => 'name', 'title' => 'Name',],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => 'Created_at', 'orderable' => false, 'searchable' => false,],
            ['name' => 'updated_at', 'data' => 'updated_at', 'title' => 'Update_at', 'orderable' => false, 'searchable' => false,],
            ['name' => 'action', 'data' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false,],
        ];
    }
}