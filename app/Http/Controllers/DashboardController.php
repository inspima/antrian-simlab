<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceYearlyExport;
use App\Models\Account\Personal;
use App\Models\Attendance\Attendance;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [
            "month" => date("Y-m")
        ];
        return view('dashboard.index', $data);
    }
}
