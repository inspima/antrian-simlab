<?php namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\HR\Shift;
use App\Models\HR\ShiftDetail;
use App\Models\HR\WorkDay;
use App\Models\HR\WorkGroup;
use App\Models\HR\WorkTime;
use App\Models\Organization\Company;
use App\Models\Organization\WorkPlace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class WorkGroupController extends Controller
{

    private $route = "master.work-group.";

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
            $company_id = $request->company_id;
            $data = WorkGroup::selectRaw('id, name as text')->whereRaw("lower(name) like lower('%{$q}%') and company_id = {$company_id}")->get();
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

    public function edit(Request $request, $id)
    {
        $data = WorkGroup::find($id);
        $params = [
            "data" => $data,
            "route" => $this->route
        ];
        return view($this->route . 'form', $params);
    }

    public function create()
    {
        $data = new WorkGroup();

        $params = [
            "data" => $data,
            "route" => $this->route
        ];
        return view($this->route . 'form', $params);
    }

    public function update(Request $request, $id)
    {

        request()->validate([
            'company_id' => 'required',
            'shift_id' => 'required',
            'name' => 'required|max:50',
        ]);


        DB::beginTransaction();
        try {
            $data = WorkGroup::find($id);
            $data->company_id = $request->company_id;
            $data->shift_id = $request->shift_id;
            $data->name = $request->name;
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
            'company_id' => 'required',
            'shift_id' => 'required',
            'name' => 'required|max:50',
        ]);

        DB::beginTransaction();
        try {
            $data = new WorkGroup();
            $data->company_id = $request->company_id;
            $data->shift_id = $request->shift_id;
            $data->name = $request->name;
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
        try {
            DB::beginTransaction();
            $data = WorkGroup::find($id);
            $data->delete();
            DB::commit();
            return response()->json([
                'message' => 'success',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function datatable(Request $request)
    {
        $data = WorkGroup::Join("companies", "companies.id", "work_groups.company_id")
            ->join("shifts", "shifts.id", "work_groups.shift_id")
            ->select("work_groups.id", "work_groups.name", 'shifts.name as shift_name', 'companies.name as company_name')->get();
        return DataTables::collection($data)
            ->editColumn('action', function ($d) {
                $html = '<a href="' . route($this->route . 'edit', $d->id) . '" class="m-r-15 text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="mdi mdi-pencil font-18"></i></a>';
                $html .= '<a href="javascript:void(0)" onclick="deleteData(' . $d->id . ')" class="text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="mdi mdi-close font-18"></i></a>';
                return $html;
            })
            ->editColumn('time', function ($d) {
                $html = "";
                if ($d->shift) {
                    foreach ($d->shift->shift_details as $sd) {
                        if ($sd->work_time) {
                            $html .= $sd->work_day->day . " " . $sd->work_time->start_time . "-" . $sd->work_time->end_time . "<br>";
                        } else {
                            $html .= $sd->work_day->day . " off<br>";
                        }
                    }
                }
                return $html;
            })
            ->rawColumns(['action', 'time'])
            ->make(true);
    }
}
