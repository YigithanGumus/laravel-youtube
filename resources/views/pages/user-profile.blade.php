@extends('layouts.app', [
    'title' => "Profil Sayfası",
])

@section('content')
    <div class="min-h-screen bg-gray-50 flex justify-center items-start py-10">
        <div class="w-full max-w-3xl bg-white shadow-lg rounded-xl p-8">
            <h1 class="text-2xl font-semibold mb-6 text-black">Profil Bilgilerini Güncelle</h1>

            <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Profil Resmi --}}
                <div class="flex flex-col items-center">
                    <label class="mb-2 text-gray-700 font-medium">Profil Resmi</label>
                    <div class="relative w-32 h-32">
                        <img id="profilePreview" src="{{ $user->profile_image ? asset($user->profile_image) : asset('images/default-avatar.png') }}"
                             alt="Profil Resmi"
                             class="w-32 h-32 rounded-full object-cover border-2 border-gray-300 shadow-sm">
                        <input type="file" name="profile_image" id="profileImage" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer rounded-full">
                    </div>
                    <p class="text-gray-400 text-sm mt-2">Yeni bir fotoğraf yüklemek için tıklayın</p>
                </div>

                {{-- İsim --}}
                <div>
                    <label for="name" class="block text-gray-700 font-medium mb-2">Ad Soyad</label>
                    <input type="text" name="name" id="name" value="{{ $user->name }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ $user->email }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                </div>

                {{-- Şifre --}}
                <div>
                    <label for="password" class="block text-gray-700 font-medium mb-2">Yeni Şifre</label>
                    <input type="password" name="password" id="password" placeholder="Yeni şifrenizi girin"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                    <p class="text-gray-400 text-sm mt-1">Şifreyi değiştirmek istemiyorsanız boş bırakabilirsiniz.</p>
                </div>

                {{-- Güncelleme Butonu --}}
                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-white text-black border border-black px-6 py-2 rounded-full font-medium hover:bg-black hover:text-white transition">
                        Bilgileri Güncelle
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- JS: Profil resmi önizleme --}}
    <script>
        const profileImage = document.getElementById('profileImage');
        const profilePreview = document.getElementById('profilePreview');

        profileImage.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if(file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    profilePreview.src = event.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
