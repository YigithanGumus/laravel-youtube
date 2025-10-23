@extends('layouts.app', [
	"title" => "Kayıt Ol | LaravelTube"
])

@section('content')
    <div class="max-w-lg m-auto">
        <form class="mt-4" method="POST" action="{{ route('register.submit') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-1">Adınız</label>
                <input v-model="form.name" type="text" name="name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="Adınızı girin">
                <p v-if="errors.name" class="text-red-500 text-sm mt-1">@{{ errors.name[0] }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-1">Kanal Adınız</label>
                <input v-model="form.channel_name" type="text" name="channel_name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="Kanal Adınızı girin">
                <p v-if="errors.channel_name" class="text-red-500 text-sm mt-1">@{{ errors.channel_name[0] }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-1">E-posta</label>
                <input v-model="form.email" type="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="ornek@email.com">
                <p v-if="errors.email" class="text-red-500 text-sm mt-1">@{{ errors.email[0] }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-1">Şifre</label>
                <input v-model="form.password" type="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="Şifrenizi girin">
                <p v-if="errors.password" class="text-red-500 text-sm mt-1">@{{ errors.password[0] }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-1">Şifre (Tekrar)</label>
                <input v-model="form.password_confirmation" type="password" name="password_confirmation" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="Şifrenizi tekrar girin">
            </div>

            <div class="flex items-center mb-4">
                <input v-model="form.terms" type="checkbox" id="terms" class="mr-2">
                <label for="terms" class="text-sm text-gray-600">Kullanım koşullarını kabul ediyorum.</label>
            </div>

            <button type="submit" class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition">
                <span v-if="!loading">Kayıt Ol</span>
                <span v-else>Kaydediliyor...</span>
            </button>
        </form>

        <div class="mt-4 text-center text-sm text-gray-600">
            Zaten bir hesabınız var mı? <a href="#" class="text-red-600 hover:underline">Giriş Yap</a>
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
                        name: '',
                        email: '',
                        password: '',
                        password_confirmation: '',
                        channel_name: '',
                        terms: false,
                    },
                    errors: {},
                }
            },
            methods: {
                async registerUser(e) {
                    e.preventDefault();
                    this.loading = true;
                    this.errors = {};

                    try {
                        const res = await fetch('{{ route('register.submit') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                            body: JSON.stringify(this.form),
                        });

                        const data = await res.json();

                        if (!data.success) {
                            this.errors = data.errors || { global: 'Kayıt başarısız.' };
                            throw new Error('Validation or server error');
                        }

                        window.location.href = data.redirect;

                    } catch (err) {
                        console.error('Register error:', err);
                        if (!this.errors.global) {
                            this.errors.global = 'Sunucuya bağlanırken bir hata oluştu.';
                        }
                    } finally {
                        this.loading = false;
                    }
                },
            },
            mounted() {
                const form = document.querySelector('form');
                form.addEventListener('submit', this.registerUser);
            },
        }));
    </script>
@endpush

