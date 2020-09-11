<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Process\RegistrationQueue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReportQuotaController extends Controller
{
    private $route = "report.quota.";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function select2(Request $request)
    {
        $resp = [
            'results' => [],
            "more" => false
        ];
        try {
            $q = strtolower($request->q);
            $data = RegistrationQueue::selectRaw('id, name as text')->whereRaw("lower(name) like lower('%{$q}%')")->get();
            $resp['results'] = $data;
        } catch (\Exception $e) {
        }
        return response()->json($resp);
    }

    public function index()
    {
        $route = $this->route;
        return view($this->route . 'index', compact("route"));
    }

    public function detail(Request $request, $id)
    {
        $data = RegistrationQueue::find($id);
        $params = [
            "data" => $data,
            "route" => $this->route
        ];
        return view($this->route . 'detail', $params);
    }

    public function datatable(Request $request)
    {
        $data = RegistrationQueue::orderByDesc('date')->get();
        return DataTables::collection($data)
            ->editColumn('action', function ($d) {
                $html = '<a href="' . route($this->route . 'detail', $d->id) . '" class="m-r-15 text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="ion-android-information font-20"></i></a>';
                return $html;
            })            
            ->editColumn('available', function ($d) {
                return $d->quota-$d->filled;
            })
            ->editColumn('date', function ($d) {
                return Carbon::parse($d->date)->translatedFormat('l, d F Y');
            })
            ->rawColumns(['action', 'available','date'])
            ->make(true);
    }
}
