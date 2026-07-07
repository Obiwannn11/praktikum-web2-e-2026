<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Registrasi user baru (role default: user) dan langsung berikan token.
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => new UserResource($user),
                'token' => $token,
            ],
            'message' => 'Berhasil registrasi',
        ], 201);
    }

    /**
     * Login: verifikasi kredensial, hapus token lama, terbitkan token baru.
     */
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah'],
            ]);
        }

        // hapus token lama agar hanya ada satu sesi aktif
        $user->tokens()->delete();
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => new UserResource($user),
                'token' => $token,
            ],
            'message' => 'Berhasil login',
        ]);
    }

    /**
     * Logout: hapus token yang sedang dipakai.
     */
    public function logout()
    {
        request()->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'data' => null,
            'message' => 'Berhasil logout',
        ]);
    }
}
