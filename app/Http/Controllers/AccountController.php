<?php

    namespace App\Http\Controllers;

    use App\Http\Controllers\Controller;
    use App\Models\Account\Personal;
    use App\Models\Master\Organization;
    use App\Models\Roles;
    use App\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Redirect;
    use Illuminate\Support\Facades\Validator;
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


    }
