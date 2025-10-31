<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function updatePage($id)
    {
        $user = User::find($id);

        return view('pages.user-profile',['user'=>$user]);
    }

    public function update()
    {
        //
    }
}
