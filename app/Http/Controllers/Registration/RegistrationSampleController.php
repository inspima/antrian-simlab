<?php

    namespace App\Http\Controllers\Registration;

    use App\Helpers\NotificationHelper;
    use App\Helpers\TextformattingHelper;
    use App\Http\Controllers\Controller;
    use App\Models\Master\Holiday;
    use App\Models\Master\Organization;
    use App\Models\Process\QuotaOrganization;
    use App\Models\Process\QuotaQueue;
    use App\Models\Process\Registration;
    use App\Models\Process\RegistrationPatient;
    use App\Models\Process\RegistrationQueue;
    use App\Models\General\LogError;
    use Barryvdh\DomPDF\Facade as PDF;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Crypt;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Redirect;
    use Yajra\DataTables\Facades\DataTables;

    class RegistrationSampleController extends Controller
    {
        private $route = "registration.sample.";

        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct()
        {
            $this->middleware('auth');
        }

        private function getRegistrasiSimlab($no_registrasi)
        {
            $query = "select rp.*,p.*,i.nama_instansi,d.nama_dokter,pt.nama_pasien_tipe,p.nama nama_pasien,p.alamat alamat_pasien,d.gelar_depan,d.gelar_belakang
            from registrasi_pemeriksaan rp
            join pasien p on rp.id_pasien=p.id_pasien
            join instansi i on i.id_instansi=rp.id_instansi
            left join dokter d on d.id_dokter=rp.id_dokter_pengirim
            join pasien_tipe pt on pt.id_pasien_tipe =rp.id_pasien_tipe
            where rp.no_registrasi='{$no_registrasi}'";
            return collect(DB::connection('mysql-simlab')->select($query))->first();
        }

        private function getPasienPemeriksaanSimlab($no_registrasi)
        {
            $result = array();
            $query = "
            select pp.*,p.nilai_normal,p.flag_parent_group,p.nama_pengujian,p.kode_pengujian,s.nama_sample,peg.nama_pegawai nama_validator,rps.keterangan_sample
            from pasien_pemeriksaan pp
            join registrasi_pemeriksaan rp on rp.id_registrasi_pemeriksaan=pp.id_registrasi_pemeriksaan
            join pengujian p on pp.id_pengujian=p.id_pengujian
            left join registrasi_pasien_sample rps on rps.id_registrasi_pasien_sample=pp.id_registrasi_pasien_sample
            left join pegawai peg on peg.id_pegawai = pp.id_petugas_validasi
            left join sample s on s.id_sample = rps.id_sample
            where rp.no_registrasi='{$no_registrasi}'
            order by pp.id_pasien_pemeriksaan
            ";
            $data_pasien_pemeriksaan = DB::connection('mysql-simlab')->select($query);
            foreach ($data_pasien_pemeriksaan as $index => $d) {
                if ($d->flag_parent_group == '1') {
                    $query_child = "


				select p.*,p.id_pengujian as id_pengujian_child,pph.*,pph.keterangan as keterangan_hasil
				from pengujian p
                join pasien_pemeriksaan_hasil pph on pph.id_pengujian = p.id_pengujian and pph.id_registrasi_pemeriksaan='{$d->id_registrasi_pemeriksaan}'
                where p.id_pengujian_group ='{$d->id_pengujian}'";
                    $data_pengujian_child = DB::connection('mysql-simlab')->select($query_child);

                    //$data_pengujian_child = array();
                } else {
                    $data_pengujian_child = array();
                }
                $query_sample_pasien = "
                select rps.*,s.nama_sample,ps.id_pemeriksaan_sample
                from registrasi_pasien_sample rps
                join sample s on rps.id_sample=s.id_sample
                left join pemeriksaan_sample ps on ps.id_registrasi_pasien_sample =rps.id_registrasi_pasien_sample and ps.id_pasien_pemeriksaan='{$d->id_pasien_pemeriksaan}'
                where rps.id_registrasi_pemeriksaan='{$d->id_registrasi_pemeriksaan}'
                order by rps.waktu_masuk desc,s.nama_sample
                ";
                $data_sample = DB::connection('mysql-simlab')->select($query_sample_pasien);
                $data_pasien_pemeriksaan[$index]->data_sample = $data_sample;
                $data_pasien_pemeriksaan[$index]->data_child = $data_pengujian_child;
            }
            $result = $data_pasien_pemeriksaan;
            return $result;
        }


        public function select2(Request $request)
        {
            $resp = [
                'results' => [],
                "more" => false
            ];
            try {
                $q = strtolower($request->q);
                $data = Registration::selectRaw('id, name as text')->whereRaw("lower(name) like lower('%{$q}%')")->get();
                $resp['results'] = $data;
            } catch (\Exception $e) {
            }
            return response()->json($resp);
        }

        public function index()
        {
            $route = $this->route;
            return view($this->route . 'index', compact("route"));
        }

        public function edit(Request $request, $id)
        {
            $data = Registration::find($id);
            $quota_organisation = QuotaOrganization::where('organization_id', session("org_id"))->first();
            if (empty($quota_organisation)) {
                $quota_organisation = QuotaQueue::where('type', 'organization')->first();
            }
            $params = [
                "data" => $data,
                "quota" => $quota_organisation->quota,
                "route" => $this->route
            ];
            return view($this->route . 'form', $params);
        }

        public function detail(Request $request, $id)
        {
            $data = Registration::find($id);
            $quota_organisation = QuotaOrganization::where('organization_id', session("org_id"))->first();
            if (empty($quota_organisation)) {
                $quota_organisation = QuotaQueue::where('type', 'organization')->first();
            }
            $params = [
                "data" => $data,
                "quota" => $quota_organisation->quota,
                "route" => $this->route
            ];
            return view($this->route . 'detail', $params);
        }

        public function print(Request $request, $key)
        {
            $id = base64_decode($key);
            $reg = Registration::whereRaw('md5(id)=?', [$id])->first();
            $patiens = RegistrationPatient::where('registration_id', $reg->id)->get();
            $quota_organisation = QuotaOrganization::where('organization_id', session("org_id"))->first();
            if (empty($quota_organisation)) {
                $quota_organisation = QuotaQueue::where('type', 'organization')->first();
            }
            $params = [
                "reg" => $reg,
                "org" => $reg->organization,
                "patiens" => $patiens,
                "quota" => $quota_organisation->quota,
                "route" => $this->route
            ];
            PDF::setOptions(['defaultFont' => 'Trebuchet MS']);
            $pdf = PDF::loadView($this->route . 'print', $params);
            $pdf->setPaper('a4', 'portrait');
            $pdf->save(storage_path() . '_filename.pdf');
            return $pdf->stream('BUKTI-REGISTRASI-' . $reg->code . '.pdf', array("Attachment" => false));
            //             return view($this->route . 'print', $params);
        }

        public function printResult(Request $request, $key)
        {
            $id = base64_decode($key);
            $reg_patien = RegistrationPatient::whereRaw('md5(id)=?', [$id])->first();
            $reg = Registration::find($reg_patien->registration_id);
            $reg_simlab = $this->getRegistrasiSimlab($reg_patien->simlab_reg_code);
            $reg_patiens_simlabs = $this->getPasienPemeriksaanSimlab($reg_patien->simlab_reg_code);
            $user_pj = collect(DB::connection('mysql-simlab')->select("select * from pegawai where id_pegawai='73'"))->first();
            $params = [
                "reg" => $reg,
                "reg_patient" => $reg_patien,
                "reg_simlab" => $reg_simlab,
                "reg_patient_simlabs" => $reg_patiens_simlabs,
                'user_pj' => $user_pj,
                "route" => $this->route
            ];
            PDF::setOptions(['defaultFont' => 'Trebuchet MS']);
            $pdf = PDF::loadView($this->route . 'print-result', $params);
            $pdf->setPaper('a4', 'portrait');
            $pdf->save(storage_path() . '_filename.pdf');
            return $pdf->stream('HASIL-PEMERIKSAAN-' . $reg->code . '.pdf', array("Attachment" => false));
            // return view($this->route . 'print', $params);
        }

        public function create()
        {
            $data = new Registration();
            $count_data = Registration::where('organization_id', session("org_id"))->withTrashed()->count();
            $quota_organisation = QuotaOrganization::where('organization_id', session("org_id"))->first();
            if (empty($quota_organisation)) {
                $quota_organisation = QuotaQueue::where('type', 'organization')->first();
            }
            $params = [
                "generate_code" => session("org_code") . '/' . str_pad($count_data + 1, 5, '0', STR_PAD_LEFT),
                "quota" => $quota_organisation->quota,
                "data" => $data,
                "route" => $this->route
            ];
            return view($this->route . 'form', $params);
        }

        public function update(Request $request, $id)
        {
            request()->validate([
                'date' => 'required',
            ]);

            DB::beginTransaction();
            try {
                $data = Registration::find($id);
                $data->description = $request->description;
                $data->save();
                $name = $request->name;
                $nik = $request->nik;
                $born_date = $request->born_date;
                $gender = $request->gender;
                $address = $request->address;
                $no_hp = $request->no_hp;
                $test_loop = $request->test_loop;
                if ($request->jumlah_data > 0) {
                    RegistrationPatient::where('registration_id', $data->id)->forceDelete();
                }
                for ($i = 0; $i < $request->jumlah_data; $i++) {
                    if (!empty($name[$i]) && !empty($nik[$i])) {
                        $data_patient = new RegistrationPatient();
                        $data_patient->registration_id = $data->id;
                        $data_patient->id_type = 'KTP';
                        $data_patient->id_number = $nik[$i];
                        $data_patient->name = $name[$i];
                        $data_patient->born_date = $born_date[$i];
                        $data_patient->age = Carbon::parse($born_date[$i])->age;
                        $data_patient->gender = $gender[$i];
                        $data_patient->address = $address[$i];
                        $data_patient->mobile = $no_hp[$i];
                        $data_patient->test_loop = $test_loop[$i];
                        $data_patient->save();
                    }
                }

                DB::commit();
                return redirect(route($this->route . 'index'))->with('swal-success', 'success');
            } catch (\Exception $e) {
                DB::rollBack();
                LogError::create([
                    'message' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'params' => json_encode([$request->all()]),
                    'stack_trace' => $e->getTraceAsString(),
                    'file' => $e->getFile(),
                    'url' => $request->fullurl(),
                    'ip_source' => $request->ip(),
                    'client_code' => $data->code,
                    'user_agent' => $request->header('User-Agent'),
                    'error_code' => $e->getCode(),
                    'http_code' => '500',
                ]);
                return Redirect::back()->withErrors(['Gagal menyimpan, silahkan periksa data anda']);
            }
        }

        public function store(Request $request)
        {
            request()->validate([
                'date' => 'required',
            ]);
            DB::beginTransaction();
            try {
                $data = new Registration();
                $data->code = $request->code;
                $data->organization_id = session('org_id');
                $data->description = $request->description;
                $data->date = $request->date;
                $data->all_new_record = $request->all_new_record;
                $data->save();
                $name = $request->name;
                $nik = $request->nik;
                $born_date = $request->born_date;
                $gender = $request->gender;
                $address = $request->address;
                $no_hp = $request->no_hp;
                $test_loop = $request->test_loop;
                for ($i = 0; $i < $request->jumlah_data; $i++) {
                    if (!empty($name[$i]) && !empty($nik[$i])) {
                        $data_patient = new RegistrationPatient();
                        $data_patient->registration_id = $data->id;
                        $data_patient->id_type = 'KTP';
                        $data_patient->id_number = $nik[$i];
                        $data_patient->name = $name[$i];
                        $data_patient->born_date = $born_date[$i];
                        $data_patient->age = Carbon::parse($born_date[$i])->age;
                        $data_patient->gender = $gender[$i];
                        $data_patient->address = $address[$i];
                        $data_patient->mobile = $no_hp[$i];
                        $data_patient->test_loop = $test_loop[$i];
                        $data_patient->save();
                    }
                }
                DB::commit();
                return redirect(route($this->route . 'index'))->with('swal-success', 'success');
            } catch (\Exception $e) {
                DB::rollBack();
                LogError::create([
                    'message' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'params' => json_encode([$request->all()]),
                    'stack_trace' => $e->getTraceAsString(),
                    'file' => $e->getFile(),
                    'url' => $request->fullurl(),
                    'ip_source' => $request->ip(),
                    'client_code' => $data->code,
                    'user_agent' => $request->header('User-Agent'),
                    'error_code' => $e->getCode(),
                    'http_code' => '500',
                ]);
                return Redirect::back()->withErrors(['Gagal menyimpan, silahkan periksa data anda']);
            }
        }

        public function delete(Request $request, $id)
        {
            DB::beginTransaction();
            try {
                $data = Registration::find($id);
                $data->delete();
                DB::commit();
                return response()->json([
                    'message' => 'success',
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'message' => $e->getMessage(),
                ], 500);
            }
        }

        public function send(Request $request, $id)
        {
            DB::beginTransaction();
            try {
                $this->searchQueue(date('Y-m-d'), $id);
                $reg = Registration::find($id);
                $org = Organization::find($reg->organization_id);
                $reg_patients = RegistrationPatient::where('registration_id', $reg->id)->get();
                // Send Notification
                $notification_helper = new NotificationHelper();
                $list_patient_str = '';
                foreach ($reg_patients as $index => $patient) {
                    $list_patient_str .= ($index + 1) . '. ' . $patient->name . '[lb]';
                }
                $data = [
                    'message' => "Pendaftaran anda diterima, silahkan datang pada [lb]" .
                        'Hari / Tanggal : ' . Carbon::parse($reg->queue_date)->translatedFormat('l, d F Y') . '[lb] ' .
                        'Waktu : 08.00 -09.00 WIB [lb][lb]' .
                        'Daftar nama pasien pengirim sample [lb]' .
                        $list_patient_str . '[lb]' .
                        'Harap Print kemudian bawa bukti pendaftaran, dari link dibawah ini [lb][lb]' .
                        route('registration.sample.print', base64_encode(md5($reg->id))) . '[lb]',
                    'to_number' => $org->whatsapp,
                ];
                $notification_helper->send($data);
                DB::commit();
                return response()->json([
                    'message' => 'success',
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'message' => $e->getMessage(),
                ], 500);
            }
        }

        public function searchQueue($date, $id)
        {
            try {
                $date_queue = date('Y-m-d', strtotime($date . ' +1 day'));
                $holidays = Holiday::get()->pluck('date')->toArray();
                if (date('N', strtotime($date_queue)) != '6' && date('N', strtotime($date_queue)) != '7' && !in_array($date_queue, $holidays)) {
                    $registraion_queue = RegistrationQueue::where('date', $date_queue)->first();
                    if (empty($registraion_queue)) {
                        // create new registration queue
                        $count_data = RegistrationQueue::withTrashed()->count();
                        $quota_queue = QuotaQueue::where('type', 'day')->first();
                        $registraion_queue = new RegistrationQueue();
                        $registraion_queue->code = 'ANTRIAN/' . date('Ymd') . '/' . str_pad($count_data + 1, 5, '0', STR_PAD_LEFT);
                        $registraion_queue->date = $date_queue;
                        $registraion_queue->quota = $quota_queue->quota;
                        $registraion_queue->save();
                        // set queue to current registration
                        $data = Registration::find($id);
                        $registration_patient = RegistrationPatient::where('registration_id', $id)->get();
                        $data->queue_code = $registraion_queue->code;
                        $data->queue_date = $registraion_queue->date;
                        $data->status = '1';
                        $data->save();
                        $registraion_queue->filled = $registraion_queue->filled + $registration_patient->count();
                        $registraion_queue->save();
                    } else {
                        $registration_patient = RegistrationPatient::where('registration_id', $id)->get();
                        // set queue to current registration
                        // if queue is available
                        if ($registraion_queue->filled + $registration_patient->count() <= $registraion_queue->quota) {
                            $data = Registration::find($id);
                            $data->queue_code = $registraion_queue->code;
                            $data->queue_date = $registraion_queue->date;
                            $data->status = '1';
                            $data->save();
                            $registraion_queue->filled = $registraion_queue->filled + $registration_patient->count();
                            $registraion_queue->save();
                        } else {
                            $this->searchQueue($date_queue, $id);
                        }
                    }
                } else {
                    $this->searchQueue($date_queue, $id);
                }
            } catch (\Exception $e) {
                throw $e;
            }
        }

        public function datatable(Request $request)
        {
            \Carbon\Carbon::setLocale('id');
            $data = Registration::where('organization_id', session('org_id'))->orderByDesc('id')->get();
            return DataTables::collection($data)
                ->editColumn('status', function ($d) {
                    if ($d->status == '0') {
                        $html = '<span class="badge badge-blue-grey font-14">Draft</span>';
                    } else if ($d->status == '1') {
                        $html = '<span class="badge badge-success font-14">Terkirim</span>';
                    }
                    return $html;
                })
                ->editColumn('date', function ($d) {
                    return Carbon::parse($d->date)->translatedFormat('l, d F Y');
                })
                ->editColumn('queue', function ($d) {
                    if ($d->status == '0' || empty($d->queue_date)) {
                        $html = '<span class="badge badge-danger font-14">Kosong</span>';
                    } else {
                        $html = "<b>Kode</b><br/>";
                        $html .= "{$d->queue_code}<br/>";
                        $html .= "<b>Tanggal</b><br/>";
                        $html .= Carbon::parse($d->queue_date)->translatedFormat('l, d F Y');
                    }
                    return $html;
                })
                ->editColumn('action', function ($d) {
                    if ($d->status == '0') {
                        $html = '<a href="' . route($this->route . 'edit', $d->id) . '" class="m-r-15 text-muted" data-toggle="tooltip" data-placement="bottom" title="Ubah" data-original-title="Edit"><i class="mdi mdi-pencil font-20"></i></a>';
                        $html .= '<a href="javascript:void(0)" onclick="sendData(' . $d->id . ')" class="m-r-15 text-primary" data-toggle="tooltip" data-placement="bottom" title="Kirim" data-original-title="Kirim"><i class="fa fa-send font-20"></i></a>';
                        $html .= '<a href="javascript:void(0)" onclick="deleteData(' . $d->id . ')" class="text-danger" data-toggle="tooltip" data-placement="bottom" title="Hapus" data-original-title="Delete"><i class="mdi mdi-close font-20"></i></a>';
                    } else if ($d->status == '1') {
                        $html = '<a target="_blank" href="' . route($this->route . 'print', base64_encode(md5($d->id))) . '" class="m-r-15 text-primary" data-toggle="tooltip" data-placement="bottom" title="Print" data-original-title="Edit"><i class="ion-printer font-20"></i></a>';
                        $html .= '<a href="' . route($this->route . 'detail', $d->id) . '" class="m-r-15 text-muted" data-toggle="tooltip" data-placement="bottom" title="Detail" data-original-title="Edit"><i class="ion-android-information font-20"></i></a>';
                    }
                    return $html;
                })
                ->rawColumns(['action', 'status', 'date', 'queue', 'time'])
                ->make(true);
        }
    }
