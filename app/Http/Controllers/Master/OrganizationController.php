<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Account\Personal;
use App\Models\Account\Role;
use App\Models\HR\Shift;
use App\Models\HR\WorkGroup;
use App\Models\Master\Organization;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class OrganizationController extends Controller
{
    private $route = "master.organization.";

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
            $data = Organization::selectRaw('id, name as text')->whereRaw("lower(name) like lower('%{$q}%')")->get();
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
        $data = Organization::find($id);
        $params = [
            "data" => $data,
            "route" => $this->route
        ];
        return view($this->route . 'form', $params);
    }

    public function create()
    {
        $data = new Organization();

        $params = [
            "data" => $data,
            "route" => $this->route
        ];
        return view($this->route . 'form', $params);
    }

    public function update(Request $request, $id)
    {
        request()->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'contact_name' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $data = Organization::find($id);
            $data->name = $request->name;
            $data->notes = $request->notes;
            $data->country = $request->country;
            $data->province = $request->province;
            $data->city = $request->city;
            $data->address = $request->address;
            $data->phone = $request->phone;
            $data->contact_name = $request->contact_name;
            $data->contact_mobile = $request->contact_mobile;
            $data->save();

            DB::commit();
            return redirect(route($this->route . 'index'))->with('swal-success', 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors([$e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'contact_name' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $data = Organization::withTrashed()->count();
            if ($request->type == 'Rumah Sakit') {
                $code = "RS/" . str_pad($data + 1, 6, "0", STR_PAD_LEFT);
            } else if ($request->type == 'Instansi Pemerintah') {
                $code = "INST/" . str_pad($data + 1, 6, "0", STR_PAD_LEFT);
            } else if ($request->type == 'Perusahaan') {
                $code = "PT/" . str_pad($data + 1, 6, "0", STR_PAD_LEFT);
            } else if ($request->type == 'Individu') {
                $code = "INDV/" . str_pad($data + 1, 6, "0", STR_PAD_LEFT);
            }
            $data = new Organization();
            $data->code = $code;
            $data->name = $request->name;
            $data->type = $request->type;
            $data->notes = $request->notes;
            $data->country = $request->country;
            $data->province = $request->province;
            $data->city = $request->city;
            $data->address = $request->address;
            $data->phone = $request->phone;
            $data->email = $request->email;
            $data->contact_name = $request->contact_name;
            $data->contact_mobile = $request->contact_mobile;
            $data->save();

            $user = User::create([
                'name' => $request->contact_name,
                'email' => $request->email,
                'password' => bcrypt('itdunair'),
                'role' => Role::find(2)->name,
                // 'avatar' => 'avatar.png'
            ]);
            Personal::create([
                'user_id' => $user->id,
                'organization_id' => $data->id,
                'name' => $user->name,
                'address' => $data->address,
            ]);
            DB::commit();
            return redirect(route($this->route . 'index'))->with('swal-success', 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors([$e->getMessage()]);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $data = Organization::find($id);
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
        $data = Organization::get();
        return DataTables::collection($data)
            ->editColumn('action', function ($d) {
                $html = '<a href="' . route($this->route . 'edit', $d->id) . '" class="m-r-15 text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="mdi mdi-pencil font-20"></i></a>';
                $html .= '<a href="javascript:void(0)" onclick="deleteData(' . $d->id . ')" class="text-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="mdi mdi-close font-20"></i></a>';
                return $html;
            })
            ->rawColumns(['action', 'time'])
            ->make(true);
    }
}
