<?php

    namespace App\Http\Controllers;

    use App\Helpers\NotificationHelper;
    use App\Http\Controllers\Controller;
    use App\Mail\ResetAccount;
    use App\Models\Account\Personal;
    use App\Models\Master\Organization;
    use App\Models\Roles;
    use App\User;
    use Carbon\Carbon;
    use Faker\Provider\Person;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Mail;
    use Illuminate\Support\Facades\Redirect;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Str;
    use Illuminate\Validation\Rule;

    class AccountController extends Controller
    {

        public function profile()
        {
            $user = User::find(session('user_id'));
            $personal = Personal::where('user_id', $user->id)->first();
            $organization = Organization::find($personal->organization_id);
            $data = [
                "user" => $user,
                "personal" => $personal,
                "organization" => $organization,
            ];
            return view('account.profile', $data);
        }

        public function updateProfile(Request $request)
        {

            $organization = Organization::find($request['organization_id']);
            $personal = Personal::find($request['personal_id']);
            $user = User::find($request['user_id']);


            DB::beginTransaction();
            try {
                if ($organization->type != 'Individu') {
                    $organization->name = $request['organization_name'];
                    $organization->address = $request['organization_address'];
                    $organization->phone = $request['organization_phone'];
                    $organization->email = $request['organization_email'];
                    $organization->whatsapp = $request['mobile'];
                    $organization->save();
                }
                $user->name = $request['name'];
                $user->email = $request['email'];
                $user->save();

                $personal->name = $request['name'];
                $personal->address = $request['address'];
                $personal->mobile = $request['mobile'];
                $personal->email = $request['email'];
                $personal->save();

                DB::commit();
                return redirect(route('account.profile'))->with('swal-success', 'success');
            } catch (\Exception $e) {
                DB::rollBack();
                return Redirect::back()->withErrors(['Failed' . $e->getMessage()]);
            }
        }


        public function updatePassword(Request $request)
        {
            DB::beginTransaction();
            try {
                $user = User::find($request->post('user_id'));
                if (!empty($user)) {
                    $old_password = $request->post('old_password');
                    $new_password = $request->post('password');
                    if (Hash::check($old_password, $user->password)) {
                        $user->password = bcrypt($new_password);
                        $user->save();

                        DB::commit();
                        return redirect(route('account.profile'))->with('swal-success', 'success');
                    } else {
                        DB::commit();
                        return Redirect::back()->withErrors(['Gagal. Masukkan password yang benar']);

                    }
                } else {
                    DB::commit();
                    return Redirect::back()->withErrors(['Gagal. User tidak ditemukan']);
                }
            } catch (\Exception $e) {
                DB::rollBack();
                return Redirect::back()->withErrors(['Gagal.' . $e->getMessage()]);
            }
        }

        public function forgetPassword(Request $request)
        {
            $data = [];
            if ($request->isMethod('post')) {
                $user = User::where('email', $request->email)->first();
                if (!empty($user)) {
                    $personal = Personal::where('user_id', $user->id)->first();
                    $org = Organization::find($personal->organization_id);
                    $data['email'] = $user->email;
                    $data['password'] = Str::random(10);
                    // Send Email
                    Mail::to($data['email'])->send(new ResetAccount($data));
                    // Send Whatsapp
                    $notification_helper = new NotificationHelper();
                    $message = [
                        'message' => "Anda telah permintaan reset akun. [lb]" .
                            'Berikut ini adalah informasi akun anda yang baru :[lb][lb]' .
                            'Username : ' . $notification_helper->formattingBoldWhatsapp($data['email']) . " [lb]" .
                            'Password : ' . $notification_helper->formattingBoldWhatsapp($data['password']) . " [lb]",
                        'to_number' => $org->whatsapp,
                    ];
                    $notification_helper->send($message);
                    $user->password = bcrypt($data['password']);
                    $user->save();
                    $hide_email = substr($user->email, 0, 5) . '***' . substr($user->email, strpos($user->email, '@'), strlen($user->email));
                    $hide_whatsapp = substr($org->whatsapp, 0, 6) . '***';
                    return Redirect::back()->with('success-forget', 'Informasi akun telah di kirimkan ke email ' . $hide_email . ' atau whatsapp ' . $hide_whatsapp);
                } else {
                    return Redirect::back()->with('error-forget', 'Email tidak ditemukan');
                }
            }
            return view('auth.forget_password', $data);
        }

    }
