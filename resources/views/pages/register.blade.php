@extends('layouts.app', [
    "title" => "Kayıt Ol | LaravelTube"
])

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="max-w-lg mx-auto mt-8 p-6 bg-[#282828] rounded-lg shadow-lg">
        <h1 class="text-2xl font-semibold text-white mb-6 text-center">Hesap Oluştur</h1>

        <div v-if="globalError" class="mb-4 p-4 bg-red-500 bg-opacity-10 border border-red-500 rounded-lg">
            <p class="text-red-500 text-sm">@{{ globalError }}</p>
        </div>

        <form @submit.prevent="registerUser" enctype="multipart/form-data">
            @csrf

            {{-- Ad Soyad --}}
            <div class="mb-4">
                <label class="block text-gray-300 text-sm font-medium mb-1">Ad Soyad</label>
                <input
                    v-model="form.name"
                    type="text"
                    name="name"
                    class="w-full px-4 py-2 bg-[#1f1f1f] border"
                    :class="[
                        validationErrors.name ? 'border-red-500' : 'border-[#3f3f3f]',
                        'text-white rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500'
                    ]"
                    placeholder="Adınızı girin">
                <p v-if="validationErrors.name" class="text-red-500 text-sm mt-1">@{{ validationErrors.name[0] }}</p>
            </div>

            {{-- Kanal Adı --}}
            <div class="mb-4">
                <label class="block text-gray-300 text-sm font-medium mb-1">Kanal Adınız</label>
                <input
                    v-model="form.channel_name"
                    type="text"
                    name="channel_name"
                    class="w-full px-4 py-2 bg-[#1f1f1f] border"
                    :class="[
                        validationErrors.channel_name ? 'border-red-500' : 'border-[#3f3f3f]',
                        'text-white rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500'
                    ]"
                    placeholder="Kanal adınızı girin">
                <p v-if="validationErrors.channel_name" class="text-red-500 text-sm mt-1">@{{ validationErrors.channel_name[0] }}</p>
            </div>

            {{-- Profil Resmi --}}
            <div class="mb-4">
                <label class="block text-gray-300 text-sm font-medium mb-1">Profil Resmi</label>
                <input
                    ref="profile_image"
                    type="file"
                    name="profile_image"
                    class="w-full px-4 py-2 bg-[#1f1f1f] border"
                    :class="[
                        validationErrors.profile_image ? 'border-red-500' : 'border-[#3f3f3f]',
                        'text-white rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#3f3f3f] file:text-white hover:file:bg-[#4f4f4f]'
                    ]"
                    @change="handleFileInput($event, 'profile_image')"
                    accept="image/*">
                <p v-if="validationErrors.profile_image" class="text-red-500 text-sm mt-1">@{{ validationErrors.profile_image[0] }}</p>
            </div>

            {{-- Kanal Resmi --}}
            <div class="mb-4">
                <label class="block text-gray-300 text-sm font-medium mb-1">Kanal Resmi</label>
                <input
                    ref="channel_image"
                    type="file"
                    name="channel_image"
                    class="w-full px-4 py-2 bg-[#1f1f1f] border"
                    :class="[
                        validationErrors.channel_image ? 'border-red-500' : 'border-[#3f3f3f]',
                        'text-white rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#3f3f3f] file:text-white hover:file:bg-[#4f4f4f]'
                    ]"
                    @change="handleFileInput($event, 'channel_image')"
                    accept="image/*">
                <p v-if="validationErrors.channel_image" class="text-red-500 text-sm mt-1">@{{ validationErrors.channel_image[0] }}</p>
            </div>

            {{-- Banner Resmi --}}
            <div class="mb-4">
                <label class="block text-gray-300 text-sm font-medium mb-1">Banner Resmi</label>
                <input
                    ref="banner"
                    type="file"
                    name="banner"
                    class="w-full px-4 py-2 bg-[#1f1f1f] border"
                    :class="[
                        validationErrors.banner ? 'border-red-500' : 'border-[#3f3f3f]',
                        'text-white rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#3f3f3f] file:text-white hover:file:bg-[#4f4f4f]'
                    ]"
                    @change="handleFileInput($event, 'banner')"
                    accept="image/*">
                <p v-if="validationErrors.banner" class="text-red-500 text-sm mt-1">@{{ validationErrors.banner[0] }}</p>
            </div>

            {{-- E-posta --}}
            <div class="mb-4">
                <label class="block text-gray-300 text-sm font-medium mb-1">E-posta</label>
                <input
                    v-model="form.email"
                    type="email"
                    name="email"
                    class="w-full px-4 py-2 bg-[#1f1f1f] border"
                    :class="[
                        validationErrors.email ? 'border-red-500' : 'border-[#3f3f3f]',
                        'text-white rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500'
                    ]"
                    placeholder="ornek@email.com">
                <p v-if="validationErrors.email" class="text-red-500 text-sm mt-1">@{{ validationErrors.email[0] }}</p>
            </div>

            {{-- Şifre --}}
            <div class="mb-4">
                <label class="block text-gray-300 text-sm font-medium mb-1">Şifre</label>
                <input
                    v-model="form.password"
                    type="password"
                    name="password"
                    class="w-full px-4 py-2 bg-[#1f1f1f] border"
                    :class="[
                        validationErrors.password ? 'border-red-500' : 'border-[#3f3f3f]',
                        'text-white rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500'
                    ]"
                    placeholder="Şifrenizi girin">
                <p v-if="validationErrors.password" class="text-red-500 text-sm mt-1">@{{ validationErrors.password[0] }}</p>
            </div>

            {{-- Şifre Tekrar --}}
            <div class="mb-4">
                <label class="block text-gray-300 text-sm font-medium mb-1">Şifre (Tekrar)</label>
                <input
                    v-model="form.password_confirmation"
                    type="password"
                    name="password_confirmation"
                    class="w-full px-4 py-2 bg-[#1f1f1f] border border-[#3f3f3f] text-white rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    placeholder="Şifrenizi tekrar girin">
            </div>

            {{-- Kullanım Koşulları --}}
            <div class="flex items-center mb-6">
                <input v-model="form.terms" type="checkbox" id="terms" class="w-4 h-4 text-blue-500 bg-[#1f1f1f] border-[#3f3f3f] rounded focus:ring-blue-500 focus:ring-offset-[#282828]">
                <label for="terms" class="ml-2 text-sm text-gray-300">Kullanım koşullarını kabul ediyorum.</label>
            </div>

            {{-- Gönder Butonu --}}
            <button type="submit" class="w-full bg-[#3ea6ff] text-black py-2.5 px-4 rounded-lg font-medium hover:bg-[#65b8ff] transition-colors duration-200">
                <span v-if="!loading">Kayıt Ol</span>
                <span v-else class="flex items-center justify-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-black" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Kaydediliyor...
                </span>
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-gray-400">
            Zaten bir hesabınız var mı?
            <a href="{{ route('login.page') }}" class="text-[#3ea6ff] hover:text-[#65b8ff] transition-colors duration-200">Giriş Yap</a>
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
                        name: '',
                        email: '',
                        password: '',
                        password_confirmation: '',
                        channel_name: '',
                        terms: false
                    },
                    validationErrors: {},
                    globalError: null
                }
            },
            methods: {
                handleFileInput(event, field) {
                    const file = event.target.files[0];
                    if (!file) return;

                    if (file.size > 10 * 1024 * 1024) {
                        this.setFieldError(field, 'Dosya boyutu 10MB\'dan küçük olmalıdır.');
                        event.target.value = '';
                        return;
                    }

                    if (!file.type.match('image.*')) {
                        this.setFieldError(field, 'Lütfen sadece resim dosyası yükleyin.');
                        event.target.value = '';
                        return;
                    }

                    this.clearFieldError(field);
                },

                setFieldError(field, message) {
                    this.validationErrors[field] = [message];
                },

                clearFieldError(field) {
                    delete this.validationErrors[field];
                },

                async registerUser() {
                    if (!this.form.terms) {
                        this.setFieldError('terms', 'Kullanım koşullarını kabul etmelisiniz.');
                        return;
                    }

                    this.loading = true;
                    this.validationErrors = {};
                    this.globalError = null;

                    try {
                        const formData = this.buildFormData();

                        const response = await axios.post('{{ route('register.submit') }}', formData, {
                            headers: { 'Content-Type': 'multipart/form-data' }
                        });

                        if (response.data.redirect) window.location.href = response.data.redirect;

                    } catch (error) {
                        this.handleError(error);
                    } finally {
                        this.loading = false;
                    }
                },

                buildFormData() {
                    const formData = new FormData();
                    for (const key in this.form) formData.append(key, this.form[key]);

                    ['profile_image', 'channel_image', 'banner'].forEach(field => {
                        const fileInput = this.$refs[field];
                        if (fileInput?.files[0]) formData.append(field, fileInput.files[0]);
                    });

                    return formData;
                },

                handleError(error) {
                    if (error.response) {
                        const data = error.response.data;
                        if (error.response.status === 422) {
                            this.validationErrors = data.errors || {};
                        } else if (data.message) {
                            this.globalError = data.message;
                        } else {
                            this.globalError = JSON.stringify(data);
                        }
                    } else {
                        this.globalError = 'Sunucuya bağlanırken bir hata oluştu.';
                    }
                }
            }

        }));
    </script>
@endpush
