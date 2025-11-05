<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $videos = Video::with([
            'channel.user',
        ])
            ->where('title','%'.$request->title.'%')
            ->paginate(10);

        return view('pages.search-video',[
            'videos'=> $videos["items"] ? $videos : Video::with('channel.user')->paginate(10),
            'title'=>$title ?? null,
        ]);
    }
}
