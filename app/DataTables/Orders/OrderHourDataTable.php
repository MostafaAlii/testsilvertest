<?php

namespace App\DataTables\Orders;

use App\DataTables\Base\BaseDataTable;
use App\Models\OrderHour;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class OrderHourDataTable extends BaseDataTable {
    public function __construct(DataTableRequest $request) {
        parent::__construct(new OrderHour());
        $this->request = $request;
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (OrderHour $order) {
                return view('dashboard.admin.orders.orderHour.btn.actions', compact('order'));
            })
            ->editColumn('client_name', function (OrderHour $order) {
                return $order?->user?->name;
            })
            ->editColumn('captain_name', function (OrderHour $order) {
                return $order?->captain?->name;
            })
            ->editColumn('trip_type_id', function (OrderHour $order) {
                return $order?->trip_type?->name;
            })
            ->editColumn('hour_id', function (OrderHour $order) {
                return $order?->hour?->number_hours;
            })
            ->editColumn('car_type_id', function (OrderHour $order) {
                return $order?->carType?->name;
            })
            ->rawColumns(['action','client_name', 'captain_name', 'trip_type_id', 'hour_id', 'car_type_id']);
    }

    public function query(): QueryBuilder {
        return OrderHour::query()->latest();
    }

    public function getColumns(): array {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false,],
            ['name' => 'client_name', 'data' => 'client_name', 'title' => 'User-name', 'searchable' => false,],
            ['name' => 'captain_name', 'data' => 'captain_name', 'title' => 'Captain-name', 'searchable' => false,],
            ['name' => 'trip_type_id', 'data' => 'trip_type_id', 'title' => 'Trip-name', 'searchable' => false,],
            ['name' => 'car_type_id', 'data' => 'car_type_id', 'title' => 'Car-Type', 'searchable' => false,],
            ['name' => 'hour_id', 'data' => 'hour_id', 'title' => 'Hour', 'searchable' => false,],
            ['name' => 'order_code', 'data' => 'order_code', 'title' => 'code'],
            ['name' => 'total_price', 'data' => 'total_price', 'title' => 'total price'],
            ['name' => 'status', 'data' => 'status', 'title' => 'Status'],
            ['name' => 'payments', 'data' => 'payments', 'title' => 'Payment'],
            ['name' => 'status_price', 'data' => 'status_price', 'title' => 'Price Status'],
            ['name' => 'type_duration', 'data' => 'type_duration', 'title' => 'Type Duration'],
            ['name' => 'data', 'data' => 'data', 'title' => 'Date' , 'searchable' => false,],
            ['name' => 'action', 'data' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false,],
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'OrderHour_' . date('YmdHis');
    }
}
