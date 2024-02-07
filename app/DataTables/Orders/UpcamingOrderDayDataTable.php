<?php

namespace App\DataTables\Orders;

use App\DataTables\Base\BaseDataTable;
use App\Models\SaveRentDay;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class UpcamingOrderDayDataTable extends BaseDataTable {
    public function __construct(DataTableRequest $request) {
        parent::__construct(new SaveRentDay());
        $this->request = $request;
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (SaveRentDay $order) {
                return view('dashboard.admin.orders.orderDay.upcaming.btn.actions', compact('order'));
            })
            ->editColumn('client_name', function (SaveRentDay $order) {
                return $order?->user?->name;
            })
            ->editColumn('trip_type_id', function (SaveRentDay $order) {
                return $order?->trip_type?->name;
            })
            ->editColumn('car_type_day_id', function (SaveRentDay $order) {
                return $order?->car_type_day?->name;
            })
            ->rawColumns(['action','client_name', 'captain_name', 'trip_type_id', 'car_type_day_id']);
    }

    public function query(): QueryBuilder {
        return SaveRentDay::query()->latest();
    }

    public function getColumns(): array {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false,],
            ['name' => 'client_name', 'data' => 'client_name', 'title' => 'User-name', 'searchable' => false,],
            ['name' => 'trip_type_id', 'data' => 'trip_type_id', 'title' => 'Trip-name', 'searchable' => false,],
            ['name' => 'car_type_day_id', 'data' => 'car_type_day_id', 'title' => 'Car-Type', 'searchable' => false,],
            ['name' => 'order_code', 'data' => 'order_code', 'title' => 'code'],
            ['name' => 'total_price', 'data' => 'total_price', 'title' => 'total price'],
            ['name' => 'status', 'data' => 'status', 'title' => 'Status'],
            ['name' => 'payments', 'data' => 'payments', 'title' => 'Payment'],
            ['name' => 'status_price', 'data' => 'status_price', 'title' => 'Price Status'],
            ['name' => 'number_day', 'data' => 'number_day', 'title' => 'Days'],
            ['name' => 'start_day', 'data' => 'start_day', 'title' => 'Start Day'],
            ['name' => 'end_day', 'data' => 'end_day', 'title' => 'End Day'],
            ['name' => 'action', 'data' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false,],
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'UpcamingOrder_' . date('YmdHis');
    }
}
