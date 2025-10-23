@extends('layouts.app', [
    "title" => "Video Yükle | LaravelTube"
])

@section('content')
    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-semibold mb-4 text-center">Video Yükle</h1>
        <form action="{{ route('videos.store', Auth::user()->channel->uid) }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Video dosyası inputu --}}
            <div class="mb-4">
                <label for="video" class="block text-sm font-medium text-gray-700 mb-2">
                    Video Dosyası
                </label>
                <input
                    type="file"
                    name="video"
                    id="video"
                    accept="video/*"
                    required
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring focus:ring-indigo-300"
                >
                @error('video')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Gönder butonu --}}
            <div class="text-center">
                <button
                    type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg"
                >
                    Yükle
                </button>
            </div>
        </form>
    </div>
@endsection
