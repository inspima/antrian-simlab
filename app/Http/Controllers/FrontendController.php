<?php

    namespace App\Http\Controllers;

    use App\Helpers\SimlabHelper;
    use App\Models\Process\Registration;
    use App\Models\Process\RegistrationPatient;
    use Barryvdh\DomPDF\Facade as PDF;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use SimpleSoftwareIO\QrCode\Facade as QrCode;

    class FrontendController extends Controller
    {
        public function validationResult(Request $request, $key)
        {
            $id = base64_decode($key);
            $reg_patien = RegistrationPatient::whereRaw('md5(id)=?', [$id])->first();
            if (!empty($reg_patien)) {
                $reg = Registration::find($reg_patien->registration_id);
                $reg_simlab = SimlabHelper::getRegistrasiSimlab($reg_patien->simlab_reg_code);
                $reg_patiens_simlabs = SimlabHelper::getPasienPemeriksaanSimlab($reg_patien->simlab_reg_code);
                $user_pj = collect(DB::connection('mysql-simlab')->select("select * from pegawai where id_pegawai='73'"))->first();
                $params = [
                    "reg" => $reg,
                    "reg_patient" => $reg_patien,
                    "reg_simlab" => $reg_simlab,
                    "reg_patient_simlabs" => $reg_patiens_simlabs,
                    'user_pj' => $user_pj,
                ];
                return view('validation-result', $params);
            } else {
                return view('errors.404');
            }
        }
    }
