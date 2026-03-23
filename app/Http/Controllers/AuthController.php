<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function loginOrRegister(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
            'name' => 'nullable|string|max:255',
        ], [
            'password.min' => 'Kata sandi minimal 8 karakter.',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (!Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'password' => ['Password salah.'],
                ]);
            }

            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'message' => 'Login berhasil!',
                'user' => $user,
                'token' => $token,
                'is_new' => false,
            ]);
        }

        $user = User::create([
            'name' => $request->name ?? explode('@', $request->email)[0],
            'email' => $request->email,
            'password' => $request->password,
            'total_score' => 0,
            'highest_stage_unlocked' => 1,
        ]);

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'message' => 'Akun baru berhasil dibuat!',
            'user' => $user,
            'token' => $token,
            'is_new' => true,
        ], 201);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'user' => $request->user(),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil!',
        ]);
    }
}

