@extends('layouts.app', [
    'title' => $channel->name . ' | LaravelTube'
])

@section('content')
    <div class="min-h-screen bg-gray-50 text-gray-800">

        {{-- Kanal Banner --}}
        <div class="relative w-full h-52 bg-gray-200">
            @if($channel->banner)
                <img src="{{ asset($channel->banner) }}"
                     alt="Channel Banner"
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/20"></div>
            @else
                <div class="flex items-center justify-center h-full text-gray-400 text-sm">
                    Kanal kapağı yüklenmedi
                </div>
            @endif
        </div>

        {{-- Kanal Bilgileri --}}
        <div class="max-w-6xl mx-auto px-4 -mt-16 flex flex-col sm:flex-row sm:items-end justify-between gap-4 relative z-10">
            <div class="flex items-center gap-4">
                <img src="{{ $channel->image ? asset($channel->image) : asset('images/default-avatar.png') }}"
                     alt="Kanal Profil"
                     class="w-28 h-28 rounded-full border-4 border-white shadow-md object-cover">

                <div>
                    <h1 class="text-2xl font-semibold">{{ $channel->name }}</h1>
                    <p class="text-gray-600 text-sm">{{ '@' . $channel->slug }}</p>
                    <p class="text-gray-500 text-sm mt-1">
                        {{ $channel->description ?? 'Kanal açıklaması bulunmuyor.' }}
                    </p>
                </div>
            </div>

            <div>
                <button class="px-6 py-2.5 bg-red-600 text-white rounded-full font-medium hover:bg-red-700 transition shadow">
                    Abone Ol
                </button>
            </div>
        </div>

        {{-- Sekmeler --}}
        <div class="border-b border-gray-200 mt-10">
            <div class="max-w-6xl mx-auto px-4 flex gap-8 text-gray-600 font-medium">
                <a href="#" class="py-3 border-b-2 border-red-600 text-red-600 transition">Videolar</a>
                <a href="#" class="py-3 border-b-2 border-transparent hover:border-red-600 hover:text-red-600 transition">Listeler</a>
                <a href="#" class="py-3 border-b-2 border-transparent hover:border-red-600 hover:text-red-600 transition">Hakkında</a>
            </div>
        </div>

        {{-- Video Grid --}}
        <div class="max-w-6xl mx-auto px-4 mt-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 pb-16">
            @forelse($channel->videos as $video)
                <div class="bg-white rounded-xl overflow-hidden shadow hover:shadow-lg transition transform hover:-translate-y-1 relative group">

                    {{-- Thumbnail --}}
                    <a href="{{ route('video.watch', [$video->uid]) }}" class="block relative">
                        <div class="aspect-video bg-gray-200 relative overflow-hidden">
                            @if($video->thumbnail_image)
                                <img src="{{ Storage::url('videos/' . $video->uid . '/' . $video->thumbnail_image) }}"
                                     alt="{{ $video->title }}"
                                     class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400 text-sm">
                                    Önizleme yok
                                </div>
                            @endif
                        </div>
                    </a>

                    {{-- Video Bilgileri --}}
                    <div class="p-3">
                        <h2 class="text-base font-semibold line-clamp-2 hover:text-red-600 transition-colors">
                            <a href="{{ route('video.watch', [$video->uid]) }}">{{ $video->title }}</a>
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">{{ ucfirst($video->visibility) }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $video->created_at->diffForHumans() }}</p>
                    </div>

                    {{-- Düzenleme İkonu (sadece sahibi görür) --}}
                    @auth
                        @if(auth()->id() === $channel->user_id)
                            <a href="{{ route('video.edit', [$channel->uid, $video->uid]) }}"
                               class="absolute top-2 right-2 bg-white/90 text-gray-700 p-2 rounded-full shadow-md opacity-0 group-hover:opacity-100 transition hover:scale-110"
                               title="Videoyu düzenle"
                               onclick="event.stopPropagation();">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                     class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652l-8.97 8.97a4.5 4.5 0 01-1.897 1.13l-3.372.958.958-3.372a4.5 4.5 0 011.13-1.897l8.812-8.753z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M19.5 7.125L17.25 4.875" />
                                </svg>
                            </a>
                        @endif
                    @endauth
                </div>
            @empty
                <div class="col-span-full text-center py-16 text-gray-500">
                    <p class="text-lg font-medium mb-2">Bu kanalda henüz video yok.</p>
                    <p class="text-sm text-gray-400">Yeni videolar yüklendiğinde burada görünecek.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
