<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use App\Traits\ManageFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    use ManageFiles;

    public function register(UserRegisterRequest $request)
    {
        $profileImagePath = null;
        $channelImagePath = null;
        $bannerPath = null;

        if ($request->hasFile('profile_image')) {
            $profileImagePath = $this->uploadFile(
                $request->file('profile_image'),
                'uploads/profile_images'
            );
        }

        if ($request->hasFile('channel_image')) {
            $channelImagePath = $this->uploadFile(
                $request->file('channel_image'),
                'uploads/channel_images'
            );
        }

        if ($request->hasFile('banner')) {
            $bannerPath = $this->uploadFile(
                $request->file('banner'),
                'uploads/banners'
            );
        }

        $user = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => bcrypt($request->password),
            'profile_image' => $profileImagePath,
        ]);

        $user->channel()->create([
            'name'          => $request->channel_name,
            'slug'          => Str::slug($request->channel_name, '-'),
            'uid'           => uniqid(true),
            'image' => $channelImagePath,
            'banner'        => $bannerPath,
        ]);

        auth()->login($user);

        return response()->json([
            'success'  => true,
            'message'  => 'Kayıt başarılı! Hoş geldiniz.',
            'redirect' => route('home'),
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
