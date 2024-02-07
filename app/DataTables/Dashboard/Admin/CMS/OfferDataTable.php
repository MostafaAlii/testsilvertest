<?php
namespace App\DataTables\Dashboard\Admin\CMS;
use App\Models\Cms\CmsOffer;
use App\DataTables\Base\BaseDataTable;
use Yajra\DataTables\EloquentDataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Utilities\Request as DataTableRequest;
class OfferDataTable extends BaseDataTable {
    public function __construct(DataTableRequest $request) {
        parent::__construct(new CmsOffer());
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (CmsOffer $offer) {
                return view('dashboard.admin.cms.offers.btn.actions', compact('offer'));
            })
            ->editColumn('created_at', function (CmsOffer $offer) {
                return $this->formatBadge($this->formatDate($offer->created_at));
            })
            ->editColumn('updated_at', function (CmsOffer $offer) {
                return $this->formatBadge($this->formatDate($offer->updated_at));
            })
            ->editColumn('status', function (CmsOffer $offer) {
                return $offer->status();
            })
            ->rawColumns(['action', 'created_at', 'updated_at','status']); 
    }

    public function query(): QueryBuilder {
        return CmsOffer::latest();
    }

    public function getColumns(): array {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false,],
            ['name' => 'title', 'data' => 'title', 'title' => 'Title',],
            ['name' => 'plan_type', 'data' => 'plan_type', 'title' => 'Plan',],
            ['name' => 'price', 'data' => 'price', 'title' => 'Price',],
            ['name' => 'status', 'data' => 'status', 'title' => 'Status', 'orderable' => false, 'searchable' => false,],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => 'Created_at', 'orderable' => false, 'searchable' => false,],
            ['name' => 'updated_at', 'data' => 'updated_at', 'title' => 'Update_at', 'orderable' => false, 'searchable' => false,],
            ['name' => 'action', 'data' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false,],
        ];
    }
}