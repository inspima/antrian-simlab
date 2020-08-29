<?php

namespace App\Http\Controllers\Setting;

use App\Models\Account\Personal;
use App\Models\Account\UserDevice;
use App\Models\General\Setting;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class GeneralController extends Controller
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
        return view('setting.general.index');
    }

    public function edit(Request $request, $id)
    {
        $dataUser = Setting::find($id);

        $params = [
            "data" => $dataUser,
        ];
        return view('setting.general.form', $params);
    }


    public function update(Request $request, $id)
    {

        request()->validate([
            'name' => 'required|max:50',
            'value' => 'required',
        ]);


        DB::beginTransaction();
        try {
            $data = Setting::find($id);
//            $data->name = $request->name;
//            $data->description = $request->description;
            $data->value = $request->value;
            $data->save();
            DB::commit();
            return redirect(route('setting.general.index'))->with('swal-success', 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors(['Failed']);
        }
    }

    public function datatable(Request $request)
    {
        $data = Setting::all();
        return DataTables::collection($data)
            ->addColumn('action', function ($d) {
                $html = '<a href="' . route('setting.general.edit', $d->id) . '" class="m-r-15 text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="mdi mdi-pencil font-18"></i></a>';
                return $html;
            })->make();
    }
}
