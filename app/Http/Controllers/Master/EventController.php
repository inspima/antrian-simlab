<?php namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Attendance\Event;
use App\Models\Organization\Company;
use Illuminate\Http\Request;

class EventController extends Controller
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


    public function select2(Request $request)
    {
        $resp = [
            'results' => [],
            "more" => false
        ];
        try {
            $q = strtolower($request->q);
            $data = Event::selectRaw('id, name as text')->whereRaw("lower(name) like lower('%{$q}%')")->get();
            $resp['results'] = $data;
        } catch (\Exception $e) {

        }
        return response()->json($resp);
    }
}
