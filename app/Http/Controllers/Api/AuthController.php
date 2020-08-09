<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $this->validate($request, [
            'email' => 'required|unique:users|email',
            'name' => 'required|between:2,17',
            'password' => 'required|confirmed|min:6'
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['api_token'] = Str::random(32);

        $user = User::create($data);

        return response()->json($user);
    }

    public function login(Request $request)
    {
        $data = $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $data['email'])->first();

        if ($user && Hash::check($data['password'], $user->password)) {
            $user->api_token = Str::random(32);
            $user->save();
        } else {
            return response()->json(['message' => 'Incorrect password or email'], 401);
        }

        return response()->json([
            'api_token' => $user->api_token
        ]);
    }
}
