<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceYearlyExport;
use App\Models\Account\Personal;
use App\Models\Attendance\Attendance;
use App\Models\Master\Organization;
use App\Models\Process\Registration;
use App\Models\Process\RegistrationPatient;
use App\Models\Process\RegistrationQueue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{

    private $route = "dashboard.";
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
        $view = 'index';
        $data = [];
        if (session('role') == 'Administration') {
            $view = 'index-admin';
            $data = [
                "total_organization" => Organization::count(),
                "total_patient" => RegistrationPatient::count(),
                "quota_info" => RegistrationQueue::select(DB::raw('COALESCE(SUM(quota),0) as quota,COALESCE(SUM(filled),0) as filled,(COALESCE(SUM(filled),0) / COALESCE(SUM(quota),0)) * 100 as percentage'))
                    ->get()[0],
                "route" => $this->route,
            ];
        } else {
            $data = [
                "total_registration" => Registration::where('organization_id', session("org_id"))
                    ->count(),
                "total_patient" => RegistrationPatient::whereIn('registration_id', Registration::where('organization_id', session("org_id"))->get()->pluck('id'))
                    ->count(),
                "total_registration_sent" => Registration::where('organization_id', session("org_id"))
                    ->where('status', '1')
                    ->count(),
                "route" => $this->route,
            ];
        }
        return view('dashboard.' . $view, $data);
    }

    public function datatableMonitoringQuota(Request $request)
    {
        $data = RegistrationQueue::orderByDesc('date')
            ->offset(0)
            ->limit(5)
            ->get();
        return DataTables::collection($data)
            ->editColumn('action', function ($d) {
                $html = '<a href="' . route('report.quota.detail', $d->id) . '" class="m-r-15 text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="ion-android-information font-20"></i></a>';
                return $html;
            })
            ->editColumn('available', function ($d) {
                return $d->quota - $d->filled;
            })
            ->editColumn('date', function ($d) {
                return Carbon::parse($d->date)->translatedFormat('l, d F Y');
            })
            ->rawColumns(['action', 'available', 'date'])
            ->make(true);
    }
}
