<?php

namespace App\Http\Controllers\Master;

use App\Models\Account\Personal;
use App\Models\Account\UserDevice;
use App\Models\HR\Shift;
use App\Models\HR\ShiftDetail;
use App\Models\HR\WorkDay;
use App\Models\HR\WorkGroup;
use App\Models\HR\WorkTime;
use App\Models\Organization\Company;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ShiftController extends Controller
{
    private $route = "master.shift.";

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
        return view('master.shift.index');
    }

    public function edit(Request $request, $id)
    {
        $data = Shift::find($id);
        $params = [
            "data" => $data,
            "days" => WorkDay::all(),
            "route" => $this->route
        ];
        return view($this->route . 'form', $params);
    }

    public function create()
    {
        $data = new Shift();

        $params = [
            "data" => $data,
            "days" => WorkDay::all(),
            "route" => $this->route
        ];
        return view('master.shift.form', $params);
    }

    public function update(Request $request, $id)
    {

        request()->validate([
            'company_id' => 'required|max:50',
            'name' => 'required|max:50',
        ]);


        DB::beginTransaction();
        try {
            $data = Shift::find($id);
            $data->company_id = $request->company_id;
            $data->name = $request->name;
            $data->save();
            foreach ($request->days as $day) {
                $startTime = $request->startTime[$day];
                $endTime = $request->endTime[$day];

                $dataShiftDetail = ShiftDetail::where("shift_id", $data->id)->where("work_day_id", $day)->first();
                if ($startTime && $endTime) {
                    $workTime = WorkTime::firstOrCreate([
                        "start_time" => $startTime,
                        "end_time" => $endTime
                    ]);
                    $dataShiftDetail->work_time_id = $workTime->id;
                } else {
                    $dataShiftDetail->work_time_id = null;
                }
                $dataShiftDetail->save();
            }

            DB::commit();
            return redirect(route('master.shift.index'))->with('swal-success', 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors(['Failed']);
        }
    }

    public function store(Request $request)
    {
        request()->validate([
            'company_id' => 'required|max:50',
            'name' => 'required|max:50',
        ]);

        DB::beginTransaction();
        try {
            $data = new Shift();
            $data->company_id = $request->company_id;
            $data->name = $request->name;
            $data->save();


            foreach ($request->days as $day) {
                $startTime = $request->startTime[$day];
                $endTime = $request->endTime[$day];

                if ($startTime && $endTime) {
                    $workTime = WorkTime::firstOrCreate([
                        "start_time" => $startTime,
                        "end_time" => $endTime
                    ]);

                    ShiftDetail::create([
                        "shift_id" => $data->id,
                        "work_day_id" => $day,
                        "work_time_id" => $workTime->id,
                    ]);
                } else {
                    ShiftDetail::create([
                        "shift_id" => $data->id,
                        "work_day_id" => $day
                    ]);
                }
            }
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
            $data = Shift::find($id);
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
        $data = Shift::Join("companies", "companies.id", "shifts.company_id")
            ->select("shifts.id", 'shifts.name', 'companies.name as company_name')->get();
        return DataTables::collection($data)
            ->editColumn('action', function ($d) {
                $html = '<a href="' . route($this->route . 'edit', $d->id) . '" class="m-r-15 text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="mdi mdi-pencil font-18"></i></a>';
                $html .= '<a href="javascript:void(0)" onclick="deleteData(' . $d->id . ')" class="text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="mdi mdi-close font-18"></i></a>';
                return $html;
            })
            ->editColumn('time', function ($d) {
                $html = '';
                foreach ($d->shift_details as $sd) {
                    if ($sd->work_time) {
                        $html .= $sd->work_day->day . " " . $sd->work_time->start_time . "-" . $sd->work_time->end_time . "<br>";
                    } else {
                        $html .= $sd->work_day->day . " off<br>";
                    }
                }
                return $html;
            })
            ->rawColumns(['action', 'time'])
            ->make(true);
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
            $data = Shift::selectRaw('id, name as text')->whereRaw("lower(name) like lower('%{$q}%') and company_id = {$company_id}")->get();
            $resp['results'] = $data;
        } catch (\Exception $e) {

        }
        return response()->json($resp);
    }
}
