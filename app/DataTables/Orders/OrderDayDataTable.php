<?php

namespace App\DataTables\Orders;

use App\DataTables\Base\BaseDataTable;
use App\Models\OrderDay;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class OrderDayDataTable extends BaseDataTable {
    public function __construct(DataTableRequest $request) {
        parent::__construct(new OrderDay());
        $this->request = $request;
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (OrderDay $order) {
                return view('dashboard.admin.orders.orderDay.btn.actions', compact('order'));
            })
            ->editColumn('client_name', function (OrderDay $order) {
                return $order?->user?->name;
            })
            ->editColumn('captain_name', function (OrderDay $order) {
                return $order?->captain?->name;
            })
            ->editColumn('trip_type_id', function (OrderDay $order) {
                return $order?->trip_type?->name;
            })
            ->editColumn('car_type_day_id', function (OrderDay $order) {
                return $order?->car_type_day?->name;
            })
            ->rawColumns(['action','client_name', 'captain_name', 'trip_type_id', 'car_type_day_id']);
    }

    public function query(): QueryBuilder {
        return OrderDay::query()->latest();
    }

    public function getColumns(): array {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false,],
            ['name' => 'client_name', 'data' => 'client_name', 'title' => 'User-name', 'searchable' => false,],
            ['name' => 'captain_name', 'data' => 'captain_name', 'title' => 'Captain-name', 'searchable' => false,],
            ['name' => 'trip_type_id', 'data' => 'trip_type_id', 'title' => 'Trip-name', 'searchable' => false,],
            ['name' => 'car_type_day_id', 'data' => 'car_type_day_id', 'title' => 'Car-Type', 'searchable' => false,],
            ['name' => 'order_code', 'data' => 'order_code', 'title' => 'code'],
            ['name' => 'total_price', 'data' => 'total_price', 'title' => 'total price'],
            ['name' => 'status', 'data' => 'status', 'title' => 'Status'],
            ['name' => 'payments', 'data' => 'payments', 'title' => 'Payment'],
            ['name' => 'status_price', 'data' => 'status_price', 'title' => 'Price Status'],
            ['name' => 'type_duration', 'data' => 'type_duration', 'title' => 'Type Duration'],
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
        return 'OrderDay_' . date('YmdHis');
    }
}
