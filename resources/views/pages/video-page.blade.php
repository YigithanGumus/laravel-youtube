@extends('layouts.app', [
    'title' => $video->title . ' | Stream'
])

@section('content')
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-6">
            {{-- Sol Bölüm: Video ve Detayları --}}
            <div class="flex-1">
                {{-- Video Player Container --}}
                <div class="relative bg-slate-900 rounded-lg overflow-hidden shadow-lg">
                    <div class="w-full aspect-video group">
                        <video
                            controls
                            autoplay
                            class="w-full h-full"
                            poster="{{ Storage::url('videos/' . $video->uid . '/' . $video->thumbnail_image) }}"
                        >
                            <source src="{{ Storage::url('videos/' . $video->uid . '/' . $video->processed_file) }}" type="video/mp4">
                            Tarayıcınız video etiketini desteklemiyor.
                        </video>

                        {{-- Video Controls Overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300">
                            <div class="absolute bottom-0 left-0 right-0 p-4">
                                <div class="flex items-center justify-between text-white">
                                    <div class="flex items-center space-x-4">
                                        <button class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-white/20 transition-colors">
                                            <i class="fas fa-play text-xl"></i>
                                        </button>
                                        <div class="flex items-center space-x-3">
                                            <span class="text-sm font-medium">0:00</span>
                                            <div class="w-96 h-1.5 bg-white/20 rounded-full overflow-hidden">
                                                <div class="w-0 h-full bg-slate-200 rounded-full"></div>
                                            </div>
                                            <span class="text-sm font-medium">{{ $video->duration }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <button class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-white/20 transition-colors">
                                            <i class="fas fa-closed-captioning"></i>
                                        </button>
                                        <button class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-white/20 transition-colors">
                                            <i class="fas fa-cog"></i>
                                        </button>
                                        <button class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-white/20 transition-colors">
                                            <i class="fas fa-expand"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                {{-- Video Başlık ve Detaylar --}}
                <div class="mt-6">
                    <h1 class="text-xl font-bold text-white">{{ $video->title }}</h1>

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mt-4 gap-4">
                        {{-- Sol: Kanal Bilgileri ve Abone Ol --}}
                        <div class="flex items-center gap-4">
                            <a href="{{ route('channel', $video->channel->slug) }}" class="flex items-center gap-4">
                                <div class="relative">
                                    <img
                                        src="{{ $video->channel->image ? Storage::url($video->channel->image) : asset('images/default-avatar.png') }}"
                                        alt="{{ $video->channel->name }}"
                                        class="w-12 h-12 rounded-full ring-2 ring-slate-100 dark:ring-slate-800"
                                    >
                                    @if($video->channel->verified)
                                        <div class="absolute -right-1 -bottom-1 bg-blue-500 text-white p-1 rounded-full text-xs">
                                            <i class="fas fa-check"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-semibold text-white">{{ $video->channel->name }}</div>
                                    <div class="text-sm text-slate-400">{{ number_format(rand(1000, 1000000)) }} takipçi</div>
                                </div>
                            </a>
                            <button class="bg-slate-900 dark:bg-slate-100 text-white dark:text-slate-900 px-6 py-2.5 rounded-lg font-medium hover:bg-slate-800 dark:hover:bg-slate-200 transition-colors">
                                Takip Et
                            </button>
                        </div>

                        {{-- Sağ: Etkileşim Butonları --}}
                        <div class="flex items-center gap-2">
                            <div class="flex bg-slate-100 dark:bg-slate-800 rounded-lg">
                                <button
                                    class="flex items-center gap-2 px-4 py-2.5 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-l-lg transition-colors"
                                    @click="likeVideo({{ $video->id }})"
                                >
                                    <i class="far fa-thumbs-up"></i>
                                    <span>{{ number_format($video->likes_count) }}</span>
                                </button>
                                <div class="w-px bg-slate-200 dark:bg-slate-700"></div>
                                <button
                                    class="flex items-center gap-2 px-4 py-2.5 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-r-lg transition-colors"
                                    @click="dislikeVideo({{ $video->id }})"
                                >
                                    <i class="far fa-thumbs-down"></i>
                                </button>
                            </div>

                            <button class="flex items-center gap-2 px-4 py-2.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-lg transition-colors">
                                <i class="fas fa-share"></i>
                                <span class="font-medium">Paylaş</span>
                            </button>

                            <button class="p-2.5 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors">
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
                <div class="bg-slate-800 rounded-xl p-4 text-white">
                    <p>{{ $video->description }}</p>
                </div>

                {{-- Video Açıklaması --}}
                <div class="mt-6 p-4 bg-slate-800 rounded-lg shadow-sm text-white">
                    <div class="flex items-center gap-2 text-slate-400 text-sm mb-3">
                        <span>{{ number_format($video->views) }} görüntüleme</span>
                        <span>•</span>
                        <span>{{ $video->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-slate-900 dark:text-white whitespace-pre-line">{{ $video->description }}</p>
                </div>

                {{-- Yorumlar Bölümü --}}
                <div class="mt-8">
                    <div class="flex items-center gap-3 mb-6">
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Yorumlar</h3>
                        <span class="text-slate-500 dark:text-slate-400">{{ number_format(rand(100, 1000)) }}</span>
                    </div>

                    {{-- Yorum Yazma --}}
                    <div class="flex gap-4 mb-8">
                        <img
                            src="{{ auth()->check() ? (auth()->user()->profile_image ? Storage::url(auth()->user()->profile_image) : asset('images/default-avatar.png')) : asset('images/default-avatar.png') }}"
                            class="w-10 h-10 rounded-full ring-2 ring-slate-100 dark:ring-slate-700"
                        >
                        <div class="flex-1">
                            <input
                                type="text"
                                placeholder="Düşüncelerinizi paylaşın..."
                                class="w-full bg-transparent border-b border-slate-200 dark:border-slate-700 focus:border-slate-900 dark:focus:border-slate-300 pb-2 outline-none text-slate-900 dark:text-white placeholder-slate-400"
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
            <div class="lg:w-96 w-full space-y-4">
                @for($i = 1; $i <= 10; $i++)
                    <div class="flex gap-3 group cursor-pointer bg-white dark:bg-slate-800 rounded-lg p-2 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                        {{-- Video Thumbnail --}}
                        <div class="relative flex-shrink-0 w-40 sm:w-48 lg:w-40">
                            <div class="aspect-video rounded-lg overflow-hidden">
                                <img
                                    src="https://picsum.photos/320/180?random={{ $i }}"
                                    class="w-full h-full object-cover transform group-hover:scale-105 transition duration-300"
                                >
                            </div>
                            <div class="absolute bottom-2 right-2 bg-black/75 text-white text-xs px-2 py-1 rounded-md">
                                {{ rand(1, 59) }}:{{ str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT) }}
                            </div>
                        </div>

                        {{-- Video Bilgileri --}}
                        <div class="flex-1 min-w-0">
                            <h3 class="text-slate-900 dark:text-white text-sm font-medium line-clamp-2 group-hover:text-slate-600 dark:group-hover:text-slate-300">
                                Önerilen Video Başlığı {{ $i }}
                            </h3>
                            <a href="#" class="block text-slate-600 dark:text-slate-400 text-xs mt-1.5 hover:text-slate-900 dark:hover:text-white">
                                Kanal Adı {{ $i }}
                            </a>
                            <div class="text-slate-500 dark:text-slate-500 text-xs mt-1">
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
