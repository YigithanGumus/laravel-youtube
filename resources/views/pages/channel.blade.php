@extends('layouts.app', [
    'title' => $channel->name . ' | YouTube'
])

@section('content')
    <div class="min-h-screen text-white">
        {{-- Kanal Banner --}}
        <div class="relative w-full h-[200px] md:h-[250px] lg:h-[300px] bg-[#181818]">
            @if($channel->banner)
                <img src="{{ asset($channel->banner) }}"
                     alt="Channel Banner"
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-b from-black/20 to-transparent"></div>
            @else
                <div class="flex items-center justify-center h-full text-gray-600 text-sm">
                    <i class="fas fa-image mr-2"></i>
                    Kanal kapağı yüklenmedi
                </div>
            @endif
        </div>

        {{-- Kanal Bilgileri --}}
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 -mt-16 relative z-10 mb-6">
                <div class="flex flex-col md:flex-row items-start md:items-end gap-6">
                    <img src="{{ $channel->image ? asset($channel->image) : asset('images/default-avatar.png') }}"
                         alt="Kanal Profil"
                         class="w-24 h-24 md:w-32 md:h-32 rounded-full border-4 border-[#0f0f0f] shadow-lg object-cover">

                    <div class="md:mb-2">
                        <h1 class="text-2xl font-semibold text-white mb-1">{{ $channel->name }}</h1>
                        <div class="flex items-center gap-4 text-gray-400 text-sm">
                            <span>{{ '@' . $channel->slug }}</span>
                            <span>{{ number_format(rand(10000, 1000000)) }} abone</span>
                            <span>{{ number_format(rand(50, 500)) }} video</span>
                        </div>
                        <p class="text-gray-400 text-sm mt-2 line-clamp-2">
                            {{ $channel->description ?? 'Kanal açıklaması bulunmuyor.' }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button class="bg-white text-black px-4 py-2 rounded-full font-medium hover:bg-gray-100 transition">
                        Özelleştir
                    </button>
                    <button class="bg-[#272727] text-white px-4 py-2 rounded-full hover:bg-[#3f3f3f] transition">
                        <i class="fas fa-ellipsis"></i>
                    </button>
                </div>
            </div>

        {{-- Sekmeler ve Filtreler --}}
        <div class="border-b border-[#303030] mt-4">
            <div class="max-w-7xl mx-auto">
                <div class="px-4 flex gap-8 text-gray-400 font-medium overflow-x-auto thin-scrollbar">
                    <a href="#" class="py-4 border-b-2 border-white text-white whitespace-nowrap">Ana Sayfa</a>
                    <a href="#" class="py-4 border-b-2 border-transparent hover:text-white whitespace-nowrap">Videolar</a>
                    <a href="#" class="py-4 border-b-2 border-transparent hover:text-white whitespace-nowrap">Shorts</a>
                    <a href="#" class="py-4 border-b-2 border-transparent hover:text-white whitespace-nowrap">Canlı</a>
                    <a href="#" class="py-4 border-b-2 border-transparent hover:text-white whitespace-nowrap">Oynatma listeleri</a>
                    <a href="#" class="py-4 border-b-2 border-transparent hover:text-white whitespace-nowrap">Topluluk</a>
                    <a href="#" class="py-4 border-b-2 border-transparent hover:text-white whitespace-nowrap">Kanallar</a>
                    <a href="#" class="py-4 border-b-2 border-transparent hover:text-white whitespace-nowrap">Hakkında</a>
                </div>
            </div>
        </div>

        {{-- İçerik Filtreleri --}}
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center gap-4">
            <button class="px-3 py-1.5 bg-[#272727] text-white rounded-lg hover:bg-[#3f3f3f] transition flex items-center gap-2">
                <i class="fas fa-filter"></i>
                <span>Filtreler</span>
            </button>
            <div class="h-8 w-px bg-[#303030]"></div>
            <div class="flex gap-2 overflow-x-auto thin-scrollbar">
                <button class="px-3 py-1.5 bg-white text-black rounded-lg font-medium whitespace-nowrap">En yeni</button>
                <button class="px-3 py-1.5 bg-[#272727] text-white rounded-lg hover:bg-[#3f3f3f] transition whitespace-nowrap">En popüler</button>
                <button class="px-3 py-1.5 bg-[#272727] text-white rounded-lg hover:bg-[#3f3f3f] transition whitespace-nowrap">En eski</button>
            </div>
        </div>

        {{-- Video Grid --}}
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-x-4 gap-y-8 pb-16">
            @forelse($channel->videos as $video)
                <div class="group">
                    {{-- Video Thumbnail --}}
                    <div class="relative aspect-video rounded-xl overflow-hidden mb-3">
                        <a href="{{ route('video.watch', [$video->uid]) }}" class="block w-full h-full">
                            @if($video->thumbnail_image)
                                <img src="{{ Storage::url('videos/' . $video->uid . '/' . $video->thumbnail_image) }}"
                                     alt="{{ $video->title }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                            @else
                                <div class="flex items-center justify-center h-full bg-[#181818] text-gray-500">
                                    <i class="fas fa-photo-video text-3xl"></i>
                                </div>
                            @endif

                            {{-- Video Süresi --}}
                            <div class="absolute bottom-1 right-1 bg-black/80 text-white text-xs px-1 py-0.5 rounded">
                                {{ $video->duration ?? '00:00' }}
                            </div>

                            {{-- Düzenleme Butonu --}}
                            @auth
                                @if(auth()->id() === $channel->user_id)
                                    <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('video.edit', [$channel->uid, $video->uid]) }}"
                                           class="p-2 bg-black/80 hover:bg-black text-white rounded-lg"
                                           title="Videoyu düzenle">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </div>
                                @endif
                            @endauth
                        </a>
                    </div>

                    {{-- Video Bilgileri --}}
                    <div class="flex gap-3">
                        {{-- Video Detayları --}}
                        <div class="flex-1">
                            <a href="{{ route('video.watch', [$video->uid]) }}"
                               class="block font-medium text-white text-base line-clamp-2 hover:text-blue-400">
                                {{ $video->title }}
                            </a>
                            <div class="mt-1 text-sm text-gray-400 space-y-1">
                                <p>{{ number_format(rand(100, 10000)) }} görüntüleme • {{ $video->created_at->diffForHumans() }}</p>
                                <p>{{ ucfirst($video->visibility) }}</p>
                            </div>
                        </div>

                        {{-- Video Menü --}}
                        <div class="flex-shrink-0">
                            <button class="p-2 hover:bg-[#272727] rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fas fa-ellipsis-vertical text-white"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center py-16">
                    <div class="w-16 h-16 bg-[#272727] rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-video text-2xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-white mb-2">Henüz video yok</h3>
                    <p class="text-gray-400 text-center">Bu kanala video yüklendiğinde burada görünecek.</p>
                    @auth
                        @if(auth()->id() === $channel->user_id)
                            <a href="{{ route('video.page', $channel->uid) }}"
                               class="mt-6 px-6 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-600 transition">
                                Video Yükle
                            </a>
                        @endif
                    @endauth
                </div>
            @endforelse
        </div>

        <style>
            .thin-scrollbar::-webkit-scrollbar {
                height: 3px;
            }
            .thin-scrollbar::-webkit-scrollbar-track {
                background: transparent;
            }
            .thin-scrollbar::-webkit-scrollbar-thumb {
                background-color: #404040;
                border-radius: 3px;
            }
            .thin-scrollbar::-webkit-scrollbar-thumb:hover {
                background-color: #505050;
            }
        </style>
    </div>
@endsection
