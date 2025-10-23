<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $videos = Video::orderBy('created_at','desc')->get();

        return view('pages.index',["videos"=>$videos]);
    }

    public function registerPage()
    {
        if (auth()->check()) {
            return redirect()->route('home');
        }
        return view('pages.register');
    }
}

