<?php namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\HR\Shift;
use App\Models\HR\WorkGroup;
use App\Models\Organization\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller
{
    private $route = "master.company.";

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
            $data = Company::selectRaw('id, name as text')->whereRaw("lower(name) like lower('%{$q}%')")->get();
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
        $data = Company::find($id);
        $params = [
            "data" => $data,
            "route" => $this->route
        ];
        return view($this->route . 'form', $params);
    }

    public function create()
    {
        $data = new Company();

        $params = [
            "data" => $data,
            "route" => $this->route
        ];
        return view($this->route . 'form', $params);
    }

    public function update(Request $request, $id)
    {
        request()->validate([
            'short_name' => 'required|max:50',
            'name' => 'required|max:50',
            'address' => 'required',
            'phone' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $data = Company::find($id);
            $data->short_name = $request->short_name;
            $data->name = $request->name;
            $data->is_pkp = $request->is_pkp ? 1 : 0;
            $data->npwp = $request->npwp;
            $data->tdp = $request->tdp;
            $data->siup = $request->siup;
            $data->domisili = $request->domisili;
            $data->country = $request->country;
            $data->province = $request->province;
            $data->city = $request->city;
            $data->district = $request->district;
            $data->sub_district = $request->sub_district;
            $data->address = $request->address;
            $data->postal_code = $request->postal_code;
            $data->phone = $request->phone;
            $data->email = $request->email;
            $data->fax = $request->fax;
            $data->contact_name = $request->contact_name;
            $data->contact_mobile = $request->contact_mobile;
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
            'short_name' => 'required|max:50',
            'name' => 'required|max:50',
            'address' => 'required',
            'phone' => 'required',
        ]);

        DB::beginTransaction();
        try {

            $data = Company::withTrashed()->count();
            $code = "CO/" . str_pad($data + 1, 4, "0", STR_PAD_LEFT);
            $data = new Company();
            $data->code = $code;
            $data->short_name = $request->short_name;
            $data->name = $request->name;
            $data->is_pkp = $request->is_pkp ? 1 : 0;
            $data->npwp = $request->npwp;
            $data->tdp = $request->tdp;
            $data->siup = $request->siup;
            $data->domisili = $request->domisili;
            $data->country = $request->country;
            $data->province = $request->province;
            $data->city = $request->city;
            $data->district = $request->district;
            $data->sub_district = $request->sub_district;
            $data->address = $request->address;
            $data->postal_code = $request->postal_code;
            $data->phone = $request->phone;
            $data->email = $request->email;
            $data->fax = $request->fax;
            $data->contact_name = $request->contact_name;
            $data->contact_mobile = $request->contact_mobile;
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
            $data = Company::find($id);
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
        $data = Company::get();
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
