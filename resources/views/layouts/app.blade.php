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
    <link rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css') }}" />
</head>
<body>
<div id="app" class="bg-gray-50 text-gray-800">
    <nav class="bg-white shadow-md p-4 sticky top-0 z-10">
        <div class="container mx-auto flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <!-- Logo -->
            <a href="{{ route('home') }}">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-play-circle text-red-600 text-2xl"></i>
                    <span class="font-bold text-xl">VideoPay</span>
                </div>
            </a>

            <!-- Arama Çubuğu -->
            <div class="w-full md:w-1/3">
                <input type="text" placeholder="Video ara..."
                       class="w-full px-4 py-2 border rounded-full focus:outline-none focus:ring-2 focus:ring-blue-300">
            </div>

            <!-- Giriş ve Kayıt / Kullanıcı Menü -->
            <div class="flex items-center space-x-2">
                @guest
                    <a href="{{ route('login.page') }}">
                        <button class="px-4 py-2 rounded-full hover:bg-gray-100 transition">Giriş</button>
                    </a>
                    <a href="{{ route('register.page') }}">
                        <button class="bg-red-600 text-white px-4 py-2 rounded-full hover:bg-red-700 transition">
                            Kayıt Ol
                        </button>
                    </a>
                @else
                    <a href="{{ route('channel', Auth::user()->channel->slug) }}"><span class="px-4 py-2">{{ auth()->user()->name }}</span></a>
                    <a href="{{ route('video.page', Auth::user()->channel->uid) }}">
                        <button class="bg-red-600 text-white px-4 py-2 rounded-full hover:bg-red-700 transition">
                            <i class="fas fa-upload mr-2"></i>Video Yükle
                        </button>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="bg-gray-200 text-gray-800 px-4 py-2 rounded-full hover:bg-gray-300 transition">
                            Çıkış Yap
                        </button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="bg-gray-100 p-6 mt-8 border-t">
        <div class="container mx-auto text-center text-gray-600">
            <p>© 2025 VideoPay. Tüm hakları saklıdır.</p>
        </div>
    </footer>
</div>

<script>
    const vueMixinFunctions = [
        () => ({
            data() {
                return {
                    showModal: false
                }
            },
			components: {
				Modal
			},
				watch: {
				"appStore": function(){
					this.appStore.setAuth(@json(auth()->user()));
					this.appStore.setEnv({
						APP_NAME: '{{config('app.name')}}',
						APP_ENV: '{{env('APP_ENV')}}',
						MODULE_NAME: 'MAIN'
					})
				}
			}
		})
	];
</script>
@stack('footer')

</body>
</html>
