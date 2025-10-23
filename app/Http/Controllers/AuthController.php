<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->channel()->create([
            'name' => $request->channel_name,
            'slug' => Str::slug($request->channel_name, '-'),
            'uid' => uniqid(true),
        ]);

        auth()->login($user);

        return response()->json([
            'success' => true,
            'message' => 'Kayıt başarılı! Hoş geldiniz.',
            'redirect' => route('login.page'),
        ]);
    }

    public function loginPage()
    {
        if (auth()->check()) {
            return redirect()->route('home');
        }
        return view('pages.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials, true)) {
            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'redirect' => route('home'),
            ]);
        }

        return response()->json([
            'success' => false,
            'errors' => [
                'global' => ['E-posta veya şifre hatalı.'],
            ],
        ], 422);
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
