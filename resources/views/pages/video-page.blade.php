@extends('layouts.app', [
    'title' => $video->title . ' | YouTube'
])

@section('content')
    <div class="flex flex-col lg:flex-row gap-6 px-4 lg:px-6 py-4">

            {{-- Sol Bölüm: Video ve Detayları --}}
            <div class="flex-1">
                {{-- Video Player --}}
                <div class="w-full bg-black aspect-video rounded-xl overflow-hidden">
                    <video
                        controls
                        autoplay
                        class="w-full h-full"
                        poster="{{ Storage::url('videos/' . $video->uid . '/' . $video->thumbnail_image) }}"
                    >
                        <source src="{{ Storage::url('videos/' . $video->uid . '/' . $video->processed_file) }}" type="video/mp4">
                        Tarayıcınız video etiketini desteklemiyor.
                    </video>
                </div>

                {{-- Video Başlık ve Detaylar --}}
                <div class="mt-3">
                    <h1 class="text-xl font-medium text-white">{{ $video->title }}</h1>

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mt-2 gap-4">
                        {{-- Sol: Kanal Bilgileri ve Abone Ol --}}
                        <div class="flex items-center gap-4">
                            <a href="{{ route('channel', $video->channel->slug) }}" class="flex items-center gap-3">
                                <img
                                    src="{{ $video->channel->image ? Storage::url($video->channel->image) : asset('images/default-avatar.png') }}"
                                    alt="{{ $video->channel->name }}"
                                    class="w-10 h-10 rounded-full"
                                >
                                <div>
                                    <div class="font-medium text-white">{{ $video->channel->name }}</div>
                                    <div class="text-sm text-gray-400">{{ number_format(rand(1000, 1000000)) }} abone</div>
                                </div>
                            </a>
                            <button class="bg-white text-black px-4 py-2 rounded-full font-medium hover:bg-gray-100 transition">
                                Abone ol
                            </button>
                        </div>

                        {{-- Sağ: Etkileşim Butonları --}}
                        <div class="flex items-center gap-2">
                            <div class="flex bg-[#272727] rounded-full">
                                <button
                                    class="flex items-center gap-2 px-4 py-2 hover:bg-[#3f3f3f] rounded-l-full transition"
                                    @click="likeVideo({{ $video->id }})"
                                >
                                    <i class="far fa-thumbs-up"></i>
                                    <span>{{ number_format($video->likes_count) }}</span>
                                </button>
                                <div class="w-px bg-[#4d4d4d]"></div>
                                <button
                                    class="flex items-center gap-2 px-4 py-2 hover:bg-[#3f3f3f] rounded-r-full transition"
                                    @click="dislikeVideo({{ $video->id }})"
                                >
                                    <i class="far fa-thumbs-down"></i>
                                </button>
                            </div>

                            <button class="flex items-center gap-2 px-4 py-2 bg-[#272727] hover:bg-[#3f3f3f] rounded-full transition">
                                <i class="fas fa-share"></i>
                                <span>Paylaş</span>
                            </button>

                            <button class="p-2 hover:bg-[#272727] rounded-full transition">
                                <i class="fas fa-ellipsis"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Kanal Bilgileri --}}
                <div class="flex items-center justify-between border-t border-gray-200 pt-5">
                    <div class="flex items-center gap-4">
                        <img src="{{ Storage::url($video->channel->image ?? 'defaults/avatar.png') }}" alt="Profil"
                             class="w-12 h-12 rounded-full object-cover shadow-md">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $video->channel->name }}</p>
                            <p class="text-gray-500 text-sm">0 abone</p>
                        </div>
                    </div>
                    <button class="px-6 py-2 bg-red-600 text-white font-medium rounded-full hover:bg-red-700 transition">
                        Abone Ol
                    </button>
                </div>

                {{-- Açıklama --}}
                <div class="bg-gray-100 rounded-xl p-4 text-gray-800">
                    <p>{{ $video->description }}</p>
                </div>

                {{-- Video Açıklaması --}}
                <div class="mt-4 p-3 bg-[#272727] rounded-xl">
                    <div class="flex items-center gap-2 text-white text-sm mb-2">
                        <span>{{ number_format($video->views) }} görüntüleme</span>
                        <span>•</span>
                        <span>{{ $video->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-white whitespace-pre-line">{{ $video->description }}</p>
                </div>

                {{-- Yorumlar Bölümü --}}
                <div class="mt-6">
                    <div class="flex items-center gap-2 mb-4">
                        <h3 class="text-white font-medium">Yorumlar</h3>
                        <span class="text-gray-400">{{ number_format(rand(100, 1000)) }}</span>
                    </div>

                    {{-- Yorum Yazma --}}
                    <div class="flex gap-3 mb-6">
                        <img
                            src="{{ auth()->check() ? (auth()->user()->profile_image ? Storage::url(auth()->user()->profile_image) : asset('images/default-avatar.png')) : asset('images/default-avatar.png') }}"
                            class="w-10 h-10 rounded-full"
                        >
                        <div class="flex-1">
                            <input
                                type="text"
                                placeholder="Yorum ekle..."
                                class="w-full bg-transparent border-b border-[#272727] focus:border-white pb-1 outline-none text-white"
                            >
                        </div>
                    </div>

                    {{-- Yorum Listesi --}}
                    <div class="space-y-4">
                        @for($i = 1; $i <= 5; $i++)
                            <div class="flex gap-3">
                                <img
                                    src="https://picsum.photos/40/40?random={{ $i }}"
                                    class="w-10 h-10 rounded-full"
                                >
                                <div>
                                    <div class="flex items-center gap-2">
                                        <a href="#" class="text-white text-sm font-medium">Kullanıcı {{ $i }}</a>
                                        <span class="text-gray-400 text-sm">{{ rand(1, 11) }} gün önce</span>
                                    </div>
                                    <p class="text-white text-sm mt-1">
                                        Örnek yorum {{ $i }}. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                    </p>
                                    <div class="flex items-center gap-4 mt-2">
                                        <button class="flex items-center gap-1 text-gray-400 hover:text-white">
                                            <i class="far fa-thumbs-up text-sm"></i>
                                            <span class="text-xs">{{ rand(1, 999) }}</span>
                                        </button>
                                        <button class="flex items-center gap-1 text-gray-400 hover:text-white">
                                            <i class="far fa-thumbs-down text-sm"></i>
                                        </button>
                                        <button class="text-gray-400 hover:text-white text-sm">Yanıtla</button>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

            {{-- Sağ Bölüm: Önerilen Videolar --}}
            <div class="lg:w-[400px] space-y-4">
                @for($i = 1; $i <= 10; $i++)
                    <div class="flex gap-2 group cursor-pointer">
                        {{-- Video Thumbnail --}}
                        <div class="relative flex-shrink-0 w-40 sm:w-48 lg:w-40">
                            <div class="aspect-video rounded-lg overflow-hidden">
                                <img
                                    src="https://picsum.photos/320/180?random={{ $i }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition duration-300"
                                >
                            </div>
                            <div class="absolute bottom-1 right-1 bg-black/80 text-white text-xs px-1 rounded">
                                {{ rand(1, 59) }}:{{ str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT) }}
                            </div>
                        </div>

                        {{-- Video Bilgileri --}}
                        <div class="flex-1">
                            <h3 class="text-white text-sm font-medium line-clamp-2 group-hover:text-blue-400">
                                Önerilen Video Başlığı {{ $i }}
                            </h3>
                            <a href="#" class="block text-gray-400 text-xs mt-1 hover:text-white">
                                Kanal Adı {{ $i }}
                            </a>
                            <div class="text-gray-400 text-xs mt-1">
                                {{ number_format(rand(1000, 999999)) }} görüntüleme •
                                {{ rand(1, 11) }} gün önce
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

        </div>
    </div>
@endsection
