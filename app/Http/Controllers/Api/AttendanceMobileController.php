<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account\Personal;
use App\Models\Attendance\Attendance;
use App\Models\General\LogError;
use App\Models\HR\Shift;
use App\Models\HR\ShiftDetail;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AttendanceMobileController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function sync(Request $request, $user_id)
    {
        return json_decode((object) Attendance::where('user_id', $user_id)->get());
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function scanQr(Request $request)
    {
        $result = [];
        $id = auth('api')->id();
        try {
            $qrcode = base64_decode($request->post('qrcode'));
            $qrexplode = explode('-', $qrcode);
            if (!empty($qrexplode)) {
                $user = User::find($qrexplode[1]);
                if (!empty($user)) {
                    $attendance_date = date('Y-m-d', strtotime($qrexplode[0]));
                    $attendance_time = date('Y-m-d H:i:s', strtotime($qrexplode[0]));
                    $attendance_time_only = date('H:i:s', strtotime($qrexplode[0]));
                    $attendance_type = $qrexplode[2];
                    $attendance = Attendance::where('date', $attendance_date)
                        ->where('user_id', $user->id)
                        ->first();
                    if (!empty($attendance)) {
                        if ($attendance_type == '1') {
                            $result = [
                                'status' => 1,
                                'message' => "Failed user already checkin"
                            ];
                        } else if ($attendance_type == '2') {
                            if ($attendance->out_time != '') {
                                $result = [
                                    'status' => 1,
                                    'message' => "Failed user already checkout"
                                ];
                            } else {
                                $attendance->out_time = $attendance_time;
                                $attendance->save();
                                $result = [
                                    'status' => 0,
                                    'message' => "Success",
                                    'data' => [
                                        'name' => $user->name,
                                        'type' => "Check Out",
                                        'time' => $attendance_time_only
                                    ]
                                ];
                            }
                        } else if ($attendance_type == '3') {
                            if ($attendance->rest_in_time != '') {
                                $result = [
                                    'status' => 1,
                                    'message' => "Failed user already checked for start Rest"
                                ];
                            } else {
                                $attendance->rest_in_time = $attendance_time;
                                $attendance->save();
                                $result = [
                                    'status' => 0,
                                    'message' => "Success",
                                    'data' => [
                                        'name' => $user->name,
                                        'type' => "Start Rest",
                                        'time' => $attendance_time_only
                                    ]
                                ];
                            }
                        } else if ($attendance_type == '4') {
                            if ($attendance->rest_out_time != '') {
                                $result = [
                                    'status' => 1,
                                    'message' => "Failed user already checked for end Rest"
                                ];
                            } else {
                                $attendance->rest_out_time = $attendance_time;
                                $attendance->save();
                                $result = [
                                    'status' => 0,
                                    'message' => "Success",
                                    'data' => [
                                        'name' => $user->name,
                                        'type' => "End Rest",
                                        'time' => $attendance_time_only
                                    ]
                                ];
                            }
                        }
                    } else {
                        if ($attendance_type == '1') {
                            $status = 0;
                            $personal = Personal::where("user_id", $user->id)->first();
                            if ($personal) {
                                $dayNumber = date("N");
                                $shift = Shift::find($personal->shift_id);
                                if (!empty($shift)) {
                                    $shiftDetail = ShiftDetail::where("shift_id", $shift->id)->where("work_day_id", $dayNumber)->first();
                                    if ($shiftDetail) {
                                        $shiftName = $shift->name;
                                        if ($shiftDetail->work_time) {
                                            $workTimeId = $shiftDetail->work_time->id;
                                            $workTimeStart = date("Y-m-d H:i:s", strtotime($shiftDetail->work_time->start_time));
                                            if ($attendance_time > $workTimeStart) {
                                                $status = 1; // late
                                            }
                                            Attendance::create(
                                                [
                                                    'user_id' => $user->id,
                                                    'work_time_id' => $workTimeId,
                                                    'shift_name' => $shiftName,
                                                    'date' => $attendance_date,
                                                    'in_time' => $attendance_time,
                                                    'status' => $status
                                                ]
                                            );
                                            $result = [
                                                'status' => 0,
                                                'message' => "Success",
                                                'data' => [
                                                    'name' => $user->name,
                                                    'type' => "Check In",
                                                    'time' => $attendance_time_only
                                                ]
                                            ];
                                        } else {
                                            $result = [
                                                'status' => 1,
                                                'message' => "Incorect shift time"
                                            ];
                                        }
                                    } else {
                                        $result = [
                                            'status' => 1,
                                            'message' => "Incorect shift data"
                                        ];
                                    }
                                } else {
                                    $result = [
                                        'status' => 1,
                                        'message' => "Shift not found"
                                    ];
                                }
                            } else {
                                $result = [
                                    'status' => 1,
                                    'message' => "Personal not found"
                                ];
                            }
                        } else {
                            $result = [
                                'status' => 1,
                                'message' => "Failed please check in first"
                            ];
                        }
                    }
                } else {
                    $result = [
                        'status' => 1,
                        'message' => "User not found"
                    ];
                }
            } else {
                $result = [
                    'status' => 1,
                    'message' => "Data not found"
                ];
            }
        } catch (\Exception $e) {
            LogError::create([
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'params' => json_encode($request->all()),
                'stack_trace' => $e->getTraceAsString(),
                'file' => $e->getMessage(),
                'url' => $request->fullurl(),
                'ip_source' => $request->ip(),
                'client_code' => '',
                'user_agent' => $request->header('User-Agent'),
                'error_code' => $e->getCode(),
                'http_code' => '500',
            ]);
            $result = [
                'status' => 1,
                'message' => "Sorry Internal Server Error"
            ];
        }

        return response()->json($result);
    }

    public function uploadPicture(Request $request)
    {
        $result = [];
        $id = auth('api')->id();
        try {
            $user = User::find($request->id);
            if (!empty($user)) {
                $attendance_date = date('Y-m-d', strtotime($request->time));
                $attendance_time = date('Y-m-d H:i:s', strtotime($request->time));
                $attendance_time_only = date('H:i:s', strtotime($request->time));
                $attendance_type = $request->type;
                $attendance_image = $request->image;
                $attendance_lat = $request->lat;
                $attendance_lng = $request->lng;
                $attendance_address = $request->address;
                $attendance = Attendance::where('date', $attendance_date)
                    ->where('user_id', $user->id)
                    ->first();
                if (!empty($attendance)) {
                    if ($attendance_type == '1') {
                        $result = [
                            'status' => 1,
                            'message' => "Failed user already checkin"
                        ];
                    } else if ($attendance_type == '2') {
                        if ($attendance->out_time != '') {
                            $result = [
                                'status' => 1,
                                'message' => "Failed user already checkout"
                            ];
                        } else {
                            $image =  $attendance_image;  // your base64 encoded
                            $image = str_replace('data:image/png;base64,', '', $image);
                            $image = str_replace(' ', '+', $image);
                            $imageName = 'OUT-' . str_pad($user->id, 5, '0', STR_PAD_LEFT) . date('YmdHis', strtotime($attendance_time)) . '.' . 'png';
                            File::put(storage_path('app/public') . '/attendances/' . $imageName, base64_decode($image));

                            $attendance->out_time = $attendance_time;
                            $attendance->out_pict = $imageName;
                            $attendance->out_lat = $attendance_lat;
                            $attendance->out_lng = $attendance_lng;
                            $attendance->out_address = $attendance_address;
                            $attendance->save();
                            $result = [
                                'status' => 0,
                                'message' => "Success",
                                'data' => [
                                    'name' => $user->name,
                                    'type' => "Check Out",
                                    'time' => $attendance_time_only
                                ]
                            ];
                        }
                    }
                } else {
                    if ($attendance_type == '1') {
                        $status = 0;
                        $personal = Personal::where("user_id", $user->id)->first();
                        if ($personal) {
                            $dayNumber = date("N");
                            $shift = Shift::find($personal->shift_id);
                            if (!empty($shift)) {
                                $shiftDetail = ShiftDetail::where("shift_id", $shift->id)->where("work_day_id", $dayNumber)->first();
                                if ($shiftDetail) {
                                    $shiftName = $shift->name;
                                    if ($shiftDetail->work_time) {
                                        $workTimeId = $shiftDetail->work_time->id;
                                        $workTimeStart = date("Y-m-d H:i:s", strtotime($shiftDetail->work_time->start_time));
                                        if ($attendance_time > $workTimeStart) {
                                            $status = 1; // late
                                        }
                                        $image =  $attendance_image;  // your base64 encoded
                                        $image = str_replace('data:image/png;base64,', '', $image);
                                        $image = str_replace(' ', '+', $image);
                                        $imageName = 'IN-' . str_pad($user->id, 5, '0', STR_PAD_LEFT) . date('YmdHis', strtotime($attendance_time)) . '.' . 'png';
                                        File::put(storage_path('app/public') . '/attendances/' . $imageName, base64_decode($image));
                                        Attendance::create(
                                            [
                                                'user_id' => $user->id,
                                                'work_time_id' => $workTimeId,
                                                'shift_name' => $shiftName,
                                                'date' => $attendance_date,
                                                'in_time' => $attendance_time,
                                                'in_pict' => $imageName,
                                                'in_address' => $attendance_address,
                                                'in_lat' => $attendance_lat,
                                                'in_lng' => $attendance_lng,
                                                'status' => $status
                                            ]
                                        );
                                        $result = [
                                            'status' => 0,
                                            'message' => "Success",
                                            'data' => [
                                                'name' => $user->name,
                                                'type' => "Check In",
                                                'time' => $attendance_time_only
                                            ]
                                        ];
                                    } else {
                                        $result = [
                                            'status' => 1,
                                            'message' => "Incorect shift time"
                                        ];
                                    }
                                } else {
                                    $result = [
                                        'status' => 1,
                                        'message' => "Incorect shift data"
                                    ];
                                }
                            } else {
                                $result = [
                                    'status' => 1,
                                    'message' => "Shift not found"
                                ];
                            }
                        } else {
                            $result = [
                                'status' => 1,
                                'message' => "Personal not found"
                            ];
                        }
                    } else {
                        $result = [
                            'status' => 1,
                            'message' => "Failed please check in first"
                        ];
                    }
                }
            } else {
                $result = [
                    'status' => 1,
                    'message' => "User not found"
                ];
            }
        } catch (\Exception $e) {
            LogError::create([
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'params' => json_encode($request->all()),
                'stack_trace' => $e->getTraceAsString(),
                'file' => $e->getMessage(),
                'url' => $request->fullurl(),
                'ip_source' => $request->ip(),
                'client_code' => '',
                'user_agent' => $request->header('User-Agent'),
                'error_code' => $e->getCode(),
                'http_code' => '500',
            ]);
            $result = [
                'status' => 1,
                'message' => "Sorry Internal Server Error"
            ];
        }

        return response()->json($result);
    }
}
