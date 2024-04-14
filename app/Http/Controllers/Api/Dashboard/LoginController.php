<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  LoginRequest  $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = ['email' => $request->username, 'password' => $request->password];

        if (Auth::attempt($credentials)) {
            $user = User::whereEmail($request->username)->firstOrFail();
            return $user->getResource()->additional(['token' => $user->createTokenForDevice($request->header('user-agent'))]);
        }

        return response()->json(['error' => __('auth.errors.wrong_credentials')], 401);
    }

    /**
     * @param  Request  $request
     * @return mixed
     */
    public function user(Request $request)
    {
        return $request->user()->getResource();
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => __('auth.logged_out')]);
    }
}
