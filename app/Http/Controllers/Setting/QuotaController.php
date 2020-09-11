<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\HR\Shift;
use App\Models\HR\WorkGroup;
use App\Models\Process\QuotaOrganization;
use App\Models\Process\QuotaQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class QuotaController extends Controller
{
    private $route = "setting.quota.";

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
            $data = QuotaQueue::selectRaw('id, name as text')->whereRaw("lower(name) like lower('%{$q}%')")->get();
            $resp['results'] = $data;
        } catch (\Exception $e) {
        }
        return response()->json($resp);
    }

    public function index()
    {
        $route = $this->route;
        $default_quotas = QuotaQueue::get();
        return view($this->route . 'index', compact("route", 'default_quotas'));
    }

    public function edit(Request $request, $id)
    {
        $type = $request->get('quota_type');
        if ($type == 'default') {
            $data = QuotaQueue::find($id);
        } else {
            $data = QuotaOrganization::find($id);
        }
        $params = [
            "data" => $data,
            'type' => $type,
            "route" => $this->route
        ];
        return view($this->route . 'form', $params);
    }

    public function create()
    {
        $data = new QuotaOrganization();

        $params = [
            "data" => $data,
            'type' => 'organization',
            "route" => $this->route
        ];
        return view($this->route . 'form', $params);
    }

    public function update(Request $request, $id)
    {
        request()->validate([
            'quota' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $type = $request->get('quota_type');
            if ($type == 'default') {
                $data = QuotaQueue::find($id);
            } else {
                $data = QuotaOrganization::find($id);
            }
            $data->quota = $request->quota;
            $data->save();
            DB::commit();
            return redirect(route($this->route . 'index'))->with('swal-success', 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors(['Failed']);
        }
    }

    public function store(Request $request)
    {
        request()->validate([
            'quota' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $data = new QuotaOrganization;
            $data->organization_id = $request->organization_id;
            $data->quota = $request->quota;
            $data->save();
            DB::commit();
            return redirect(route($this->route . 'index'))->with('swal-success', 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors(['Failed']);
        }
    }

    public function delete(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $data = QuotaOrganization::find($id);
            $data->delete();
            DB::commit();
            return response()->json([
                'message' => 'success',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function datatable(Request $request)
    {
        $data = QuotaOrganization::get();
        return DataTables::collection($data)
            ->editColumn('name', function ($d) {
                $html = $d->organization->name;
                return $html;
            })
            ->editColumn('action', function ($d) {
                $html = '<a href="' . route($this->route . 'edit', $d->id) . '?quota_type=organization" class="m-r-15 text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="mdi mdi-pencil font-20"></i></a>';
                $html .= '<a href="javascript:void(0)" onclick="deleteData(' . $d->id .  ')" class="text-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="mdi mdi-close font-20"></i></a>';
                return $html;
            })
            ->rawColumns(['action', 'time'])
            ->make(true);
    }
}
