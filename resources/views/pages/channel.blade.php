@extends('layouts.app', [
    'title' => $channel->name . ' | YouTube'
])

@push('footer')
    <script>
        function showTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(content => {
                content.style.display = 'none';
            });

            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('border-black', 'text-black');
                btn.classList.add('border-transparent');
            });

            document.getElementById(tabId).style.display = 'block';

            const activeBtn = document.querySelector(`[data-tab="${tabId}"]`);
            activeBtn.classList.remove('border-transparent');
            activeBtn.classList.add('border-black', 'text-black');

            const url = new URL(window.location);
            url.searchParams.set('tab', tabId);
            window.history.pushState({}, '', url);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const activeTab = urlParams.get('tab') || 'videos';
            showTab(activeTab);
        });
    </script>
@endpush

@section('content')
    <div class="min-h-screen text-black bg-white">
        {{-- Kanal Banner --}}
        <div class="relative w-full h-[180px] md:h-[220px] lg:h-[260px] bg-gray-200">
            @if($channel->banner)
                <img src="{{ asset($channel->banner) }}" alt="Channel Banner" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-b from-white/60 to-transparent"></div>
            @else
                <div class="flex items-center justify-center h-full text-gray-500 text-sm">
                    <i class="fas fa-image mr-2"></i>
                    Kanal kapağı yüklenmedi
                </div>
            @endif
        </div>

        {{-- Kanal Bilgileri --}}
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 -mt-12 relative z-10 mb-6">
                <div class="flex flex-col md:flex-row items-start md:items-end gap-6">
                    <img src="{{ $channel->image ? asset($channel->image) : asset('images/default-avatar.png') }}"
                         alt="Kanal Profil"
                         class="w-24 h-24 md:w-32 md:h-32 rounded-full border-4 border-white shadow-lg object-cover">

                    <div class="md:mb-2">
                        <h1 class="text-2xl font-semibold mb-1">{{ $channel->name }}</h1>
                        <div class="flex items-center gap-4 text-gray-600 text-sm">
                            <span>{{ '@' . $channel->slug }}</span>
                            <span>{{ number_format(rand(10000, 1000000)) }} abone</span>
                            <span>{{ number_format(rand(50, 500)) }} video</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                   @auth
                        <a href="#" class="bg-white text-black px-4 py-2 rounded-full font-medium border border-black hover:bg-black hover:text-white transition">
                            Kanal Ayarlar
                        </a>
                   @endauth

                </div>
            </div>

            {{-- Sekmeler --}}
            <div class="border-b border-gray-300 mt-4">
                <div class="max-w-7xl mx-auto">
                    <div class="px-4 flex gap-8 text-gray-600 font-medium overflow-x-auto thin-scrollbar">
                        <button onclick="showTab('videos')" class="tab-btn py-4 border-b-2 border-black text-black whitespace-nowrap active" data-tab="videos">Videolar</button>
                        <button onclick="showTab('about')" class="tab-btn py-4 border-b-2 border-transparent hover:text-black whitespace-nowrap" data-tab="about">Hakkında</button>
                    </div>
                </div>
            </div>

            {{-- Tab Contents --}}
            <div id="videos" class="tab-content max-w-7xl mx-auto px-4" style="display: block;">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-x-4 gap-y-8 pb-16">
                    @forelse($channel->videos as $video)
                        <div class="group relative bg-white rounded-xl shadow hover:shadow-lg transition">
                            {{-- Video Thumbnail --}}
                            <div class="relative aspect-video rounded-xl overflow-hidden mb-3">
                                <a href="{{ route('video.watch', [$video->uid]) }}" class="block w-full h-full">
                                    @if($video->image || $video->thumbnail_image)
                                        <img src="{{ asset($video->image) ?? Storage::url('videos/' . $video->uid . '/' . $video->thumbnail_image) }}"
                                             alt="{{ $video->title }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                    @else
                                        <div class="flex items-center justify-center h-full bg-gray-100 text-gray-500">
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
                            <div class="flex gap-3 px-2 pb-2">
                                <div class="flex-1">
                                    <a href="{{ route('video.watch', [$video->uid]) }}"
                                       class="block font-medium text-black text-base line-clamp-2 hover:text-blue-600">
                                        {{ $video->title }}
                                    </a>
                                    <div class="mt-1 text-sm text-gray-600 space-y-1">
                                        <p>{{ number_format(rand(100, 10000)) }} görüntüleme • {{ $video->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>

                                <div class="flex-shrink-0">
                                    <button class="p-2 hover:bg-gray-200 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                                        <i class="fas fa-ellipsis-vertical text-black"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full flex flex-col items-center justify-center py-16">
                            <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-video text-2xl text-gray-500"></i>
                            </div>
                            <h3 class="text-lg font-medium text-black mb-2">Henüz video yok</h3>
                            <p class="text-gray-600 text-center">Bu kanala video yüklendiğinde burada görünecek.</p>
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
            </div>

            {{-- About Tab --}}
            <div id="about" class="tab-content max-w-7xl mx-auto px-4 pb-16" style="display: none;">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Sol Sütun - Kanal Açıklaması -->
                    <div class="lg:col-span-2">
                        <div class="bg-white shadow-md rounded-xl p-6">
                            <h3 class="text-lg font-semibold mb-4 text-black">Açıklama</h3>
                            <p class="text-gray-700 whitespace-pre-line">{{ $channel->description ?? 'Henüz bir kanal açıklaması eklenmemiş.' }}</p>
                        </div>
                    </div>

                    <!-- Sağ Sütun - İstatistikler -->
                    <div>
                        <div class="bg-white shadow-md rounded-xl p-6">
                            <h3 class="text-lg font-semibold mb-4 text-black">İstatistikler</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-gray-600">Katılma tarihi</p>
                                    <p class="text-black font-medium">{{ $channel->created_at->format('d F Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Toplam görüntülenme</p>
                                    <p class="text-black font-medium">{{ $views }}</p>
                                </div>
<!--                                <div>
                                    <p class="text-gray-600">Konum</p>
                                    <p class="text-black font-medium"></p>
                                </div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .thin-scrollbar::-webkit-scrollbar {
                    height: 3px;
                }
                .thin-scrollbar::-webkit-scrollbar-track {
                    background: transparent;
                }
                .thin-scrollbar::-webkit-scrollbar-thumb {
                    background-color: #c0c0c0;
                    border-radius: 3px;
                }
                .thin-scrollbar::-webkit-scrollbar-thumb:hover {
                    background-color: #a0a0a0;
                }
            </style>
        </div>
    </div>
@endsection
