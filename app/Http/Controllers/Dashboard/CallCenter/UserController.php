<?php
namespace App\Http\Controllers\Dashboard\CallCenter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\Dashboard\CallCenter\UserDataTable;
class UserController extends Controller {
    public function __construct(protected UserDataTable $dataTable) {
        $this->dataTable = $dataTable;
    }

    public function index() {
        $data = ['title' => 'Users',];
        return $this->dataTable->render('dashboard.call-center.users.index', compact('data'));
    }

    public function sendNotificationAll(Request $request) {
        try {
            sendNotificatioAll($request->type, $request->body, $request->title);
            return redirect()->back();

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'An error occurred');

        }
    }
}