<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class WebAuthController extends Controller
{
    public function showLogin(): View
    {
        return view('login');
    }

    public function showRegister(): View
    {
        return view('register');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required|string',
            ],
            [
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Gunakan format email yang valid.',
                'password.required' => 'Kata sandi wajib diisi.',
            ]
        );

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors(['auth' => 'Email atau kata sandi salah.'])
                ->onlyInput('email');
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return redirect()
            ->route('auth.handoff')
            ->with('auth_token', $token)
            ->with('auth_user', $user->toArray());
    }

    public function register(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'username' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
            ],
            [
                'username.required' => 'Nama pengguna wajib diisi.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Gunakan format email yang valid.',
                'email.unique' => 'Email ini sudah terdaftar.',
                'password.required' => 'Kata sandi wajib diisi.',
                'password.min' => 'Kata sandi minimal 8 karakter.',
                'password.confirmed' => 'Kata sandi dan konfirmasi tidak sama.',
            ]
        );

        $user = User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
            'total_score' => 0,
            'highest_stage_unlocked' => 1,
        ]);

        $token = $user->createToken('auth-token')->plainTextToken;

        return redirect()
            ->route('auth.handoff')
            ->with('auth_token', $token)
            ->with('auth_user', $user->fresh()->toArray());
    }

    public function handoff(): View
    {
        return view('auth-handoff');
    }
}
