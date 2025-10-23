@extends('layouts.app', [
    'title' => $video->title . ' | LaravelTube'
])

@section('content')
    <div class="min-h-screen bg-gray-100 text-gray-900">

        <div class="max-w-7xl mx-auto px-4 py-6 flex flex-col lg:flex-row gap-6">

            {{-- Video Ana Bölüm --}}
            <div class="flex-1 flex flex-col gap-4">

                {{-- Video Player --}}
                <div class="w-full bg-black aspect-video rounded-xl overflow-hidden shadow-lg">
                    <video controls class="w-full h-full object-cover rounded-xl">
                        <source src="{{ Storage::url('videos/' . $video->uid . '/' . $video->processed_file) }}" type="video/mp4">
                        Tarayıcınız video etiketini desteklemiyor.
                    </video>
                </div>

                {{-- Video Bilgileri --}}
                <div class="flex flex-col gap-3">
                    <h1 class="text-2xl font-semibold line-clamp-2">{{ $video->title }}</h1>
                    <div class="flex items-center justify-between text-gray-500 text-sm">
                        <span>{{ $video->views }} görüntüleme</span>
                        <span>{{ $video->duration }}</span>
                    </div>

                    {{-- Kanal ve İşlemler --}}
                    <div class="flex items-center justify-between mt-4 border-t border-gray-300 pt-4">
                        <div class="flex items-center gap-4">
                            <img src="{{ Storage::url($video->channel->image ?? 'defaults/avatar.png') }}" alt="Profil" class="w-10 h-10 rounded-full object-cover">
                            <div>
                                <p class="font-semibold">{{ $video->channel->name  }}</p>
                                <p class="text-gray-500 text-sm">0 abone</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">Abone Ol</button>
                            <button class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition">Paylaş</button>
                        </div>
                    </div>

                    <p class="mt-3 text-gray-700">{{ $video->description }}</p>
                </div>

                {{-- Yorumlar (opsiyonel) --}}
                <div class="mt-6">
                    <h2 class="font-semibold text-lg mb-3">Yorumlar</h2>
                    <!-- yorumlar buraya -->
                </div>
            </div>

            {{-- Sidebar / Önerilen Videolar --}}
            <div class="w-full lg:w-80 flex flex-col gap-4">
                <h2 class="font-semibold text-lg mb-3">Önerilen Videolar</h2>
                <div class="flex flex-col gap-3">

                </div>
            </div>

        </div>
    </div>
@endsection
