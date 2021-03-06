<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\HR\Shift;
use App\Models\HR\WorkGroup;
use App\Models\Master\Holiday;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class HolidayController extends Controller
{
    private $route = "master.holiday.";

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
            $data = Holiday::selectRaw('id, name as text')->whereRaw("lower(name) like lower('%{$q}%')")->get();
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
        $data = Holiday::find($id);
        $params = [
            "data" => $data,
            "route" => $this->route
        ];
        return view($this->route . 'form', $params);
    }

    public function create()
    {
        $data = new Holiday();

        $params = [
            "data" => $data,
            "route" => $this->route
        ];
        return view($this->route . 'form', $params);
    }

    public function update(Request $request, $id)
    {
        request()->validate([
            'date' => 'required',
            'description' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $checkDate = Holiday::where('date', $request->date)
                ->where('id', '!=', $id)
                ->first();
            if (empty($checkDate)) {
                $data = Holiday::find($id);
                $data->date = $request->date;
                $data->description = $request->description;
                $data->save();
                DB::commit();
                return redirect(route($this->route . 'index'))->with('swal-success', 'success');
            } else {
                DB::rollBack();
                return Redirect::back()->withErrors(['Tanggal Sudah Ada']);
            }
            return redirect(route($this->route . 'index'))->with('swal-success', 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors(['Failed']);
        }
    }

    public function store(Request $request)
    {
        request()->validate([
            'date' => 'required',
            'description' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $checkDate = Holiday::where('date', $request->date)->first();
            if (empty($checkDate)) {
                $data = new Holiday();
                $data->date = $request->date;
                $data->description = $request->description;
                $data->save();
                DB::commit();
                return redirect(route($this->route . 'index'))->with('swal-success', 'success');
            } else {
                DB::rollBack();
                return Redirect::back()->withErrors(['Tanggal Sudah Ada']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors(['Failed']);
        }
    }

    public function delete(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $data = Holiday::find($id);
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
        $data = Holiday::get();
        return DataTables::collection($data)
            ->editColumn('action', function ($d) {
                $html = '<a href="' . route($this->route . 'edit', $d->id) . '" class="m-r-15 text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="mdi mdi-pencil font-20"></i></a>';
                $html .= '<a href="javascript:void(0)" onclick="deleteData(' . $d->id . ')" class="text-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="mdi mdi-close font-20"></i></a>';
                return $html;
            })            
            ->editColumn('date', function ($d) {
                return Carbon::parse($d->date)->translatedFormat('d F Y');
            })
            ->rawColumns(['action', 'date'])
            ->make(true);
    }
}
