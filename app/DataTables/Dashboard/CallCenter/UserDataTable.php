<?php
namespace App\DataTables\Dashboard\CallCenter;
use App\Models\User;
use App\DataTables\Base\BaseDataTable;
use Yajra\DataTables\EloquentDataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Utilities\Request as DataTableRequest;
class UserDataTable extends BaseDataTable {
    public function __construct(DataTableRequest $request) {
        parent::__construct(new User());
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable {
        return (new EloquentDataTable($query))
            /*->addColumn('action', function (User $captain) {
                return view('dashboard.call-center.captains.btn.actions', compact('captain'));
            })*/

            /*->addColumn('images', function (Captain $captain) {
                return CallCenterService::getImageStatus([$captain]);
            })*/
            
            ->editColumn('created_at', function (User $user) {
                return $user->created_at;
            })
            ->editColumn('updated_at', function (User $user) {
                return $user->updated_at;
            })
            ->editColumn('country_id', function (User $user) {
                return $user?->country?->name;
            })
            ->rawColumns([/*'action',*/ 'created_at', 'updated_at', 'country_id',]);
    }

    public function query() {
        return User::query()->whereCountryId(get_user_data()->country_id)->latest();
    }

    public function getColumns(): array {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false,],
            ['name' => 'name', 'data' => 'name', 'title' => 'Name',],
            ['name' => 'email', 'data' => 'email', 'title' => 'Email', 'orderable' => false, 'searchable' => false,],
            ['name' => 'phone', 'data' => 'phone', 'title' => 'Phone'],
            ['name' => 'country_id', 'data' => 'country_id', 'title' => 'Country', 'orderable' => false, 'searchable' => false,],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => 'Created_at', 'orderable' => false, 'searchable' => false,],
            ['name' => 'updated_at', 'data' => 'updated_at', 'title' => 'Update_at', 'orderable' => false, 'searchable' => false,],
            /*['name' => 'action', 'data' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false,],*/
        ];
    }
}