<?php

    namespace App\Http\Controllers\Api;

    use App\Helpers\NotificationHelper;
    use App\Http\Controllers\Controller;
    use App\Models\General\LogError;
    use App\Models\Master\Organization;
    use App\Models\Process\Registration;
    use App\Models\Process\RegistrationPatient;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\File;

    class ApiRegistrasiController extends Controller
    {
        public function verifyCode(Request $request)
        {
            $reg_code = $request->post('reg_code');
            $verify_code = $request->post('ver_code');
            try {
                $reg_patient = RegistrationPatient::where('simlab_reg_code', $reg_code)->first();
                if (!empty($reg_patient)) {
                    if ($reg_patient->simlab_verify_code == $verify_code) {
                        return response()->json([
                            'status' => 1,
                            'message' => "Success"
                        ]);
                    } else {
                        return response()->json([
                            'status' => 0,
                            'message' => "Failed. Wrong verification code".$verify_code
                        ]);
                    }

                } else {
                    return response()->json([
                        'status' => 0,
                        'message' => "Failed. Data Not found"
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 0,
                    'message' => "Failed." . $e->getMessage()
                ]);
            }
        }

        public function updateStatus(Request $request,$id)
        {
            $status = $request->get('status');
            try {
                $reg_patient = RegistrationPatient::find($id);
                if (!empty($reg_patient)) {
                    $verify_code = rand(1000, 9999);
                    $reg_patient->sync_status = $status;
                    $reg_patient->simlab_verify_code = $verify_code;
                    $reg_patient->save();
                    $reg = Registration::where('id', $reg_patient->registration_id)->first();
                    $org = Organization::where('id', $reg->organization_id)->first();
                    // Send Notification
                    $notification_helper = new NotificationHelper();
                    $data = [
                        'message' => "Hasil Pemeriksaan dengan kode " . $reg->code . ' sudah selesai [lb]' .
                            'Atas Nama ' . $reg_patient->name . ' [lb][lb]' .
                            'Hasil bisa diambil langsung [lb]' .
                            'Atau cek link dibawah ini untuk melihat hasil [lb][lb]' .
                            route('registration.sample.print-result',$reg_patient->id) . '[lb]',
                        'to_number' => $org->whatsapp,
                    ];
                    $notification_helper->send($data);
                    return response()->json([
                        'status' => 1,
                        'message' => "Success"
                    ]);
                } else {
                    return response()->json([
                        'status' => 0,
                        'message' => "Failed. Not found"
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 0,
                    'message' => "Failed." . $e->getMessage()
                ]);
            }
        }

    }
