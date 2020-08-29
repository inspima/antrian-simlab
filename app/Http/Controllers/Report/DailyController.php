<?php


namespace App\Http\Controllers\Report;

use App\Exports\AttendanceExport;
use App\Http\Controllers\Controller;
use App\Models\Attendance\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class DailyController extends Controller
{
    private $route = "report.daily.";

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view($this->route . 'index');
    }


    public function datatable(Request $request)
    {
        $data = Attendance::Join("users", "users.id", "attendances.user_id");
        if ($request['date']) {
            $data->where("date", $request['date']);
        }
        return DataTables::collection($data->get())
            ->addColumn('date', function ($d) use ($request) {
                return $request['date'];
            })
            ->addColumn('work_time', function ($d) {
                $wt = "";
                if ($d->work_time) {
                    $wt = $d->work_time->start_time . " - " . $d->work_time->end_time;
                }
                return $wt;
            })
            ->editColumn('in_time', function ($d) {
                $in = "";
                if ($d->in_time) {
                    $in = date("H:i:s", strtotime($d->in_time));
                }
                if (!empty($d->in_pict)) {
                    $in .= '<br/>';
                    $in_title = '<hr/><b>Location Address</b><br/>' . $d->in_address . "<br/> <a class='btn btn-sm btn-danger waves-effect waves-light' target='_blank' href='https://www.google.com/maps/place/" . str_replace(' ', '+', $d->in_address) . "'>Show Map</a>";
                    $in_button = '<button type="button" class="btn btn-sm btn-secondary waves-effect waves-light" data-toggle="modal" data-target="#modal-in-' . $d->id . '">Image</button>';
                    $in_modal = '<div class="modal fade" id="modal-in-' . $d->id . '" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title mt-0" id="myLargeModalLabel">Detail Image</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <div class="modal-body  text-center">
                                        <b>Picture</b><br/>
                                            <img class="img-responsive" src="' . URL::asset('storage/attendances/' . $d->in_pict) . '"  width="200"><br/>
                                            ' . $in_title . '
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div>';
                    $in .= $in_button . $in_modal;
                }
                return $in;
            })
            ->editColumn('out_time', function ($d) {
                $in = "";
                if ($d->out_time) {
                    $in = date("H:i:s", strtotime($d->out_time));
                }
                if (!empty($d->out_pict)) {
                    $in .= '<br/>';
                    $in_title = '<hr/><b>Location Address</b><br/>' . $d->out_address . "<br/> <a class='btn btn-sm btn-danger waves-effect waves-light' target='_blank' href='https://www.google.com/maps/place/" . str_replace(' ', '+', $d->out_address) . "'>Show Map</a>";
                    $in_button = '<button type="button" class="btn btn-sm btn-secondary waves-effect waves-light" data-toggle="modal" data-target="#modal-out-' . $d->id . '">Image</button>';
                    $in_modal = '<div class="modal fade" id="modal-out-' . $d->id . '" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title mt-0" id="myLargeModalLabel">Detail Image</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <b>Picture</b><br/>
                                            <img class="img-responsive" src="' . URL::asset('storage/attendances/' . $d->out_pict) . '"  width="200"><br/>
                                            ' . $in_title . '
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div>';
                    $in .= $in_button . $in_modal;
                }
                return $in;
            })->editColumn('rest_in_time', function ($d) {
                $in = "";
                if ($d->rest_in_time) {
                    $in = date("H:i:s", strtotime($d->rest_in_time));
                }
                return $in;
            })->editColumn('rest_out_time', function ($d) {
                $in = "";
                if ($d->rest_out_time) {
                    $in = date("H:i:s", strtotime($d->rest_out_time));
                }
                return $in;
            })
            ->rawColumns(['in_time', 'out_time'])
            ->make();
    }

    public function excel(Request $request)
    {
        $export = new AttendanceExport();
        $export->date($request['date']);
        return Excel::download($export, 'daily_attendance_' . $request['date'] . '.xlsx');
    }
}
