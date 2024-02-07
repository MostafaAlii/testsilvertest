<?php
namespace App\DataTables\Dashboard\Admin\CMS;
use App\Models\Cms\CmsService;
use App\DataTables\Base\BaseDataTable;
use Yajra\DataTables\EloquentDataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Utilities\Request as DataTableRequest;
class ServiceDataTable extends BaseDataTable {
    public function __construct(DataTableRequest $request) {
        parent::__construct(new CmsService());
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (CmsService $service) {
                return view('dashboard.admin.cms.services.btn.actions', compact('service'));
            })
            ->editColumn('created_at', function (CmsService $service) {
                return $this->formatBadge($this->formatDate($service->created_at));
            })
            ->editColumn('updated_at', function (CmsService $service) {
                return $this->formatBadge($this->formatDate($service->updated_at));
            })
            ->editColumn('status', function (CmsService $service) {
                return $service->status();
            })
            ->rawColumns(['action', 'created_at', 'updated_at','status']); 
    }

    public function query(): QueryBuilder {
        return CmsService::latest();
    }

    public function getColumns(): array {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false,],
            ['name' => 'title', 'data' => 'title', 'title' => 'Title',],
            ['name' => 'body', 'data' => 'body', 'title' => 'Body',],
            ['name' => 'status', 'data' => 'status', 'title' => 'Status', 'orderable' => false, 'searchable' => false,],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => 'Created_at', 'orderable' => false, 'searchable' => false,],
            ['name' => 'updated_at', 'data' => 'updated_at', 'title' => 'Update_at', 'orderable' => false, 'searchable' => false,],
            ['name' => 'action', 'data' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false,],
        ];
    }
}