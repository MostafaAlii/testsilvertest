<?php
namespace App\Http\Controllers\Dashboard\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\Dashboard\Admin\{CallCenterActivityDataTable};

class CallCenterActivityController extends Controller {
    public function __construct(
        protected CallCenterActivityDataTable $dataTable
        ) {
        $this->dataTable = $dataTable;
    }

    public function getActivity() {
        $data = [
            'title' => 'Call-Centers Activity',
        ];
        return $this->dataTable->render('dashboard.admin.call-centers.activity',  compact('data'));
    }
}