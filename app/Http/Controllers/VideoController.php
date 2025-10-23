<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoEditRequest;
use App\Http\Requests\VideoUploadRequest;
use App\Jobs\ConvertVideoForStreaming;
use App\Jobs\CreateThumbnailFromVideo;
use App\Models\Channel;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function videoUploadPage()
    {
        return view('pages.upload-video');
    }

    public function videoUpload($channel, VideoUploadRequest $request)
    {
        $channel = Channel::where('uid',$channel)->first();

        $videoFile = $request->file('video');
        $path = $videoFile->store('videos-temp');
        $filename = basename($path);

        $video = $channel->videos()->create([
            'title' => $request->title ?? 'untitled',
            'description' => $request->description ?? 'none',
            'uid' => uniqid(true),
            'visibility' => $request->visibility ?? 'private',
            'path' => $filename,
        ]);


        CreateThumbnailFromVideo::dispatch($video);
        ConvertVideoForStreaming::dispatch($video);

        return redirect()->route('video.edit.page', [
            'channel' => $channel->uid,
            'video' => $video->uid,
        ]);
    }

    public function videoEditPage($channel, $video)
    {
        $channel = Channel::where('uid', $channel)->first();
        $video = Video::where('uid',$video)->first();

        return view('pages.edit-video',['channel'=>$channel, 'video'=>$video]);
    }

    public function videoEdit($channel, $video,Request $request)
    {
        $video = Video::where('uid',$video)->first();

        $video->update([
            'title' => $request->title,
            'description' => $request->description,
            'visibility' => $request->visibility
        ]);

        return redirect()->route('home',[
            "success"=>"Başarıyla video yüklenmiştir!",
        ]);
    }

    public function videos($channel)
    {
        $channel = Channel::with('videos')->where('slug',$channel)->first();

        return view('pages.channel',['channel'=>$channel]);
    }

    public function video($video)
    {
        $video = Video::where('uid',$video)->first();

        return view('pages.video-page',["video"=>$video]);
    }
}
