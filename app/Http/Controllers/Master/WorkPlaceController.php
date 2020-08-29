<?php namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\HR\Shift;
use App\Models\HR\WorkGroup;
use App\Models\Organization\Company;
use App\Models\Organization\WorkPlace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class WorkPlaceController extends Controller
{
    private $route = "master.work-place.";

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
            $data = WorkPlace::selectRaw('id, name as text')->whereRaw("lower(name) like lower('%{$q}%') and company_id = {$company_id}")->get();
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
        $data = WorkPlace::find($id);
        $params = [
            "data" => $data,
            "route" => $this->route
        ];
        return view($this->route . 'form', $params);
    }

    public function create()
    {
        $data = new Shift();

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
            'address' => 'required',
            'phone' => 'required',
            'name' => 'required|max:50',
        ]);


        DB::beginTransaction();
        try {
            $data = WorkPlace::find($id);
            $data->company_id = $request->company_id;
            $data->name = $request->name;
            $data->country = $request->country;
            $data->province = $request->province;
            $data->city = $request->city;
            $data->district = $request->district;
            $data->address = $request->address;
            $data->phone = $request->phone;
            $data->map_address = $request->map_address;
            $data->latitude = $request->latitude;
            $data->longitude = $request->longitude;
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
            'address' => 'required',
            'phone' => 'required',
            'name' => 'required|max:50',
        ]);

        DB::beginTransaction();
        try {
            $data = new WorkPlace();
            $data->company_id = $request->company_id;
            $data->name = $request->name;
            $data->country = $request->country;
            $data->province = $request->province;
            $data->city = $request->city;
            $data->district = $request->district;
            $data->address = $request->address;
            $data->phone = $request->phone;
            $data->map_address = $request->map_address;
            $data->latitude = $request->latitude;
            $data->longitude = $request->longitude;
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
            $data = WorkPlace::find($id);
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
        $data = WorkPlace::Join("companies", "companies.id", "work_places.company_id")
            ->select("work_places.id", "work_places.name", 'companies.name as company_name')->get();
        return DataTables::collection($data)
            ->editColumn('action', function ($d) {
                $html = '<a href="' . route($this->route . 'edit', $d->id) . '" class="m-r-15 text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="mdi mdi-pencil font-18"></i></a>';
                $html .= '<a href="javascript:void(0)" onclick="deleteData(' . $d->id . ')" class="text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="mdi mdi-close font-18"></i></a>';
                return $html;
            })
            ->rawColumns(['action', 'time'])
            ->make(true);
    }
}
