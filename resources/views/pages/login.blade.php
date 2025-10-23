@extends('layouts.app', [
    "title" => "Giriş Yap | LaravelTube"
])

@section('content')
    <div class="max-w-lg m-auto mt-6">
        <form @submit.prevent="loginUser" class="bg-white shadow p-6 rounded-lg">
            <h2 class="text-2xl font-semibold mb-4 text-center">Giriş Yap</h2>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-1">E-posta</label>
                <input v-model="form.email" type="email"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300"
                       placeholder="ornek@email.com">
                <p v-if="errors.email" class="text-red-500 text-sm mt-1">@{{ errors.email[0] }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-1">Şifre</label>
                <input v-model="form.password" type="password"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300"
                       placeholder="Şifrenizi girin">
                <p v-if="errors.password" class="text-red-500 text-sm mt-1">@{{ errors.password[0] }}</p>
            </div>

            <button type="submit" :disabled="loading"
                    class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition">
                <span v-if="!loading">Giriş Yap</span>
                <span v-else>Giriş Yapılıyor...</span>
            </button>

            <p v-if="errors.global" class="text-red-500 text-sm mt-3">@{{ errors.global[0] }}</p>

            <div class="mt-4 text-center text-sm text-gray-600">
                Hesabınız yok mu?
                <a href="{{ route('register.page') }}" class="text-red-600 hover:underline">Kayıt Ol</a>
            </div>
        </form>
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
                }
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
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                            body: JSON.stringify(this.form),
                        });

                        // JSON dışı response geldiğinde yakala
                        const text = await res.text();
                        let data;
                        try {
                            data = JSON.parse(text);
                        } catch {
                            console.error('Non-JSON response:', text);
                            throw new Error('Sunucu beklenmedik bir yanıt döndürdü.');
                        }

                        if (!res.ok) {
                            this.errors = data.errors || { global: ['Giriş başarısız.'] };
                            return;
                        }

                        if (data.success) {
                            window.location.href = data.redirect;
                        } else {
                            this.errors = data.errors || { global: ['Geçersiz giriş bilgileri.'] };
                        }

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
