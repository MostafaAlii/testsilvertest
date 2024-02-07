<?php
namespace App\Http\Controllers\Dashboard\CallCenter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class CallCenterDashboardController extends Controller {
    public function index() {
        return view('dashboard.call-center.dashboard',['title' => 'Call-Center Dashboard']);
    }
}