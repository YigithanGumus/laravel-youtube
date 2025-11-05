@extends('layouts.app', [
    "title" => "Giriş Yap | YouTube"
])

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="max-w-md mx-auto mt-6">
            <div class="bg-white p-8 rounded-lg shadow-lg border border-gray-200">
                {{-- Logo ve Başlık --}}
                <div class="text-center mb-8">
                    <i class="fab fa-youtube text-red-600 text-4xl mb-4"></i>
                    <h2 class="text-2xl font-medium text-gray-900">YouTube'a Giriş Yap</h2>
                    <p class="text-gray-600 mt-2">YouTube'un tüm özelliklerinden yararlanın</p>
                </div>

                <form @submit.prevent="loginUser" method="POST">
                    @csrf
                    {{-- E-posta Input --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-medium mb-2">E-posta</label>
                        <div class="relative">
                            <input v-model="form.email" type="email"
                                   class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                   placeholder="ornek@email.com">
                            <i class="fas fa-envelope absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <p v-if="errors.email" class="text-red-600 text-sm mt-1">@{{ errors.email[0] }}</p>
                    </div>

                    {{-- Şifre Input --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Şifre</label>
                        <div class="relative">
                            <input v-model="form.password" type="password"
                                   class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                   placeholder="••••••••">
                            <i class="fas fa-lock absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <p v-if="errors.password" class="text-red-600 text-sm mt-1">@{{ errors.password[0] }}</p>
                    </div>

                    {{-- Şifremi Unuttum & Beni Hatırla --}}
                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 bg-white border border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">Beni hatırla</span>
                        </label>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-500">Şifremi unuttum</a>
                    </div>

                    {{-- Giriş Yap Butonu --}}
                    <button type="submit" :disabled="loading"
                            class="w-full bg-blue-600 text-white py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors duration-200 mb-4"
                            :class="{'opacity-75 cursor-not-allowed': loading}"
                    >
                    <span v-if="!loading" class="flex items-center justify-center">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Giriş Yap
                    </span>
                        <span v-else class="flex items-center justify-center">
                        <i class="fas fa-circle-notch fa-spin mr-2"></i>
                        Giriş Yapılıyor...
                    </span>
                    </button>

                    <p v-if="errors.global" class="text-red-600 text-sm text-center mb-4">@{{ errors.global[0] }}</p>

                    {{-- Alternatif Giriş Yöntemleri --}}
                    <div class="relative mb-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 text-gray-500 bg-white">Veya şununla devam et</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <button type="button" class="flex items-center justify-center gap-2 px-4 py-2 bg-white text-gray-800 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors duration-200">
                            <i class="fab fa-google text-red-500"></i>
                            <span class="text-sm">Google</span>
                        </button>
                        <button type="button" class="flex items-center justify-center gap-2 px-4 py-2 bg-white text-gray-800 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors duration-200">
                            <i class="fab fa-github text-gray-800"></i>
                            <span class="text-sm">GitHub</span>
                        </button>
                    </div>

                    {{-- Kayıt Ol Linki --}}
                    <div class="text-center text-gray-600 text-sm">
                        Hesabınız yok mu?
                        <a href="{{ route('register.page') }}" class="text-blue-600 hover:text-blue-500">Kayıt ol</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('footer')
    <script>

        vueMixinFunctions.push(() => ({
            data() {
                return {
                    loading: false,
                    form: {
                        email: '',
                        password: '',
                    },
                    errors: {},
                };
            },
            methods: {
                async loginUser() {
                    this.loading = true;
                    this.errors = {};

                    try {
                        const res = await fetch('{{ route('login.submit') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(this.form)
                        });

                        const text = await res.text();
                        let data;

                        try {
                            data = JSON.parse(text);
                        } catch {
                            console.error('Non-JSON response:', text);
                            throw new Error('Sunucu beklenmedik bir yanıt döndürdü.');
                        }

                        if (!res.ok || !data.success) {
                            this.errors = data.errors || { global: ['Giriş başarısız.'] };
                            return;
                        }

                        // Başarılı giriş
                        window.location.href = data.redirect;

                    } catch (err) {
                        console.error('Login error:', err);
                        this.errors.global = ['Sunucuya bağlanırken bir hata oluştu.'];
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }));
    </script>
@endpush

