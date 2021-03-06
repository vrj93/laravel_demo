<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ApiUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'email|required',
            'password' => 'required'
        ]);

        $validatedData['password'] = Hash::make($request->password);

        $user = ApiUser::create($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response([ 'user' => $user, 'access_token' => $accessToken]);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        $email = $request->email;

        $user = ApiUser::where('email', $email)->first();

        $valid = Hash::check($request->password, $user['password']);

        if (!$valid) {
            return response(['message' => 'Invalid Credentials']);
        }else {
            $accessToken = $user->createToken('authToken')->accessToken;
        }

        return response(['user' => $user, 'access_token' => $accessToken]);
    }
}
