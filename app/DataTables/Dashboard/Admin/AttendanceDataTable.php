<?php
namespace App\DataTables\Dashboard\Admin;
use App\Models\Attendance;
use App\DataTables\Base\BaseDataTable;
use Yajra\DataTables\EloquentDataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class AttendanceDataTable extends BaseDataTable {
    public function __construct(DataTableRequest $request) {
        parent::__construct(new Attendance());
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->editColumn('created_at', function (Attendance $attendance) {
                return $this->formatBadge($this->formatDate($attendance->created_at));
            })
            ->editColumn('updated_at', function (Attendance $attendance) {
                return $this->formatBadge($this->formatDate($attendance->updated_at));
            })
            ->editColumn('call_center_id', function (Attendance $attendance) {
                return '<a href="'.route('callCenters.show', $attendance->callCenter->profile->uuid).'">'. $attendance->callCenter->name.'</a>';
            })
            ->rawColumns(['action', 'created_at', 'updated_at', 'call_center_id',]);
    }

    public function query(): QueryBuilder {
        return Attendance::query()->with(['callCenter.profile']);
    }

    public function getColumns(): array {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false,],
            ['name' => 'call_center_id', 'data' => 'call_center_id', 'title' => 'Call-Center',],
            ['name' => 'day', 'data' => 'day', 'title' => 'Day',],
            ['name' => 'login', 'data' => 'login', 'title' => 'Login',],
            ['name' => 'logout', 'data' => 'logout', 'title' => 'Logout',],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => 'Created_at', 'orderable' => false, 'searchable' => false,],
            ['name' => 'updated_at', 'data' => 'updated_at', 'title' => 'Update_at', 'orderable' => false, 'searchable' => false,],
        ];
    }
}