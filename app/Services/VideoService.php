<?php

	namespace App\Services;

use App\Jobs\ConvertVideoForStreaming;
use App\Jobs\CreateThumbnailFromVideo;
use App\Models\Channel;
use App\Models\Video;

	class VideoService
	{
		public function uploadVideoToStorage($video){;
			$path = $video->store('public/videos-temp');
			return $path;
		}

	    public function saveVideoToDatabase($channel, $path, $settings = [], $video_orginal_url = null): Video
		{
			$channel = Channel::where('uid', $channel)->first();


			$filename = basename($path);


			$video = $channel->videos()
				->create([
					'title' => $settings['title'],
					'description' => $settings['description'] ?? null,
					'uid' => uniqid(true),
					'visibility' => $settings['visibility'] ?? "public",
					//'path' => $filename,
					'video_orginal_path' => $path,
					'image' => $settings['image'] ?? null,
					'video_orginal_url' => $video_orginal_url ?? null,
					'file_hash' => $settings['file_hash'] ?? null,
				]);



			if (config('app.when_upload_video_add_queue_for_streaming')) {
				$video->update([
					'is_converting_for_streaming' => true,
				]);
				ConvertVideoForStreaming::dispatch($video);
			} else {
				$video->update([
					'is_converting_for_streaming' => false,
				]);
			}

			return $video;
		}

		public function generateThumbnail(Video $video, $disk = 'videos-temp', $video_path = null){
			CreateThumbnailFromVideo::dispatch($video, $disk, $video_path);
		}
	}