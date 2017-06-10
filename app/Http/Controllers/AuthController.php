<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    protected function reg(Request $request) // api/users
    {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);

        $user = User::find($user->id);

        $token = $user->createToken('vcast')->accessToken;

        return response()->json(['token' => $token]);
    }

    public function test()
    {
        return response()->json(Auth::user());
    }

    protected function login()
    {
        if (Auth::attempt(request()->only(['email', 'password']))) {
            $token = Auth::user()->createToken('wecast')->accessToken;//you need to run this first on terminal: php artisan passport:client --personal
            return response()->json($token);
        };
        return response()->json(302);
    }

    public function logout()
    {
        Auth::logout();
        return response('', 204);
    }
}
