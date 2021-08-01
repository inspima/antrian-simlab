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
            $reg_simlab = SimlabHelper::getRegistrasiSimlabByIdMd5($id);
            if (!empty($reg_simlab)) {
                $reg_patiens_simlabs = SimlabHelper::getPasienPemeriksaanSimlabByIdMd5($id);
                $user_pj = collect(DB::connection('mysql-simlab')->select("select * from pegawai where id_pegawai='73'"))->first();
                $params = [
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
