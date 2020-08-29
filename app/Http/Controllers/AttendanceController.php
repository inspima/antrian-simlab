<?php

namespace App\Http\Controllers;

use App\Models\Account\Personal;
use App\Models\Attendance\Attendance;
use App\Models\General\Setting;
use App\Models\HR\Shift;
use App\Models\HR\ShiftDetail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class AttendanceController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [
            "voice" => "file_voice",
            "voice_uri" => "",
            "voice_rate" => 1,
            "voice_pitch" => 1,
            "voice_lang" => "en-US",
        ];
        $voice = Setting::where("code", 'voice')->first();
        $voice_uri = Setting::where("code", 'voice_uri')->first();
        $voice_rate = Setting::where("code", 'voice_rate')->first();
        $voice_pitch = Setting::where("code", 'voice_pitch')->first();
        $voice_lang = Setting::where("code", 'voice_lang')->first();

        $data["voice"] = ($voice) ? $voice->value : $data["voice"];
        $data["voice_uri"] = ($voice_uri) ? $voice_uri->value : $data["voice"];
        $data["voice_rate"] = ($voice_rate) ? $voice_rate->value : $data["voice_rate"];
        $data["voice_pitch"] = ($voice_pitch) ? $voice_pitch->value : $data["voice_pitch"];
        $data["voice_lang"] = ($voice_lang) ? $voice_lang->value : $data["voice_lang"];

        return view('attendance.index', $data);
    }

    public function check(Request $request)
    {
        $response = [];
        $response["audio"] = URL::asset('assets/audio/silahkan_coba_lagi.mp3');
        if ($request->data) {
            $decodedString = base64_decode($request->data);
            if ($decodedString) {
                $explodedString = explode('-', $decodedString);
                if (count($explodedString) == 4) {
                    $dateTime = date('Y-m-d H:i:s', strtotime($explodedString[0]));
                    $date = date('Y-m-d', strtotime($explodedString[0]));

                    $setting = Setting::where("code", "qr_time")->first();
                    $secondLimit = (int)$setting->value;
                    if ($secondLimit < 1) {
                        $secondLimit = 10;
                    }
                    $dateNowMinus = date('Y-m-d H:i:s', time() - $secondLimit);
                    if ($dateTime >= $dateNowMinus) {
                        $userId = $explodedString[1];
                        $checkStatus = $explodedString[2];
                        $user = User::find($userId);
                        if ($user) {
                            $workTimeId = null;
                            $status = 0;
                            $shiftName = null;

                            $attendance = Attendance::where("user_id", $user->id)->whereRaw("DATE(date)='" . $date . "'")->first();
                            if ($checkStatus == 1) { // checkin
                                if (is_null($attendance)) {
                                    $dayNumber = date("N");
                                    $personal = Personal::where("user_id", $userId)->first();
                                    if ($personal) {
                                        $shift = Shift::withTrashed()->find($personal->shift_id);
                                        $shiftDetail = ShiftDetail::where("shift_id", $shift->id)->where("work_day_id", $dayNumber)->first();
                                        if ($shiftDetail) {
                                            $shiftName = $shift->name;
                                            if ($shiftDetail->work_time) {
                                                $workTimeId = $shiftDetail->work_time->id;
                                                $workTimeStart = date("Y-m-d H:i:s", strtotime($shiftDetail->work_time->start_time));
                                                if ($dateTime > $workTimeStart) {
                                                    $status = 1; // late
                                                }
                                            }
                                        }
                                    }

                                    $data = new Attendance();
                                    $data->user_id = $user->id;
                                    $data->work_time_id = $workTimeId;
                                    $data->shift_name = $shiftName;
                                    $data->date = $date;
                                    $data->in_time = $dateTime;
                                    $data->status = $status;
                                    $data->save();
                                    $response["message"] = "Selamat Datang " . $user->name;
                                    $response["audio"] = URL::asset('assets/audio/selamat_datang.mp3');
                                    $response["status"] = 200;
                                } else {
                                    $response["message"] = $user->name . ", Anda Telah Checkin";
                                    $response["audio"] = URL::asset('assets/audio/anda_telah_checkin.mp3');
                                    $response["status"] = 200;
                                }
                            } else if (!is_null($attendance)) {
                                if ($checkStatus == 2) { // check out
                                    $attendance->out_time = $dateTime;
                                    $attendance->save();
//                                    $response["message"] = "Sampai Jumpa " . $user->name;
                                    $response["message"] = $user->name . ", Sampai Jumpa";
//                                    $response["message"] = "Sampai Jumpa";
                                    $response["audio"] = URL::asset('assets/audio/sampai_jumpa.mp3');
                                    $response["status"] = 200;
                                } elseif ($checkStatus == 3) { // rest in
                                    $attendance->rest_in_time = $dateTime;
                                    $attendance->save();
//                                    $response["message"] = "Selamat Istirahat " . $user->name;
                                    $response["message"] = $user->name . ", Selamat Istirahat";
//                                    $response["message"] = "Selamat Istirahat";
                                    $response["audio"] = URL::asset('assets/audio/selamat_istirahat.mp3');
                                    $response["status"] = 200;
                                } elseif ($checkStatus == 4) { // rest out
                                    $attendance->rest_out_time = $dateTime;
                                    $attendance->save();
//                                    $response["message"] = "Selamat Bekerja Kembali " . $user->name;
                                    $response["message"] = $user->name . ", Selamat Bekerja Kembali";
//                                    $response["message"] = "Selamat Bekerja Kembali";
                                    $response["audio"] = URL::asset('assets/audio/selamat_bekerja_kembali.mp3');
                                    $response["status"] = 200;
                                } else {
                                    $response["message"] = "Invalid Status";
                                    $response["status"] = 400;
                                }
                            } else {
                                $response["message"] = "Invalid Code";
                                $response["status"] = 400;
                            }

                        } else {
                            $response["message"] = "User Not Found";
                            $response["status"] = 400;
                        }
                    } else {
                        $response["message"] = "Invalid Code";
                        $response["status"] = 400;
                    }
                } else {
                    $response["message"] = "Invalid Token";
                    $response["status"] = 400;
                }
            } else {
                $response["message"] = "Invalid Token";
                $response["status"] = 400;
            }
        } else {
            $response["message"] = "Invalid Token";
            $response["status"] = 400;
        }
        return response()->json($response, $response["status"]);
    }

    public function getCode(Request $request)
    {
        dd(base64_encode(date("Y/m/d H:i:s") . "-1-{$request->status}-0"));
    }
}
