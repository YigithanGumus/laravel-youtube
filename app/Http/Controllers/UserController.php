<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Traits\ManageFiles;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ManageFiles;

    public function updatePage($id)
    {
        $user = User::findOrFail($id);
        return view('pages.user-profile', ['user' => $user]);
    }

    public function update($id, UserUpdateRequest $request)
    {
        $user = User::findOrFail($id);

        $data = $request->only(['name', 'email']);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $this->uploadFile(
                $request->file('profile_image'),
                'uploads/profile_images'
            );
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => "Başarıyla kaydedildi!",
            'user' => $user
        ]);
    }
}

