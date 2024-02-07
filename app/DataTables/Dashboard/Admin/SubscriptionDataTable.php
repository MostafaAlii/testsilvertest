<?php
namespace App\DataTables\Dashboard\Admin;
use App\Models\SubscriptionCaption;
use App\DataTables\Base\BaseDataTable;
use Yajra\DataTables\EloquentDataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class SubscriptionDataTable extends BaseDataTable {
    public function __construct(DataTableRequest $request) {
        parent::__construct(new SubscriptionCaption());
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (SubscriptionCaption $subscription) {
                return view('dashboard.admin.subscriptions.btn.actions', compact('subscription'));
            })
            ->editColumn('created_at', function (SubscriptionCaption $subscription) {
                return $this->formatBadge($this->formatDate($subscription->created_at));
            })
            ->editColumn('updated_at', function (SubscriptionCaption $subscription) {
                return $this->formatBadge($this->formatDate($subscription->updated_at));
            })
            ->rawColumns(['action', 'created_at', 'updated_at']); 
    }

    public function query(): QueryBuilder {
        return SubscriptionCaption::latest();
    }

    public function getColumns(): array {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false,],
            ['name' => 'name_ar', 'data' => 'name_ar', 'title' => 'Name Ar',],
            ['name' => 'name_en', 'data' => 'name_en', 'title' => 'Name En',],
            ['name' => 'price', 'data' => 'price', 'title' => 'Price',],
            ['name' => 'type', 'data' => 'type', 'title' => 'Type',],
            ['name' => 'notes_ar', 'data' => 'notes_ar', 'title' => 'Note Ar',],
            ['name' => 'notes_en', 'data' => 'notes_en', 'title' => 'Note En',],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => 'Created_at', 'orderable' => false, 'searchable' => false,],
            ['name' => 'updated_at', 'data' => 'updated_at', 'title' => 'Update_at', 'orderable' => false, 'searchable' => false,],
            ['name' => 'action', 'data' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false,],
        ];
    }
}