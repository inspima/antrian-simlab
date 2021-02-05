<?php

    namespace App\Http\Controllers\Auth;

    use App\User;
    use App\Http\Controllers\Controller;
    use App\Mail\NewUserRegistration;
    use App\Models\Account\Personal;
    use App\Models\Account\Role;
    use App\Models\Master\Organization;
    use Illuminate\Auth\Events\Registered;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Foundation\Auth\RegistersUsers;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Mail;
    use Illuminate\Support\Facades\Redirect;
    use Illuminate\Support\Str;
    use Illuminate\Http\Request;

    class RegisterController extends Controller
    {
        /*
        |--------------------------------------------------------------------------
        | Register Controller
        |--------------------------------------------------------------------------
        |
        | This controller handles the registration of new users as well as their
        | validation and creation. By default this controller uses a trait to
        | provide this functionality without requiring any additional code.
        |
        */

        use RegistersUsers;

        /**
         * Where to redirect users after registration.
         *
         * @var string
         */
        protected $redirectTo = '/login';

        /**
         * Get a validator for an incoming registration request.
         *
         * @param array $data
         * @return \Illuminate\Contracts\Validation\Validator
         */
        protected function validator(array $data)
        {
            return Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'max:255'],
                'contact_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);
        }

        /**
         * Create a new user instance after a valid registration.
         *
         * @param array $data
         * @return array $response
         */
        protected function create(array $data)
        {
            DB::beginTransaction();
            try {
                $data['password'] = Str::random(10);
                $organization_count = Organization::withTrashed()->count();
                $code = '';
                if ($data['type'] == 'Rumah Sakit') {
                    $code = "RS/" . str_pad($organization_count + 1, 6, "0", STR_PAD_LEFT);
                } else if ($data['type'] == 'Instansi Pemerintah') {
                    $code = "INST/" . str_pad($organization_count + 1, 6, "0", STR_PAD_LEFT);
                } else if ($data['type'] == 'Perusahaan') {
                    $code = "PT/" . str_pad($organization_count + 1, 6, "0", STR_PAD_LEFT);
                } else if ($data['type'] == 'Individu') {
                    $code = "INDV/" . str_pad($organization_count + 1, 6, "0", STR_PAD_LEFT);
                }
                $organization = new Organization();
                $organization->code = $code;
                $organization->name = $data['name'];
                $organization->type = $data['type'];
                $organization->address = $data['address'];
                $organization->phone = $data['phone'];
                $organization->whatsapp = '+62' . substr($data['whatsapp'], 1);
                $organization->email = $data['email'];
                $organization->contact_name = $data['contact_name'];
                $organization->save();

                $user = User::create([
                    'name' => $data['contact_name'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
                    'role' => Role::find(2)->name,
                ]);
                Personal::create([
                    'user_id' => $user->id,
                    'organization_id' => $organization->id,
                    'name' => $user->name,
                    'address' => $organization->address,
                ]);
                DB::commit();
                Mail::to($data['email'])->send(new NewUserRegistration($data));
                return [
                    'status' => 1,
                    'message' => 'Registrasi Sukses. Silahkan cek email.',
                    'user' => $user,
                ];
            } catch (\Exception $e) {
                DB::rollBack();
                return [
                    'status' => 0,
                    'message' => 'Failed. ' . $e->getMessage(),
                ];
            }


        }

        public function register(Request $request)
        {
            try {
                $this->validator($request->all())->validate();
                $create_result = $this->create($request->all());
                if ($create_result['status']) {
                    event(new Registered($create_result['user']));
                    return redirect($this->redirectPath())->with('toast-success', 'success')->with('success', 'Registrasi Sukses. Silahkan cek email.');
                } else {
                    return redirect($this->redirectPath())->withErrors($create_result['message']);
                }
            } catch (\Exception $e) {
                return redirect($this->redirectPath())->withErrors($e->getMessage());
            }


        }
    }
