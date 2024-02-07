<?php
namespace App\DataTables\Dashboard\Admin;
use App\Models\Callcenter;
use App\DataTables\Base\BaseDataTable;
use Yajra\DataTables\EloquentDataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class CallCenterDataTable extends BaseDataTable {
    public function __construct(DataTableRequest $request) {
        parent::__construct(new Callcenter());
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (Callcenter $callCenter) {
                return view('dashboard.admin.call-centers.btn.actions', compact('callCenter'));
            })
            ->editColumn('created_at', function (Callcenter $callCenter) {
                return $this->formatBadge($this->formatDate($callCenter->created_at));
            })
            ->editColumn('updated_at', function (Callcenter $callCenter) {
                return $this->formatBadge($this->formatDate($callCenter->updated_at));
            })
            ->editColumn('name', function (Callcenter $callCenter) {
                return '<a href="' . route('callCenters.show', $callCenter?->profile?->uuid) . '">' . $callCenter->name . '</a>' ?? null;
            })
            ->editColumn('status', function (Callcenter $callCenter) {
                return $this->formatStatus($callCenter->status);
            })
            ->editColumn('country_id', function (Callcenter $callCenter) {
                return $callCenter->country->name;
            })
            ->rawColumns(['action', 'created_at', 'updated_at','status', 'name', 'country_id']);
    }

    public function query(): QueryBuilder {
        return Callcenter::query()->with(['profile'])->latest();
    }

    public function getColumns(): array {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false,],
            ['name' => 'name', 'data' => 'name', 'title' => 'Name',],
            ['name' => 'email', 'data' => 'email', 'title' => 'Email',],
            ['name' => 'phone', 'data' => 'phone', 'title' => 'Phone',],
            ['name' => 'country_id', 'data' => 'country_id', 'title' => 'Country',],
            ['name' => 'type', 'data' => 'type', 'title' => 'Type',],
            ['name' => 'status', 'data' => 'status', 'title' => 'Status',],
            ['name' => 'last_seen', 'data' => 'last_seen', 'title' => 'Last Seen', 'orderable' => false, 'searchable' => false,],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => 'Created_at', 'orderable' => false, 'searchable' => false,],
            ['name' => 'updated_at', 'data' => 'updated_at', 'title' => 'Update_at', 'orderable' => false, 'searchable' => false,],
            ['name' => 'action', 'data' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false,],
        ];
    }
}
