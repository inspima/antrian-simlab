<?php

namespace App\Http\Controllers\Master;

use App\Models\Account\Personal;
use App\Models\Account\UserDevice;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use SimpleSoftwareIO\QrCode\Generator;
use SimpleSoftwareIO\QrCode\ServiceProvider;
use SimpleSoftwareIO\QrCode\ServiceProvider as QrCode;
use Yajra\DataTables\Facades\DataTables;

class StaffController extends Controller
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
        return view('master.staff.index');
    }

    public function edit(Request $request, $id)
    {
        $dataPersonal = Personal::find($id);
        $dataUser = User::find($dataPersonal->user_id);
        $dataUserDevice = UserDevice::where("user_id", $dataPersonal->user_id)->where("is_active", "1")->first();
        if (is_null($dataUserDevice)) {
            $dataUserDevice = new UserDevice();
        }

        $params = [
            "dataUser" => $dataUser,
            "dataPersonal" => $dataPersonal,
            "dataUserDevice" => $dataUserDevice,
        ];
        return view('master.staff.form', $params);
    }

    public function create()
    {
        $dataUser = new User();
        $dataPersonal = new Personal();
        $dataUserDevice = new UserDevice();

        $params = [
            "dataUser" => $dataUser,
            "dataPersonal" => $dataPersonal,
            "dataUserDevice" => $dataUserDevice,
        ];
        return view('master.staff.form', $params);
    }

    public function update(Request $request, $id)
    {

        $dataPersonal = Personal::find($id);
        request()->validate([
            'company_id' => 'required|max:50',
            'work_group_id' => 'required',
            'work_place_id' => 'required',
            'shift_id' => 'required',
            'name' => 'required|max:50',
            'nik' => 'required',
            'address' => 'required',
            'email' => 'required|email', Rule::unique('users')->ignore($dataPersonal->id),
            'work_id_number' => 'required', Rule::unique('personals')->ignore($id),
        ]);


        DB::beginTransaction();
        try {
            $dataPersonal = Personal::find($id);
            $dataPersonal->company_id = $request->company_id;
            $dataPersonal->work_place_id = $request->work_place_id;
            $dataPersonal->work_group_id = $request->work_group_id;
            $dataPersonal->shift_id = $request->shift_id;
            $dataPersonal->work_id_number = $request->work_id_number;
            $dataPersonal->id_type = "KTP";
            $dataPersonal->id_number = $request->nik;
            $dataPersonal->name = $request->name;
            $dataPersonal->address = $request->address;
            $dataPersonal->mobile = $request->mobile;
            $dataPersonal->save();

            $dataUser = User::find($dataPersonal->user_id);
            $dataUser->name = $request->name;
            $dataUser->email = $request->email;
            if ($request->password) {
                $dataUser->password = bcrypt($request->password);
            }
            $dataUser->save();

            DB::commit();
            return redirect(route('master.staff.index'))->with('swal-success', 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors(['Failed']);
        }
    }

    public function store(Request $request)
    {
        request()->validate([
            'company_id' => 'required|max:50',
            'work_group_id' => 'required',
            'work_place_id' => 'required',
            'shift_id' => 'required',
            'name' => 'required|max:50',
            'nik' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'work_id_number' => 'required|unique:personals',
        ]);


        DB::beginTransaction();
        try {
            $newUser = new User();
            $newUser->name = $request->name;
            $newUser->email = $request->email;
            $newUser->password = bcrypt($request->password);
            $newUser->save();

            $newPersonal = new Personal();
            $newPersonal->user_id = $newUser->id;
            $newPersonal->company_id = $request->company_id;
            $newPersonal->work_place_id = $request->work_place_id;
            $newPersonal->work_group_id = $request->work_group_id;
            $newPersonal->shift_id = $request->shift_id;
            $newPersonal->work_id_number = $request->work_id_number;
            $newPersonal->id_type = "KTP";
            $newPersonal->id_number = $request->nik;
            $newPersonal->name = $request->name;
            $newPersonal->address = $request->address;
            $newPersonal->mobile = $request->mobile;
            $newPersonal->save();

            DB::commit();
            return redirect(route('master.staff.index'))->with('swal-success', 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors(['Failed']);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $dataPersonal = Personal::find($id);
            $dataUser = User::find($dataPersonal->user_id);

            $dataUser->delete();
            $dataPersonal->delete();
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
        $data = Personal::Join("users", "users.id", "personals.user_id")
            ->select("personals.*", "users.name", "users.email")->get();
        return DataTables::collection($data)
            ->addColumn('qr', function ($d) {
                $gen = new Generator();
                $gen->format('png');
                $qrSource = $gen->size("150")->generate($d->work_id_number);
                $qrBase64 = "data:image/png;base64, " . base64_encode($qrSource);
                $html = '<div class="product-list-img"><img src="' . $qrBase64 . '" class="img-fluid" data-qr="'.$qrBase64.'" alt="tbl" onclick="openModal(\''.$qrBase64.'\')"></div>';
                return $html;
            })->addColumn('action', function ($d) {
                $html = '<a href="' . route('master.staff.edit', $d->id) . '" class="m-r-15 text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="mdi mdi-pencil font-18"></i></a>';
                $html .= '<a href="javascript:void(0)" onclick="deleteData(' . $d->id . ')" class="text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="mdi mdi-close font-18"></i></a>';
                return $html;
            })
            ->rawColumns(['qr', 'action'])->make();
    }
}
