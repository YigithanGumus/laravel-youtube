@extends('layouts.app', [
    'title' => $video->title . ' | LaravelTube'
])

@section('content')
    <div class="min-h-screen bg-gray-50 text-gray-900">

        <div class="max-w-7xl mx-auto px-4 py-8 flex flex-col lg:flex-row gap-8">

            {{-- === ANA VİDEO BÖLÜMÜ === --}}
            <div class="flex-1 flex flex-col gap-6">

                {{-- Video Player --}}
                <div class="w-full bg-black aspect-video rounded-2xl overflow-hidden shadow-2xl">
                    <video controls autoplay class="w-full h-full object-cover rounded-2xl">
                        <source src="{{ Storage::url('videos/' . $video->uid . '/' . $video->processed_file) }}" type="video/mp4">
                        Tarayıcınız video etiketini desteklemiyor.
                    </video>
                </div>

                {{-- Video Başlık ve Bilgiler --}}
                <div>
                    <h1 class="text-2xl font-semibold mb-2">{{ $video->title }}</h1>
                    <div class="flex flex-wrap items-center justify-between text-sm text-gray-600">
                        <div class="flex items-center gap-2">
                            <span>{{ number_format($video->views) }} görüntüleme</span>
                            <span>•</span>
                            <span>{{ $video->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            {{-- Beğen --}}
                            <button
                                class="flex items-center gap-2 px-4 py-2 bg-gray-100 rounded-full hover:bg-gray-200 transition group">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-5 h-5 text-gray-700 group-hover:text-blue-600 transition"
                                     fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M2 21h4V9H2v12zM22 10c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32a1 1 0 0 0-.29-.7L13.17 2 7.59 7.59C7.22 7.95 7 8.45 7 9v10a2 2 0 0 0 2 2h7c.82 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z" />
                                </svg>
                                <span class="text-sm text-gray-700 group-hover:text-blue-600">Beğen</span>
                            </button>

                            {{-- Beğenme --}}
                            <button
                                class="flex items-center gap-2 px-4 py-2 bg-gray-100 rounded-full hover:bg-gray-200 transition group">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-5 h-5 text-gray-700 group-hover:text-red-600 transition"
                                     fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M22 3h-4v12h4V3zM2 14c0 1.1.9 2 2 2h6.31l-.95 4.57-.03.32c0 .27.11.52.29.7l1.22 1.41 5.59-5.59c.37-.36.59-.86.59-1.41V7a2 2 0 0 0-2-2H8c-.82 0-1.54.5-1.84 1.22L3.14 13.27c-.09.23-.14.47-.14.73v0z" />
                                </svg>
                                <span class="text-sm text-gray-700 group-hover:text-red-600">Beğenme</span>
                            </button>

                            {{-- Paylaş --}}
                            <button
                                class="px-4 py-2 bg-gray-100 rounded-full hover:bg-gray-200 transition text-sm text-gray-700">
                                Paylaş
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

                {{-- === YORUMLAR === --}}
                <div class="mt-8">
                    <h2 class="text-xl font-semibold mb-4">Yorumlar</h2>

                    {{-- Yorum Yazma Alanı --}}
                    <div class="flex items-start gap-3 mb-6">
                        <img src="{{ Storage::url(auth()->user()->profile_image ?? 'defaults/avatar.png') }}"
                             class="w-10 h-10 rounded-full object-cover">
                        <div class="flex-1">
                            <textarea class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                      rows="2" placeholder="Yorum ekle..."></textarea>
                            <div class="flex justify-end gap-2 mt-2">
                                <button class="px-4 py-1 text-sm rounded-lg hover:bg-gray-200 transition">İptal</button>
                                <button class="px-4 py-1 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition">Paylaş</button>
                            </div>
                        </div>
                    </div>

                    {{-- Örnek Yorum --}}
                    <div class="flex items-start gap-3 mb-4">
                        <img src="{{ asset('images/default-avatar.png') }}" class="w-10 h-10 rounded-full object-cover">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">
                                Ahmet Yılmaz
                                <span class="text-gray-500 text-sm">• 2 gün önce</span>
                            </p>
                            <p class="text-gray-800 mt-1">Gerçekten çok bilgilendirici bir video olmuş, teşekkürler!</p>

                            <div class="flex items-center gap-4 mt-2 text-sm text-gray-500">

                                {{-- Beğen --}}
                                <button class="flex items-center gap-1 group hover:text-blue-600 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 group-hover:text-blue-600 transition" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M2 21h4V9H2v12zM22 10c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32a1 1 0 0 0-.29-.7L13.17 2 7.59 7.59C7.22 7.95 7 8.45 7 9v10a2 2 0 0 0 2 2h7c.82 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                    </svg>
                                    <span class="text-gray-500 group-hover:text-blue-600">12</span>
                                </button>

                                {{-- Beğenme --}}
                                <button class="flex items-center gap-1 group hover:text-red-600 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 group-hover:text-red-600 transition" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M22 3h-4v12h4V3zM2 14c0 1.1.9 2 2 2h6.31l-.95 4.57-.03.32c0 .27.11.52.29.7l1.22 1.41 5.59-5.59c.37-.36.59-.86.59-1.41V7a2 2 0 0 0-2-2H8c-.82 0-1.54.5-1.84 1.22L3.14 13.27c-.09.23-.14.47-.14.73v0z"/>
                                    </svg>
                                    <span class="text-gray-500 group-hover:text-red-600">1</span>
                                </button>

                                {{-- Yanıtla --}}
                                <button class="hover:text-blue-600 transition">Yanıtla</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- === ÖNERİLEN VİDEOLAR === --}}
            <div class="w-full lg:w-80 flex flex-col gap-4">
                <h2 class="font-semibold text-lg">Önerilen Videolar</h2>

                {{-- Örnek Kartlar --}}
                @foreach (range(1, 5) as $i)
                    <div class="flex gap-3 cursor-pointer hover:bg-gray-100 p-2 rounded-lg transition">
                        <div class="w-40 h-24 bg-gray-300 rounded-lg overflow-hidden">
                            <img src="https://picsum.photos/200/120?random={{ $i }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 flex flex-col justify-between">
                            <p class="text-sm font-semibold line-clamp-2">Önerilen Video Başlığı {{ $i }}</p>
                            <p class="text-xs text-gray-500">Kanal Adı</p>
                            <p class="text-xs text-gray-400">125K görüntüleme • 3 gün önce</p>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
@endsection
