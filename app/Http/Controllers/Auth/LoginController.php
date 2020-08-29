<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\General\Setting;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticated(Request $request, $user)
    {
        $setting = Setting::where("code", "work_group_allow")->first();
        $allowWorkGroupIDs= [];
        if($setting) {
            $allowWorkGroupIDs = \GuzzleHttp\json_decode($setting->value);
        }
        if(Auth::check()){
            if($user->personal){
                if(!in_array($user->personal->work_group_id, $allowWorkGroupIDs)){
                    Auth::logout();
                    return redirect('/login')
                        ->withErrors( 'You dont have permission account');
                }
            }else{
                Auth::logout();
            }
        }
    }
}
