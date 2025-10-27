@extends('layouts.app', [
    "title" => "YouTube"
])

@section('content')
    <div class="p-4">
        {{-- Kategoriler (Chips) --}}
        <div class="flex overflow-x-auto space-x-3 pb-4 mb-6 thin-scrollbar">
            <button class="flex-shrink-0 px-4 py-1.5 bg-white hover:bg-gray-100 text-sm font-medium rounded-lg transition dark:bg-[#272727] dark:text-white dark:hover:bg-[#3f3f3f]">
                Tümü
            </button>
            @php
                $categories = ['Trendler','Müzik','Oyun','Eğitim','Spor','Haberler','Canlı','Mix\'ler','Sitcomlar',
                            'Yemek Pişirme','Son Yüklenenler','İzlenenler'];
            @endphp
            @foreach($categories as $category)
                <button class="flex-shrink-0 px-4 py-1.5 bg-[#0f0f0f] hover:bg-[#272727] text-white text-sm font-medium rounded-lg transition border border-[#3f3f3f]">
                    {{ $category }}
                </button>
            @endforeach
        </div>

        {{-- Video Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
            @foreach($videos as $video)
                <div class="group">
                    {{-- Thumbnail --}}
                    <div class="relative aspect-video rounded-xl overflow-hidden mb-3">
                        <a href="{{ route('video.watch', $video->uid) }}" class="block w-full h-full">
                            <img src="{{ Storage::url('videos/' . $video->uid . '/' . $video->thumbnail_image) }}"
                                 alt="{{ $video->title }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                            <div class="absolute bottom-2 right-2 bg-black/80 text-white text-xs px-1 py-0.5 rounded">
                                {{ $video->duration }}
                            </div>

                            {{-- Hover Preview (İleride eklenecek) --}}
                            <div class="hidden group-hover:block absolute inset-0 bg-black/20"></div>
                        </a>
                    </div>

                    {{-- Video Bilgileri --}}
                    <div class="flex gap-3">
                        {{-- Kanal Avatarı --}}
                        <a href="{{ route('channel', $video->channel->slug) }}" class="flex-shrink-0">
                            <img src="{{ $video->channel->image ? Storage::url($video->channel->image) : asset('images/default-avatar.png') }}"
                                 alt="{{ $video->channel->name }}"
                                 class="w-9 h-9 rounded-full">
                        </a>

                        {{-- Başlık ve Detaylar --}}
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('video.watch', $video->uid) }}" class="block font-medium text-white text-sm line-clamp-2 mb-1">
                                {{ $video->title }}
                            </a>
                            <a href="{{ route('channel', $video->channel->slug) }}" class="block text-[#AAAAAA] text-sm hover:text-white">
                                {{ $video->channel->name }}
                            </a>
                            <div class="text-[#AAAAAA] text-sm">
                                {{ number_format($video->views) }} görüntüleme • {{ $video->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Shorts Bölümü --}}
        <section class="mt-12 mb-12">
            <div class="flex items-center gap-2 mb-4">
                <i class="fas fa-play-circle text-xl"></i>
                <h2 class="text-xl font-medium text-white">Shorts</h2>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 xl:grid-cols-8 gap-2">
                @for($i = 1; $i <= 8; $i++)
                    <div class="group cursor-pointer">
                        <div class="relative aspect-[9/16] rounded-xl overflow-hidden mb-2">
                            <img src="https://picsum.photos/300/500?random={{ $i }}"
                                 alt="Short {{ $i }}"
                                 class="w-full h-full object-cover">
                            <div class="absolute bottom-2 right-2 text-white text-xs">
                                {{ rand(10, 59) }}K
                            </div>
                        </div>
                        <h3 class="text-white text-sm line-clamp-2 group-hover:text-blue-400">
                            Short video başlığı #{{ $i }}
                        </h3>
                    </div>
                @endfor
            </div>
        </section>

        {{-- Canlı Yayınlar --}}
        <section class="mb-12">
            <h2 class="text-xl font-medium text-white mb-4">Canlı Yayınlar</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                @for($i = 1; $i <= 4; $i++)
                    <div class="group">
                        <div class="relative aspect-video rounded-xl overflow-hidden mb-3">
                            <img src="https://picsum.photos/600/340?random={{ $i+10 }}"
                                 alt="Live {{ $i }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                            <div class="absolute bottom-2 right-2 bg-red-600 text-white text-xs px-2 py-1 rounded-sm">
                                CANLI
                            </div>
                            <div class="absolute bottom-2 left-2 bg-black/80 text-white text-xs px-1 py-0.5 rounded">
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
                                <a href="#" class="block font-medium text-white text-sm line-clamp-2 mb-1">
                                    Canlı Yayın Başlığı #{{ $i }}
                                </a>
                                <a href="#" class="block text-[#AAAAAA] text-sm hover:text-white">
                                    Kanal Adı #{{ $i }}
                                </a>
                                <div class="text-[#AAAAAA] text-sm">
                                    {{ rand(1, 5) }} saat önce başladı
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </section>
    </div>

    <style>
        .thin-scrollbar::-webkit-scrollbar {
            height: 8px;
        }
        .thin-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .thin-scrollbar::-webkit-scrollbar-thumb {
            background-color: #606060;
            border-radius: 4px;
        }
        .thin-scrollbar::-webkit-scrollbar-thumb:hover {
            background-color: #909090;
        }
    </style>
@endsection
