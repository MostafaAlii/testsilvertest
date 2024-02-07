<?php
namespace App\DataTables\Dashboard\CallCenter;
use App\Models\{CallcenterProfile, Captain, CarMake, CarType, CategoryCar};
use App\DataTables\Base\BaseDataTable;
use Yajra\DataTables\EloquentDataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Utilities\Request as DataTableRequest;
use App\Services\Dashboard\Admins\CallCenterService;
use Illuminate\Support\Facades\DB;
class CaptainDataTable extends BaseDataTable {
    public function __construct(DataTableRequest $request) {
        parent::__construct(new Captain());
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (Captain $captain) {
                return view('dashboard.call-center.captains.btn.actions', compact('captain'));
            })
            ->addColumn('images', function (Captain $captain) {
                if($captain->status_caption_type == 'car' &&  $captain->captainActivity->status_caption_type == 'car') {
                    return CallCenterService::getImageStatus([$captain]);
                } elseif($captain->status_caption_type == 'scooter' &&  $captain->captainActivity->status_caption_type == 'scooter') {
                    return CallCenterService::getScooterImageStatus([$captain]);
                } elseif($captain->status_caption_type == 'tricycle' &&  $captain->captainActivity->status_caption_type == 'tricycle') {
                    return CallCenterService::getTricycleImageStatus([$captain]);
                }
            })

            ->editColumn('created_at', function (Captain $captain) {
                return $captain->created_at;
            })
            ->editColumn('updated_at', function (Captain $captain) {
                return $captain->updated_at;
            })
            ->editColumn('name', function (Captain $captain) {
                $captainVehicleType = $captain->status_caption_type;
                $icon = '';
                if ($captainVehicleType == 'car') {
                    $icon = 'fa-car';
                } elseif ($captainVehicleType == 'scooter') {
                    $icon = 'fa-motorcycle';
                }
                return '<a href="'.route('CallCenterCaptains.show', $captain->profile->uuid).'"><i class="fa ' . $icon . '"></i>'.' ' . $captain->name.'</a>';
            })
            ->editColumn('status', function (Captain $captain) {
                return ucfirst($captain->status);
            })
            ->editColumn('country_id', function (Captain $captain) {
                return $captain?->country?->name;
            })
            ->editColumn('callcenter', function (Captain $captain) {
                return $captain?->callcenter?->name;
            })
            ->setRowClass(function ($captain) {
                $captainActivity = $captain->captainActivity;
                if ($captainActivity && isset($captainActivity->status_captain_work)) {
                    switch ($captainActivity->status_captain_work) {
                        case 'block':
                            return 'text-white bg-danger';
                    }
                }
                return '';
            })
            ->addColumn('car', function (Captain $captain) {
                $hasCar = DB::table('cars_captions')->where('captain_id', $captain->id)->exists();
                return $hasCar ? '<i class="fa fa-check-circle fa-lg text-success"></i> have car' : '<i class="fa fa-times-circle fa-lg text-danger"></i> not have car';
            })
            ->addColumn('scooter', function (Captain $captain) {
                $hasScooter = DB::table('captain_scooters')->where('captain_id', $captain->id)->exists();
                return $hasScooter ? '<i class="fa fa-check-circle fa-lg text-success"></i> have scooter' : '<i class="fa fa-times-circle fa-lg text-danger"></i> not have scooter';
            })
            ->addColumn('tricycle', function (Captain $captain) {
                $hasTricycle = DB::table('captain_tricycles')->where('captain_id', $captain->id)->exists();
                return $hasTricycle ? '<i class="fa fa-check-circle fa-lg text-success"></i> have tricycle' : '<i class="fa fa-times-circle fa-lg text-danger"></i> not have tricycle';
            })
            ->rawColumns(['action', 'created_at', 'updated_at','status', 'country_id', 'name','callcenter', 'images', 'car', 'scooter', 'tricycle']);
    }

    public function query() {
        $query = Captain::query()->with(['callcenter', 'images', 'car', 'scooters', 'tricycles'])->whereCountryId(get_user_data()->country_id);
        if (request()->filled('id')) 
            $query->where('callcenter_id', request('id'));
        return $query->latest();
    }
    

    public function getColumns(): array {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false,],
            ['name' => 'name', 'data' => 'name', 'title' => 'Name',],
            ['name' => 'email', 'data' => 'email', 'title' => 'Email', 'orderable' => false, 'searchable' => false,],
            ['name' => 'phone', 'data' => 'phone', 'title' => 'Phone'],
            ['name' => 'car', 'data' => 'car', 'title' => 'Car', 'orderable' => false, 'searchable' => false,],
            ['name' => 'scooter', 'data' => 'scooter', 'title' => 'Scooter', 'orderable' => false, 'searchable' => false,],
            ['name' => 'tricycle', 'data' => 'tricycle', 'title' => 'Tricycle', 'orderable' => false, 'searchable' => false,],
            ['name' => 'callcenter', 'data' => 'callcenter', 'title' => 'callcenter', 'orderable' => false, 'searchable' => false,],
            ['name' => 'country_id', 'data' => 'country_id', 'title' => 'Country', 'orderable' => false, 'searchable' => false,],
            ['name' => 'images', 'data' => 'images', 'title' => 'Images', 'orderable' => false, 'searchable' => false,],
            ['name' => 'status', 'data' => 'status', 'title' => 'Status', 'orderable' => false, 'searchable' => false,],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => 'Created_at', 'orderable' => false, 'searchable' => false,],
            ['name' => 'updated_at', 'data' => 'updated_at', 'title' => 'Update_at', 'orderable' => false, 'searchable' => false,],
            ['name' => 'action', 'data' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false,],
        ];
    }
}