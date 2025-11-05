@extends('layouts.app', [
    "title" => "YouTube"
])

@section('content')
    <div class="max-w-7xl mx-auto px-4 text-gray-900" style="margin-top: 30px;">

        {{-- Kategoriler --}}
        <div class="flex overflow-x-auto space-x-2 pb-4 mb-8">
            @php
                $categories = [
                    ['name' => 'Tümü', 'icon' => null],
                    ['name' => 'Popüler', 'icon' => 'fas fa-fire'],
                    ['name' => 'Müzik', 'icon' => 'fas fa-music'],
                    ['name' => 'Oyun', 'icon' => 'fas fa-gamepad'],
                    ['name' => 'Eğitim', 'icon' => 'fas fa-graduation-cap'],
                    ['name' => 'Filmler', 'icon' => 'fas fa-camera'],
                    ['name' => 'Podcast', 'icon' => 'fas fa-microphone'],
                    ['name' => 'Canlı', 'icon' => 'fas fa-broadcast-tower'],
                    ['name' => 'Eğlence', 'icon' => 'fas fa-smile'],
                    ['name' => 'Haberler', 'icon' => 'fas fa-newspaper'],
                    ['name' => 'Sanat', 'icon' => 'fas fa-palette'],
                    ['name' => 'Teknoloji', 'icon' => 'fas fa-code']
                ];
                // örnek: aktif kategori index'i (server-side veya JS ile değiştirilebilir)
                $activeIndex = $activeIndex ?? 0;
            @endphp

            @foreach($categories as $index => $category)
                @php $isActive = $index === $activeIndex; @endphp

                <button
                    type="button"
                    role="tab"
                    aria-pressed="{{ $isActive ? 'true' : 'false' }}"
                    class="flex-shrink-0 inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 whitespace-nowrap
                        {{ $isActive
                            ? 'bg-indigo-600 text-white shadow-sm border border-indigo-700'
                            : 'bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-300 border border-gray-200 hover:bg-gray-50 dark:hover:bg-slate-700' }}">
                    @if(!empty($category['icon']))
                        <i class="{{ $category['icon'] }} text-sm {{ $isActive ? 'text-white/90' : 'text-gray-500 dark:text-slate-300' }}" aria-hidden="true"></i>
                    @endif
                    <span class="{{ $isActive ? 'text-white' : '' }}">{{ $category['name'] }}</span>
                </button>
            @endforeach
        </div>


        {{-- Video Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($videos as $video)
                <div class="group bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    {{-- Thumbnail --}}
                    <div class="relative aspect-video overflow-hidden">
                        <a href="{{ route('video.watch', $video->uid) }}" class="block w-full h-full">
                            <img src="{{ Storage::url('videos/' . $video->uid . '/' . $video->thumbnail_image) }}"
                                 alt="{{ $video->title }}"
                                 class="w-full h-full object-cover transform group-hover:scale-105 transition duration-300">
                            <div class="absolute bottom-2 right-2 bg-black/80 text-white text-xs px-2 py-1 rounded">
                                {{ $video->duration }}
                            </div>
                        </a>
                    </div>

                    {{-- Video Bilgileri --}}
                    <div class="p-4 flex gap-3">
                        {{-- Kanal Avatarı --}}
                        <a href="{{ route('channel', $video->channel->slug) }}" class="flex-shrink-0">
                            <img src="{{ $video->channel->profile_image ? Storage::url($video->channel->profile_image) : asset('images/default-avatar.png') }}"
                                 alt="{{ $video->channel->name }}"
                                 class="w-10 h-10 rounded-full">
                        </a>

                        {{-- Başlık ve Detaylar --}}
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('video.watch', $video->uid) }}"
                               class="block font-semibold text-gray-900 text-sm line-clamp-2 mb-1 hover:text-gray-700">
                                {{ $video->title }}
                            </a>
                            <a href="{{ route('channel', $video->channel->slug) }}"
                               class="block text-gray-500 text-sm hover:text-gray-700">
                                {{ $video->channel->name }}
                                @if($video->channel->verified)
                                    <i class="fas fa-badge-check text-xs ml-1 text-blue-500"></i>
                                @endif
                            </a>
                            <div class="text-gray-500 text-sm flex items-center mt-1">
                                <span>{{ number_format($video->views) }} izlenme</span>
                                <span class="mx-1">•</span>
                                <span>{{ $video->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        {{-- Menü --}}
                        <div class="relative">
                            <button class="p-2 hover:bg-gray-100 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fas fa-ellipsis-vertical text-gray-500"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Shorts --}}
<!--        <section class="mt-12 mb-12">
            <div class="flex items-center gap-2 mb-4">
                <i class="fas fa-play-circle text-xl text-gray-800"></i>
                <h2 class="text-xl font-medium text-gray-900">Shorts</h2>
            </div>

            <div class="flex gap-3 overflow-x-auto thin-scrollbar">
                @for($i = 1; $i <= 8; $i++)
                    <div class="group cursor-pointer w-40 flex-shrink-0">
                        <div class="relative aspect-[9/16] rounded-xl overflow-hidden mb-2">
                            <img src="https://picsum.photos/300/500?random={{ $i }}"
                                 alt="Short {{ $i }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            <div class="absolute bottom-2 right-2 bg-black/70 text-white text-xs px-1 py-0.5 rounded">
                                {{ rand(10, 59) }}K
                            </div>
                        </div>
                        <h3 class="text-gray-900 text-sm line-clamp-2 group-hover:text-blue-600">
                            Short video başlığı #{{ $i }}
                        </h3>
                    </div>
                @endfor
            </div>
        </section>-->

        {{-- Canlı Yayınlar --}}
<!--        <section class="mb-12">
            <h2 class="text-xl font-medium text-gray-900 mb-4">Canlı Yayınlar</h2>

            <div class="flex gap-4 overflow-x-auto thin-scrollbar">
                @for($i = 1; $i <= 6; $i++)
                    <div class="group w-80 flex-shrink-0">
                        <div class="relative aspect-video rounded-xl overflow-hidden mb-3">
                            <img src="https://picsum.photos/600/340?random={{ $i+10 }}"
                                 alt="Live {{ $i }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                            <div class="absolute bottom-2 right-2 bg-red-600 text-white text-xs px-2 py-1 rounded-sm">
                                CANLI
                            </div>
                            <div class="absolute bottom-2 left-2 bg-black/75 text-white text-xs px-1 py-0.5 rounded">
                                {{ rand(100, 999) }} izleyici
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <a href="#" class="flex-shrink-0">
                                <img src="https://picsum.photos/40/40?random={{ $i+20 }}"
                                     alt="Channel Avatar"
                                     class="w-9 h-9 rounded-full">
                            </a>
                            <div class="flex-1 min-w-0">
                                <a href="#" class="block font-medium text-gray-900 text-sm line-clamp-2 mb-1 hover:text-blue-600">
                                    Canlı Yayın Başlığı #{{ $i }}
                                </a>
                                <a href="#" class="block text-gray-500 text-sm hover:text-gray-700">
                                    Kanal Adı #{{ $i }}
                                </a>
                                <div class="text-gray-500 text-sm">
                                    {{ rand(1, 5) }} saat önce başladı
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </section>-->
    </div>

    <style>
        .thin-scrollbar::-webkit-scrollbar {
            height: 8px;
        }
        .thin-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .thin-scrollbar::-webkit-scrollbar-thumb {
            background-color: #c0c0c0;
            border-radius: 4px;
        }
        .thin-scrollbar::-webkit-scrollbar-thumb:hover {
            background-color: #a0a0a0;
        }
    </style>
@endsection
