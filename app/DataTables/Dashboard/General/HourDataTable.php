<?php
namespace App\DataTables\Dashboard\General;
use App\Models\Hour;
use App\DataTables\Base\BaseDataTable;
use Yajra\DataTables\EloquentDataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class HourDataTable extends BaseDataTable {
    public function __construct(DataTableRequest $request) {
        parent::__construct(new Hour());
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($hour) {
                return view('dashboard.general.hours.btn.actions', compact('hour'));
            })
            ->editColumn('category_car_id', function (Hour $hour) {
                return $hour->category_car->name;
            })
            ->rawColumns(['action','created_at', 'updated_at', 'category_car_id']);
    }

    public function query(): QueryBuilder{

        return Hour::query();
    }

    protected function getColumns(): array {
        return [
            ['name'=>'id','data'=>'id','title'=>'#','orderable'=>false,'searchable'=>false,],
            ['name'=>'number_hours','data'=>'number_hours','title'=> 'Hour',],
            ['name'=>'offer_price','data'=>'offer_price','title'=> 'Offer Price',],
            ['name'=>'discount_hours','data'=>'discount_hours','title'=> 'Discount Hours',],
            ['name'=>'price_hours','data'=>'price_hours','title'=> 'Hours Price',],
            ['name'=>'price_premium','data'=>'price_premium','title'=> 'Hours Price Premium',],
            ['name'=>'offer_price_premium','data'=>'offer_price_premium','title'=> 'Offer Price Premium',],
            ['name'=>'category_car_id','data'=>'category_car_id','title'=> 'Car Category','orderable'=>false,'searchable'=>false,],
            ['name'=>'action','data'=> 'action','title'=>'Actions','exportable'=>false,'printable'=>false,'orderable'=>false,'searchable'=>false,],
        ];
    }
}