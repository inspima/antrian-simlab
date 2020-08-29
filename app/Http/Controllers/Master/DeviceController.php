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
use Yajra\DataTables\Facades\DataTables;

class DeviceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $route = "master.device.";

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
        $route = $this->route;
        return view($this->route . 'index', compact("route"));
    }

    public function delete(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $data = UserDevice::find($id);
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
        $data = UserDevice::Join("users", "users.id", "user_devices.user_id")
            ->select("user_devices.*", "users.name", "users.email")->get();
        return DataTables::collection($data)
            ->addColumn('action', function ($d) {
                $html = '<a href="javascript:void(0)" onclick="deleteData(' . $d->id . ')" class="text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="mdi mdi-close font-18"></i></a>';
                return $html;
            })->make();
    }
}
