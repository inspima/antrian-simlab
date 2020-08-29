<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account\Personal;
use App\Models\Account\UserDevice;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $manufacture = $request->post('manufacture');
        $brand = $request->post('brand');
        $model = $request->post('model');
        $imei = $request->post('imei');
        $serial = $request->post('serial');
        $device_id = $request->post('device_id');
        $credentials = request(['email', 'password']);
        if (empty($imei) && empty($serial)) {
            return response()->json(['error' => 'Failed. Deny to access Device ID '], 401);
        }
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Failed. User/Password not found'], 401);
        }
        $user = User::find(auth('api')->id());
        $user_device = UserDevice::where('user_id', $user->id)
            ->first();
        if (!empty($user_device)) {
            $user_device_check = UserDevice::where('user_id', $user->id)
                ->where(function ($query) use ($device_id, $serial) {
                    $query->where('device_id', $device_id)
                        ->OrWhere('serial', $serial);
                })
                ->first();
            if (empty($user_device_check)) {
                return response()->json(['error' => 'Failed. Device not recognized'], 401);
            }
        } else {
            UserDevice::create([
                'user_id' => $user->id,
                'manufacture' => $manufacture,
                'brand' => $brand,
                'model' => $model,
                'imei' => $imei,
                'serial' => $serial,
                'device_id' => $device_id,
            ]);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(Request $request)
    {
        try {
            $user = User::find(auth('api')->id());
            if (!empty($user)) {
                $old_password = $request->post('old_password');
                $new_password = $request->post('new_password');
                if (Hash::check($old_password, $user->password)) {
                    $user->password = bcrypt($new_password);
                    $user->save();
                    return response()->json([
                        'user' => $user,
                    ]);
                } else {
                    return response()->json(['error' => 'Failed. Please input correct current password. '], 401);
                }
            } else {
                return response()->json(['error' => 'Failed. User not found'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed.' . $e->getMessage()], 401);
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $user = User::find(auth('api')->id());
        $personal = Personal::with('work_group')->where('user_id', $user->id)->first();
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60 * 24 * 30,
            'user' => $user,
            'personal' => $personal,
        ]);
    }
}
