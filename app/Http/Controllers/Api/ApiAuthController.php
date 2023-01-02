<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\LoginResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    //login
    public function login(LoginRequest $request)
    {
        //validate dengan Auth::attempt
        if (Auth::attempt($request->only('email', 'password'))) {
            //jika berhasil buat token
            $user = User::where('email', $request->email)->first();
            //token lama dihapus
            $user->tokens()->delete();
            //token baru di create
            $token = $user->createToken('token')->plainTextToken;
            return new LoginResource([
                'token' => $token,
                'user' => $user
            ]);
        } else {
            //jika gagal kirim response error
            return response()->json([
                'message' => 'Invalid Credentials'
            ], 401);
        }
    }

    //register
    public function register(RegisterRequest $request)
    {
        //save user to user table
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('token')->plainTextToken;
        //return token
        return new LoginResource([
            'token' => $token,
            'user' => $user
        ]);
    }

    //logout
    public function logout(Request $request)
    {
        //hapus semua tuken by user
        $request->user()->tokens()->delete();
        //response no content
        return response()->noContent();
    }
}
