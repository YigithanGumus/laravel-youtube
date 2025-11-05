@extends('layouts.app', [
    'title' => "Profil Sayfası",
])

@section('content')
    <div class="min-h-screen bg-gray-50 flex justify-center items-start py-10">
        <div class="w-full max-w-3xl bg-white shadow-lg rounded-xl p-8">
            <h1 class="text-2xl font-semibold mb-6 text-black text-center">Profil Bilgilerini Güncelle</h1>

            <form @submit.prevent="submitForm" class="space-y-6" enctype="multipart/form-data">
                {{-- Başarı / Hata Mesajı --}}
                <div v-if="message"
                     :class="messageType === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                     class="p-3 rounded mb-4 text-center font-medium">
                    @{{ message }}
                </div>

                {{-- Profil Resmi --}}
                <div class="flex flex-col items-center">
                    <label class="mb-2 text-gray-700 font-medium">Profil Resmi</label>
                    <div class="relative w-32 h-32">
                        <img :src="profilePreview" alt="Profil Resmi"
                             class="w-32 h-32 rounded-full object-cover border-2 border-gray-300 shadow-sm">
                        <input type="file" @change="onFileChange"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer rounded-full">
                    </div>
                    <p class="text-gray-400 text-sm mt-2">Yeni bir fotoğraf yüklemek için tıklayın</p>
                </div>

                {{-- Ad Soyad --}}
                <div>
                    <label for="name" class="block text-gray-700 font-medium mb-2">Ad Soyad</label>
                    <input type="text" v-model="form.name"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                    <input type="email" v-model="form.email"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                </div>

                {{-- Şifre --}}
                <div>
                    <label for="password" class="block text-gray-700 font-medium mb-2">Yeni Şifre</label>
                    <input type="password" v-model="form.password" placeholder="Yeni şifrenizi girin"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition">
                    <p class="text-gray-400 text-sm mt-1">Şifreyi değiştirmek istemiyorsanız boş bırakabilirsiniz.</p>
                </div>

                {{-- Güncelleme Butonu --}}
                <div class="flex justify-end">
                    <button type="submit" :disabled="loading"
                            class="bg-white text-black border border-black px-6 py-2 rounded-full font-medium hover:bg-black hover:text-white transition">
                        <span v-if="loading">Kaydediliyor...</span>
                        <span v-else>Bilgileri Güncelle</span>
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection

@push('footer')
    <script>
        vueMixinFunctions.push(() => ({
            data() {
                return {
                    loading: false,
                    profilePreview: '{{ $user->profile_image ? asset($user->profile_image) : asset('images/default-avatar.png') }}',
                    form: {
                        name: '{{ $user->name }}',
                        email: '{{ $user->email }}',
                        password: '',
                        profile_image: null,
                    },
                    errors: {},
                };
            },
            methods: {
                onFileChange(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.form.profile_image = file;
                        const reader = new FileReader();
                        reader.onload = e => this.profilePreview = e.target.result;
                        reader.readAsDataURL(file);
                    }
                },
                async submitForm() {
                    this.loading = true;
                    this.errors = {};

                    const formData = new FormData();
                    formData.append('name', this.form.name);
                    formData.append('email', this.form.email);
                    formData.append('password', this.form.password);
                    if(this.form.profile_image) {
                        formData.append('profile_image', this.form.profile_image);
                    }

                    try {
                        const res = await axios.post("{{ route('profile.update', $user->id) }}", formData, {
                            headers: { 'Content-Type': 'multipart/form-data' }
                        });
                       
                        this.form.password = '';
                    } catch (error) {
                        if (error.response && error.response.data.errors) {
                            this.errors = error.response.data.errors;
                        } else {
                            alert('Bir hata oluştu!');
                        }
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }));
    </script>
@endpush
