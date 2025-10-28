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
        $videoImagePath = null;

        $channel = Channel::where('uid', $channel)->first();

        $videoFile = $request->file('video');
        $path = $videoFile->store('videos-temp');
        $filename = basename($path);

        if ($request->hasFile('thumbnail_image')) {
            $videoImagePath = $this->uploadFile(
                $request->file('thumbnail_image'),
                'uploads/thumbnail_images'
            );
        }

        $video = $channel->videos()->create([
            'title' => $request->title ?? Str::beforeLast($request->file('video')->getClientOriginalName(), '.'),
            'description' => $request->description ?? null,
            'uid' => uniqid(true),
            'visibility' => "public",
            'path' => $filename,
            'thumbnail_image'=>$videoImagePath ?? $filename,
        ]);

        CreateThumbnailFromVideo::dispatch($video);

        if (!$request->hasFile('thumbnail_image')) {
            ConvertVideoForStreaming::dispatch($video);


            $video->update([
                'thumbnail_image'=>$filename
            ]);
        }

        return redirect()->route('channel', [
            'channel' => $channel->slug,
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
        $video->update([
            'views'=>$video->views + 1,
        ]);

        return view('pages.video-page',["video"=>$video]);
    }
}
