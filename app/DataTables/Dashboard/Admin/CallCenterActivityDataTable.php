<?php
namespace App\DataTables\Dashboard\Admin;
use App\Models\ImagesActivity;
use App\DataTables\Base\BaseDataTable;
use Yajra\DataTables\EloquentDataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class CallCenterActivityDataTable extends BaseDataTable {
    public function __construct(DataTableRequest $request) {
        parent::__construct(new ImagesActivity());
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->editColumn('created_at', function (ImagesActivity $activity) {
                return $this->formatBadge($this->formatDate($activity->created_at));
            })
            ->editColumn('updated_at', function (ImagesActivity $activity) {
                return $this->formatBadge($this->formatDate($activity->updated_at));
            })
            ->editColumn('call_center_id', function (ImagesActivity $activity) {
                return $activity->callCenter->name;
                //return $activity->callCenter->profile->uuid;
            })
            ->editColumn('photo_type', function (ImagesActivity $activity) {
                return ucwords(str_replace('_', ' ', $activity->photo_type));
            })
            ->editColumn('changed_column', function (ImagesActivity $activity) {
                return ucwords(str_replace('_', ' ', $activity->changed_column));
            })
            ->editColumn('change_value_from', function (ImagesActivity $activity) {
                return ucwords(str_replace('_', ' ', $activity->change_value_from));
            })
            ->editColumn('change_value_to', function (ImagesActivity $activity) {
                return ucwords(str_replace('_', ' ', $activity->change_value_to));
            })
            ->editColumn('image_id', function (ImagesActivity $activity) {
                return $activity->image->captainProfile?->owner->name;
            })
            ->rawColumns(['action', 'created_at', 'updated_at', 'call_center_id', 'photo_type', 'changed_column', 'change_value_from', 'change_value_to', 'image_id']);
    }

    public function query(): QueryBuilder {
        return ImagesActivity::query()->whereNotNull(['change_value_from'])->with(['admin', 'image', 'image.captainProfile', 'callCenter']);
    }

    public function getColumns(): array {
        return [
            ['name' => 'call_center_id', 'data' => 'call_center_id', 'title' => 'Call-Center',],
            ['name' => 'type', 'data' => 'type', 'title' => 'Type',],
            ['name' => 'photo_type', 'data' => 'photo_type', 'title' => 'Photo',],
            ['name' => 'changed_column', 'data' => 'changed_column', 'title' => 'Changed',],
            ['name' => 'change_value_from', 'data' => 'change_value_from', 'title' => 'From',],
            ['name' => 'change_value_to', 'data' => 'change_value_to', 'title' => 'To',],
            ['name' => 'image_id', 'data' => 'image_id', 'title' => 'Captain',],
            
            ['name' => 'created_at', 'data' => 'created_at', 'title' => 'Created_at', 'orderable' => false, 'searchable' => false,],
            ['name' => 'updated_at', 'data' => 'updated_at', 'title' => 'Update_at', 'orderable' => false, 'searchable' => false,],
        ];
    }
}