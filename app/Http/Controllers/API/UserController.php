<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Helpers\ResponseFormatter as Response;
use Illuminate\Http\Request;
use Laravel\Fortify\Rules\Password;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        try {

            // VALIDATE RULEs
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'phone_number' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'max:255', 'unique:users', 'email'],
                'password' => ['required', 'string', new Password],
            ]);

            // DONE YET CREATE THE USER ACCOUNT:
            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone_number' => $request->phone_number
            ]);

            // taking the data by email
            $user = User::where('email', $request->email)->first();

            // create Bearer Token
            $accessToken = $user->createToken('authToken')->plainTextToken;

            return Response::success([
                'access_token' => $accessToken,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'OK');
        } catch (Exception $error) {
            // delete if data is not valid
            User::where('username', $request->username)->delete();
            return Response::error(null, $error->getMessage(), 500);
        }
    }

    public function login(Request $request) {
        try {
            $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);

            $credentials = $request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return Response::error(null, 'Unauthorized/Invalid Credentials', 500);
            }

            $user = User::where('email', $request->email)->first();

            if (!Hash::check($request->email, $user->password) {

            }
        } 
    }
}
