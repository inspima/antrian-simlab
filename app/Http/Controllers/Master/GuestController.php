<?php

namespace App\Http\Controllers\Master;

use App\Models\Account\Guest;
use App\Models\Account\Personal;
use App\Models\Account\UserDevice;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class GuestController extends Controller
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
        return view('master.guest.index');
    }

    public function edit(Request $request, $id)
    {
        $dataGuest = Guest::find($id)->first();
        $dataUser = User::find($dataGuest->user_id);
        $dataUserDevice = UserDevice::where("user_id", $dataGuest->user_id)->where("is_active", "1")->first();
        if (is_null($dataUserDevice)) {
            $dataUserDevice = new UserDevice();
        }

        $params = [
            "dataUser" => $dataUser,
            "dataGuest" => $dataGuest,
            "dataUserDevice" => $dataUserDevice,
        ];
        return view('master.guest.form', $params);
    }

    public function create()
    {
        $dataUser = new User();
        $dataGuest = new Guest();
        $dataUserDevice = new UserDevice();

        $params = [
            "dataUser" => $dataUser,
            "dataGuest" => $dataGuest,
            "dataUserDevice" => $dataUserDevice,
        ];
        return view('master.guest.form', $params);
    }

    public function update(Request $request, $id)
    {

        $dataGuest = Guest::find($id);
        request()->validate([
            'event_id' => 'required',
            'name' => 'required|max:50',
            'nik' => 'required',
            'email' => 'required|email', Rule::unique('users')->ignore($dataGuest->user_id),
        ]);


        DB::beginTransaction();
        try {
            $dataGuest->event_id = $request->event_id;
            $dataGuest->id_type = "KTP";
            $dataGuest->id_number = $request->nik;
            $dataGuest->name = $request->name;
            $dataGuest->address = $request->address;
            $dataGuest->mobile = $request->mobile;
            $dataGuest->save();

            $dataUser = User::find($dataGuest->user_id);
            $dataUser->name = $request->name;
            $dataUser->email = $request->email;
            if ($request->password) {
                $dataUser->password = bcrypt($request->password);
            }
            $dataUser->save();

            DB::commit();
            return redirect(route('master.guest.index'))->with('swal-success', 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors(['Failed']);
        }
    }

    public function store(Request $request)
    {
        request()->validate([
            'event_id' => 'required',
            'name' => 'required|max:50',
            'nik' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);


        DB::beginTransaction();
        try {
            $newUser = new User();
            $newUser->name = $request->name;
            $newUser->email = $request->email;
            $newUser->password = bcrypt($request->password);
            $newUser->save();

            $dataGuest = new Guest();
            $dataGuest->user_id = $newUser->id;
            $dataGuest->event_id = $request->event_id;
            $dataGuest->id_type = "KTP";
            $dataGuest->id_number = $request->nik;
            $dataGuest->name = $request->name;
            $dataGuest->address = $request->address;
            $dataGuest->mobile = $request->mobile;
            $dataGuest->save();

            DB::commit();
            return redirect(route('master.guest.index'))->with('swal-success', 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors(['Failed']);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $dataGuest = Guest::find($id);
            $dataUser = User::find($dataGuest->user_id);

            $dataUser->delete();
            $dataGuest->delete();
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
        $data = Guest::Join("users", "users.id", "guests.user_id")
            ->join("events", "events.id", "guests.event_id")
            ->select("guests.id", "users.name", "guests.address", "guests.mobile", "guests.id_number", "users.email", "events.name as event_name")->get();
        return DataTables::collection($data)
            ->addColumn('action', function ($d) {
                $html = '<a href="' . route('master.guest.edit', $d->id) . '" class="m-r-15 text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="mdi mdi-pencil font-18"></i></a>';
                $html .= '<a href="javascript:void(0)" onclick="deleteData(' . $d->id . ')" class="text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="mdi mdi-close font-18"></i></a>';
                return $html;
            })->make();
    }
}
