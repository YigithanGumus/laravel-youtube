<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoEditRequest;
use App\Http\Requests\VideoUploadRequest;
use App\Jobs\ConvertVideoForStreaming;
use App\Jobs\CreateThumbnailFromVideo;
use App\Models\Channel;
use App\Models\Video;
use App\Traits\ManageFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    use ManageFiles;

    public function videoUploadPage()
    {
        return view('pages.upload-video');
    }

    public function videoUpload($channel, VideoUploadRequest $request)
    {
        $imagePath = null;

        $channel = Channel::where('uid', $channel)->first();

        $videoFile = $request->file('video');
        $path = $videoFile->store('videos-temp');
        $filename = basename($path);

        if ($request->hasFile('thumbnail_image')) {
            $imagePath = $this->uploadFile(
                $request->file('thumbnail_image'),
                'uploads/thumbnail_images'
            );
        }

        $video = $channel->videos()->create([
            'title' => $request->title ?? Str::beforeLast($videoFile->getClientOriginalName(), '.'),
            'description' => $request->description ?? null,
            'uid' => uniqid(true),
            'visibility' => "public",
            'path' => $filename,
            'image' => $imagePath,
        ]);

        CreateThumbnailFromVideo::dispatch($video);
        ConvertVideoForStreaming::dispatch($video);

        return response()->json([
            'success' => true,
            'redirect' => route('channel', ['channel' => $channel->slug]),
        ], 201);
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

        return view('pages.channel',['channel'=>$channel, 'views'=>count($channel->videos)]);
    }

    public function video($video)
    {
        $video = Video::where('uid',$video)->first();

        if (!$video)
        {
            return view('pages.404');
        }

        $video->update([
            'views'=>$video->views + 1,
        ]);

        return view('pages.video-page',["video"=>$video]);
    }
}
