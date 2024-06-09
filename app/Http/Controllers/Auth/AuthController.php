<?php
namespace App\Http\Controllers\Auth;

use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     * @throws \Exceptions\UnauthorizedException
     */
    public function login(AuthRequest $request)
    {
        try {
            $data = $request->validated();
            $credentials = $this->credentials($data['username']);
            $token = Auth::attempt($credentials);
            if (!$token) {
                throw new UnauthorizedException("Password incorrect for: ". $data['username'], 401);
            }
            //$user = Auth::user();
            return response()->apiResponse([
                'token' => $token,
                'type' => 'bearer',
                'minutes_to_expire' => Auth::factory()->getTTL()
            ]);
        } catch (\Exception $e) {
            $status_code = is_integer($e->getCode()) ? $e->getCode() : 500;
            return response()->apiException($e->getMessage(),  $status_code);
        }

    }

    /**
     * Logout request to the application.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();
        return response()->apiResponse([
            'message' => 'Successfully logged out',
        ]);
    }

    /**
     * Refresh request to the application.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        try {
            return response()->apiResponse([
                'token' => Auth::refresh(),
                'type' => 'bearer',
                'minutes_to_expire' => Auth::factory()->getTTL()
            ]);
        } catch (\Exception $e) {
            $status_code = is_integer($e->getCode()) ? $e->getCode() : 500;
            return response()->apiException($e->getMessage(), $status_code);
        }
    }


    /**
     * Get the needed authorization credentials from the request.
     *
     * @return array
     */
    protected function credentials($loginField)
    {
        if ($loginField !== null) {
            $loginType = filter_var($loginField, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
            request()->merge([ $loginType => $loginField ]);
            $credentials = request([ $loginType, 'password' ]);
            return $credentials;
        } else {
            return $loginField;
        }
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}
