<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterFormRequest;
use App\User;

class AuthController extends Controller
{
    public function register(RegisterFormRequest $request)
    {
        $user = new User;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->save();

        return response([
            'status'    => 'success',
            'data'      => $user
        ], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if(!$token = \JWTAuth::attempt($credentials)) {
            return response([
                'status'    => 'error',
                'error'     => 'invalid.credentials',
                'msg'       => 'Invalid Credentials.'
            ], 400);
        }
        
        return $this->respondWithToken($token);
    }

    public function logout()
    {
        \JWTAuth::invalidate();

        return response([
            'status' => 'success',
            'msg' => 'Logged out successfully.'
        ], 200);
    }

    public function user()
    {
        if (! $token = \JWTAuth::parseToken()) {
            //throw an exception
            return response([
                'error' => \JWTAuth::parseToken()
            ]);
        }
        
        $user = \JWTAuth::toUser($token);
        return response([
            'status' => 'success',
            'data' => $user,
        ]);
    }
    public function refresh()
    {
        return response([
            'status' => 'success'
        ]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60
        ]);
    }
}
