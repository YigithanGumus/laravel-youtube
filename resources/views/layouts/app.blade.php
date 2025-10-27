<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$title ?? config('app.name')}}</title>

    @stack('header')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body class="bg-[#0f0f0f] text-white">
<div id="app" class="flex flex-col min-h-screen">
    <!-- Sol Sidebar -->
    <aside id="sidebar" class="fixed left-0 top-0 h-full w-64 bg-[#0f0f0f] z-30 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
        <div class="flex flex-col h-full">
            <!-- Logo Bölümü -->
            <div class="p-4 flex items-center space-x-4">
                <button id="menu-toggle" class="lg:hidden p-2 hover:bg-gray-800 rounded-full">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <i class="fab fa-youtube text-red-600 text-3xl"></i>
                    <span class="font-bold text-xl">YouTube</span>
                </a>
            </div>

            <!-- Ana Menü -->
            <nav class="flex-1 px-2 py-4 overflow-y-auto thin-scrollbar">
                <div class="space-y-1">
                    <a href="{{ route('home') }}" class="flex items-center px-4 py-2 text-white hover:bg-gray-800 rounded-xl">
                        <i class="fas fa-home w-6 text-xl"></i>
                        <span class="ml-3 text-sm">Ana Sayfa</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-white hover:bg-gray-800 rounded-xl">
                        <i class="fas fa-compass w-6 text-xl"></i>
                        <span class="ml-3 text-sm">Keşfet</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-white hover:bg-gray-800 rounded-xl">
                        <i class="fas fa-play-circle w-6 text-xl"></i>
                        <span class="ml-3 text-sm">Shorts</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-white hover:bg-gray-800 rounded-xl">
                        <i class="fas fa-tv w-6 text-xl"></i>
                        <span class="ml-3 text-sm">Abonelikler</span>
                    </a>
                </div>

                <hr class="my-4 border-gray-700">

                <div class="space-y-1">
                    <div class="px-4 py-2 text-sm text-gray-400">Kitaplık</div>
                    <a href="#" class="flex items-center px-4 py-2 text-white hover:bg-gray-800 rounded-xl">
                        <i class="fas fa-clock-rotate-left w-6 text-xl"></i>
                        <span class="ml-3 text-sm">Geçmiş</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-white hover:bg-gray-800 rounded-xl">
                        <i class="fas fa-clock w-6 text-xl"></i>
                        <span class="ml-3 text-sm">Daha Sonra İzle</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-white hover:bg-gray-800 rounded-xl">
                        <i class="fas fa-thumbs-up w-6 text-xl"></i>
                        <span class="ml-3 text-sm">Beğendiğim Videolar</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-white hover:bg-gray-800 rounded-xl">
                        <i class="fas fa-download w-6 text-xl"></i>
                        <span class="ml-3 text-sm">İndirilenler</span>
                    </a>
                </div>

                @auth
                <hr class="my-4 border-gray-700">

                <div class="space-y-1">
                    <div class="px-4 py-2 text-sm text-gray-400">Abonelikler</div>
                    <!-- Abonelikleri döngü ile listele -->
                    <a href="#" class="flex items-center px-4 py-2 text-white hover:bg-gray-800 rounded-xl">
                        <img src="https://via.placeholder.com/24" alt="Channel" class="w-6 h-6 rounded-full">
                        <span class="ml-3 text-sm truncate">Kanal Adı 1</span>
                        <span class="ml-auto">
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                        </span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-white hover:bg-gray-800 rounded-xl">
                        <img src="https://via.placeholder.com/24" alt="Channel" class="w-6 h-6 rounded-full">
                        <span class="ml-3 text-sm truncate">Kanal Adı 2</span>
                    </a>
                </div>

                <hr class="my-4 border-gray-700">

                <div class="space-y-1">
                    <div class="px-4 py-2 text-sm text-gray-400">Keşfet</div>
                    <a href="#" class="flex items-center px-4 py-2 text-white hover:bg-gray-800 rounded-xl">
                        <i class="fas fa-fire w-6 text-xl"></i>
                        <span class="ml-3 text-sm">Trendler</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-white hover:bg-gray-800 rounded-xl">
                        <i class="fas fa-music w-6 text-xl"></i>
                        <span class="ml-3 text-sm">Müzik</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-white hover:bg-gray-800 rounded-xl">
                        <i class="fas fa-gamepad w-6 text-xl"></i>
                        <span class="ml-3 text-sm">Oyun</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-white hover:bg-gray-800 rounded-xl">
                        <i class="fas fa-newspaper w-6 text-xl"></i>
                        <span class="ml-3 text-sm">Haberler</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-white hover:bg-gray-800 rounded-xl">
                        <i class="fas fa-trophy w-6 text-xl"></i>
                        <span class="ml-3 text-sm">Spor</span>
                    </a>
                </div>
                @endauth

                <hr class="my-4 border-gray-700">

                <div class="space-y-1 pb-4">
                    <div class="px-4 py-2 text-sm text-gray-400">YouTube'dan Daha Fazlası</div>
                    <a href="#" class="flex items-center px-4 py-2 text-white hover:bg-gray-800 rounded-xl">
                        <i class="fab fa-youtube text-red-600 w-6 text-xl"></i>
                        <span class="ml-3 text-sm">YouTube Premium</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-white hover:bg-gray-800 rounded-xl">
                        <i class="fas fa-film w-6 text-xl"></i>
                        <span class="ml-3 text-sm">YouTube Films</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-white hover:bg-gray-800 rounded-xl">
                        <i class="fas fa-cog w-6 text-xl"></i>
                        <span class="ml-3 text-sm">Ayarlar</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-white hover:bg-gray-800 rounded-xl">
                        <i class="fas fa-flag w-6 text-xl"></i>
                        <span class="ml-3 text-sm">İçerik Bildirme</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-white hover:bg-gray-800 rounded-xl">
                        <i class="fas fa-question-circle w-6 text-xl"></i>
                        <span class="ml-3 text-sm">Yardım</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-white hover:bg-gray-800 rounded-xl">
                        <i class="fas fa-exclamation-circle w-6 text-xl"></i>
                        <span class="ml-3 text-sm">Geri Bildirim</span>
                    </a>
                </div>
            </nav>

            <style>
                .thin-scrollbar::-webkit-scrollbar {
                    width: 8px;
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
        </div>
    </aside>

    <!-- Üst Menü -->
    <nav class="fixed top-0 right-0 left-0 bg-[#0f0f0f] h-14 z-20 lg:pl-64">
        <div class="flex items-center justify-between h-full px-4">
            <!-- Sol Bölüm - Mobil Menü -->
            <div class="lg:hidden flex items-center">
                <button id="mobile-menu-button" class="p-2 hover:bg-gray-800 rounded-full">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <a href="{{ route('home') }}" class="flex items-center space-x-2 ml-2">
                    <i class="fab fa-youtube text-red-600 text-2xl"></i>
                    <span class="font-bold text-lg">YouTube</span>
                </a>
            </div>

            <!-- Orta Bölüm - Arama -->
            <div class="flex-1 max-w-2xl mx-auto flex items-center px-4">
                <div class="relative flex-1 flex items-center">
                    <input type="text" placeholder="Ara"
                           class="w-full bg-[#121212] border border-gray-700 rounded-l-full px-4 py-2 focus:outline-none focus:border-blue-500">
                    <button class="px-6 py-2 bg-[#222222] border border-l-0 border-gray-700 rounded-r-full hover:bg-[#313131]">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <button class="ml-4 p-2 hover:bg-gray-800 rounded-full">
                    <i class="fas fa-microphone"></i>
                </button>
            </div>

            <!-- Sağ Bölüm - Kullanıcı Menüsü -->
            <div class="flex items-center space-x-2">
                @guest
                    <div class="flex items-center space-x-4">
                        <button class="p-2 hover:bg-gray-800 rounded-full" title="Ayarlar">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <a href="{{ route('login.page') }}" class="flex items-center space-x-2 border border-[#3ea6ff] text-[#3ea6ff] hover:bg-[#263850] px-3 py-1.5 rounded-full">
                            <i class="far fa-user-circle"></i>
                            <span class="text-sm font-medium">Oturum aç</span>
                        </a>
                    </div>
                @else
                    <div class="flex items-center space-x-2">
                        <button id="create-button" class="relative p-2 hover:bg-gray-800 rounded-full group">
                            <i class="fas fa-video"></i>
                            <div class="hidden group-hover:block absolute right-0 mt-2 w-48 bg-[#282828] rounded-xl shadow-lg py-2 z-50">
                                <a href="{{ route('video.page', Auth::user()->channel->uid) }}" class="flex items-center px-4 py-2 hover:bg-gray-700">
                                    <i class="fas fa-video w-5"></i>
                                    <span class="ml-3 text-sm">Video Yükle</span>
                                </a>
                                <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-700">
                                    <i class="fas fa-broadcast-tower w-5"></i>
                                    <span class="ml-3 text-sm">Canlı Yayın</span>
                                </a>
                            </div>
                        </button>
                        <button id="notifications-button" class="relative p-2 hover:bg-gray-800 rounded-full group">
                            <i class="fas fa-bell"></i>
                            <span class="absolute top-0 right-0 bg-red-600 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">3</span>
                            <div class="hidden group-hover:block absolute right-0 mt-2 w-80 bg-[#282828] rounded-xl shadow-lg py-2 z-50">
                                <div class="flex items-center justify-between px-4 py-2 border-b border-gray-700">
                                    <span class="font-medium">Bildirimler</span>
                                    <i class="fas fa-cog hover:text-gray-300 cursor-pointer"></i>
                                </div>
                                <div class="max-h-96 overflow-y-auto thin-scrollbar">
                                    <div class="p-4 hover:bg-gray-700 cursor-pointer">
                                        <div class="flex items-start space-x-3">
                                            <img src="https://via.placeholder.com/40" alt="Channel" class="w-10 h-10 rounded-full">
                                            <div class="flex-1">
                                                <p class="text-sm">Yeni video: "Laravel ile YouTube Klonu Yapımı"</p>
                                                <p class="text-xs text-gray-400 mt-1">2 saat önce</p>
                                            </div>
                                            <div class="text-gray-400">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Daha fazla bildirim... -->
                                </div>
                            </div>
                        </button>
                        <div class="relative">
                            <button id="user-menu-button" class="flex items-center space-x-2 focus:outline-none">
                                <img src="https://via.placeholder.com/32" alt="Avatar" class="w-8 h-8 rounded-full">
                            </button>
                            <div id="user-menu" class="hidden absolute right-0 mt-2 w-72 bg-[#282828] rounded-xl shadow-lg py-2 z-50">
                                <div class="px-4 py-2 border-b border-gray-700">
                                    <div class="flex items-center space-x-3">
                                        <img src="https://via.placeholder.com/40" alt="Avatar" class="w-10 h-10 rounded-full">
                                        <div class="flex-1">
                                            <div class="font-medium">{{ auth()->user()->name }}</div>
                                            <div class="text-sm text-gray-400 truncate">{{ auth()->user()->email }}</div>
                                            <a href="#" class="text-[#3ea6ff] text-sm hover:text-blue-400">Google Hesabınızı yönetin</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-2">
                                    <a href="{{ route('channel', Auth::user()->channel->slug) }}" class="flex items-center px-4 py-2 hover:bg-gray-700">
                                        <i class="far fa-user-circle w-5"></i>
                                        <span class="ml-3">Kanalım</span>
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-700">
                                        <i class="fas fa-user-shield w-5"></i>
                                        <span class="ml-3">YouTube Studio</span>
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-700">
                                        <i class="fas fa-user-friends w-5"></i>
                                        <span class="ml-3">Hesap değiştir</span>
                                    </a>
                                    <hr class="my-2 border-gray-700">
                                    <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-700">
                                        <i class="fas fa-moon w-5"></i>
                                        <span class="ml-3">Görünüm: Koyu</span>
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-700">
                                        <i class="fas fa-language w-5"></i>
                                        <span class="ml-3">Dil: Türkçe</span>
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-700">
                                        <i class="fas fa-shield-alt w-5"></i>
                                        <span class="ml-3">Kısıtlı Mod: Kapalı</span>
                                    </a>
                                    <hr class="my-2 border-gray-700">
                                    <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-700">
                                        <i class="fas fa-cog w-5"></i>
                                        <span class="ml-3">Ayarlar</span>
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center px-4 py-2 hover:bg-gray-700">
                                            <i class="fas fa-sign-out-alt w-5"></i>
                                            <span class="ml-3">Çıkış Yap</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    <main class="flex-grow pt-14 lg:pl-64">
        @yield('content')
    </main>

    <footer class="bg-[#0f0f0f] p-6 mt-8 border-t border-gray-800 lg:pl-64">
        <div class="container mx-auto text-center text-gray-400">
            <p>© 2025 YouTube. Tüm hakları saklıdır.</p>
        </div>
    </footer>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const sidebar = document.getElementById('sidebar');

        // Kullanıcı menüsü
        if (userMenuButton && userMenu) {
            userMenuButton.addEventListener('click', () => {
                userMenu.classList.toggle('hidden');
            });

            // Menü dışına tıklandığında menüyü kapat
            document.addEventListener('click', (event) => {
                if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                    userMenu.classList.add('hidden');
                }
            });
        }

        // Mobil menü
        if (mobileMenuButton && sidebar) {
            mobileMenuButton.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });

            // Sidebar dışına tıklandığında sidebar'ı kapat (sadece mobil görünümde)
            document.addEventListener('click', (event) => {
                if (window.innerWidth < 1024 && // lg breakpoint
                    !mobileMenuButton.contains(event.target) &&
                    !sidebar.contains(event.target)) {
                    sidebar.classList.add('-translate-x-full');
                }
            });
        }

        // Ekran boyutu değiştiğinde sidebar'ı kontrol et
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) { // lg breakpoint
                sidebar.classList.remove('-translate-x-full');
            } else {
                sidebar.classList.add('-translate-x-full');
            }
        });
    });
</script>

@stack('footer')
</body>
</html>
