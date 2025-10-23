@extends('layouts.app', [
    "title" => "Dashboard Page"
])

@section('content')
    <div class="container mx-auto p-4">

        {{-- Trendler / Kategoriler --}}
        <div class="flex overflow-x-auto space-x-4 pb-4 hide-scrollbar mb-6">
            @php
                $categories = ['Trendler','Niloya','Elif ve Arkadaşları','Spor ve Fitness','Müzik','Oyun','Eğitim'];
            @endphp
            @foreach($categories as $category)
                <div class="flex-shrink-0 flex flex-col items-center cursor-pointer hover:text-red-600 transition">
                    <div class="bg-gray-200 border-2 border-dashed rounded-full w-16 h-16 flex items-center justify-center text-gray-500 font-semibold">{{ Str::limit($category, 2) }}</div>
                    <span class="mt-2 text-sm">{{ $category }}</span>
                </div>
            @endforeach
        </div>

        {{-- Ana Video Bölümü --}}
        <main>
            <h2 class="text-xl font-semibold mb-4">Öne Çıkan Videolar</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

                @foreach($videos as $video)
                    <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition cursor-pointer">

                        {{-- Videoya tıklanınca video sayfasına yönlendir --}}
                        <a href="{{ route('video.watch', $video->uid) }}">
                            <div class="relative w-full h-48 bg-gray-200">
                                <img src="{{ Storage::url('videos/' . $video->uid . '/' . $video->thumbnail_image) }}" alt="Video Thumbnail" class="w-full h-full object-cover">
                                <span class="absolute bottom-2 right-2 bg-black bg-opacity-70 text-white text-xs px-1 rounded">{{ $video->duration }}</span>
                            </div>
                        </a>

                        <div class="p-3 flex flex-col gap-1">
                            <a href="{{ route('video.watch', $video->uid) }}" class="font-semibold text-sm line-clamp-2 hover:text-red-600 transition">{{ $video->title }}</a>

                            {{-- Kanal ismine tıklanınca kanal sayfasına yönlendir --}}
                            <p class="text-gray-500 text-xs">
                                <a href="{{ route('channel', $video->channel->slug) }}" class="hover:text-red-600 transition">{{ $video->channel->name }}</a> •
                                {{ $video->views }} görüntüleme •
                                {{ $video->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                @endforeach

            </div>
        </main>

    </div>

    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
@endsection
