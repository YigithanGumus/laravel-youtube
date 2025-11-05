@extends('layouts.app', [
    "title" => "Video Yükle | LaravelTube"
])

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-medium text-gray-900">Video Yükle</h1>
            <button type="button" onclick="history.back()" class="text-blue-600 hover:text-blue-500 transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div id="upload-container" class="bg-white border border-gray-200 rounded-lg p-8 shadow-sm">
            <div
                x-data="uploadForm()"
                x-on:dragover.prevent="isDragging = true"
                x-on:dragleave.prevent="isDragging = false"
                x-on:drop.prevent="handleDrop($event)"
            >
                <!-- Yükleme Öncesi Görünüm -->
                <div x-show="!videoFile" class="text-center">
                    <div class="mb-6">
                        <div class="w-24 h-24 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center border border-gray-300">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                        </div>
                        <h2 class="text-lg font-medium text-gray-800 mb-2">Videolarını yüklemek için buraya sürükle ve bırak</h2>
                        <p class="text-gray-500 text-sm mb-4">Dosyalarınız gizli kalacak</p>

                        <label class="inline-block">
                            <input type="file" name="video" accept="video/*" class="hidden" x-on:change="handleFileSelect($event)">
                            <span class="bg-blue-600 text-white px-6 py-2.5 rounded-lg font-medium cursor-pointer hover:bg-blue-500 transition-colors duration-200">
                            Dosya Seç
                        </span>
                        </label>
                        <p x-show="errors.video" x-text="errors.video" class="text-red-500 text-sm mt-1"></p>
                    </div>
                </div>

                <!-- Video Detayları Formu -->
                <form x-show="videoFile" x-on:submit="uploadVideo($event)" class="space-y-6">
                    <input type="file" name="video" class="hidden" x-ref="videoInput">

                    <div class="grid grid-cols-12 gap-6">
                        <!-- Sol Taraf - Video Önizleme -->
                        <div class="col-span-7">
                            <div class="aspect-video bg-gray-100 rounded-lg overflow-hidden border border-gray-200">
                                <video x-ref="videoPreview" class="w-full h-full" controls></video>
                            </div>

                            <!-- Progress Bar -->
                            <div x-show="isUploading" class="mt-4">
                                <div class="w-full bg-gray-200 h-2.5 rounded-full">
                                    <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-300" x-bind:style="'width:' + progress + '%'"></div>
                                </div>
                                <p class="text-gray-700 text-sm mt-1" x-text="'Yükleniyor... ' + progress + '%'"></p>
                            </div>
                        </div>

                        <!-- Sağ Taraf - Form Alanları -->
                        <div class="col-span-5 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Başlık (zorunlu)</label>
                                <input type="text" name="title" x-model="title"
                                       class="w-full px-4 py-2 bg-white border border-gray-300 text-gray-900 rounded-lg focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
                                       placeholder="Videonuzu açıklayan bir başlık ekleyin" required>
                                <p x-show="errors.title" x-text="errors.title" class="text-red-500 text-sm mt-1"></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Açıklama</label>
                                <textarea name="description" x-model="description" rows="4"
                                          class="w-full px-4 py-2 bg-white border border-gray-300 text-gray-900 rounded-lg focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
                                          placeholder="İzleyicileriniz için video içeriğini açıklayın"></textarea>
                                <p x-show="errors.description" x-text="errors.description" class="text-red-500 text-sm mt-1"></p>
                            </div>

                            <!-- Gizlilik Seçenekleri -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Gizlilik</label>
                                <select x-model="visibility"
                                        class="w-full px-4 py-2 bg-white border border-gray-300 text-gray-900 rounded-lg focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                                    <option value="public">Herkese Açık</option>
                                    <option value="private">Özel</option>
                                    <option value="unlisted">Gizli</option>
                                </select>
                                <p x-show="errors.visibility" x-text="errors.visibility" class="text-red-500 text-sm mt-1"></p>
                            </div>

                            <!-- Thumbnail -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Küçük Resim</label>
                                <div
                                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg bg-gray-50"
                                    x-on:dragover.prevent
                                    x-on:drop.prevent="(event) => { const file = event.dataTransfer.files[0]; if(file) handleThumbnailFile(file) }"
                                >
                                    <div class="space-y-1 text-center">
                                        <!-- Önizleme -->
                                        <template x-if="thumbnailPreview">
                                            <img :src="thumbnailPreview" class="mx-auto rounded-lg max-h-40">
                                        </template>

                                        <div class="flex text-sm text-gray-500 justify-center items-center gap-1">
                                            <label class="relative cursor-pointer rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                                <span>Resim Yükle</span>
                                                <input type="file" name="thumbnail_image" class="sr-only" accept="image/*"
                                                       x-ref="thumbnailInput"
                                                       x-on:change="handleThumbnailFile($event.target.files[0])">
                                            </label>
                                            <span>veya sürükle ve bırak</span>
                                        </div>
                                        <p class="text-xs text-gray-400">PNG, JPG, GIF (max. 2MB)</p>
                                        <p x-show="errors.thumbnail_image" x-text="errors.thumbnail_image" class="text-red-500 text-sm mt-1"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-between items-center pt-4">
                                <button type="button" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200"
                                        x-on:click="clearFile()">İptal</button>
                                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-500 transition-colors duration-200"
                                        x-bind:disabled="!title || isUploading">Yükle</button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Başarılı Mesaj -->
                <div x-show="successMessage"
                     x-transition.opacity.duration.400ms
                     class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-60 z-50">
                    <div class="bg-white rounded-2xl p-8 max-w-sm w-full text-center shadow-2xl border border-gray-200">
                        <div x-html="successMessage"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('footer')
        <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('uploadForm', () => ({
                    videoFile: null,
                    title: '',
                    description: '',
                    thumbnail_image: null,
                    thumbnailPreview: null,
                    visibility: 'public',
                    progress: 0,
                    isUploading: false,
                    errors: {},
                    successMessage: '',

                    handleDrop(event) {
                        this.isDragging = false;
                        const file = event.dataTransfer.files[0];
                        if(file && file.type.startsWith('video/')) this.handleFile(file);
                    },

                    handleThumbnailFile(file) {
                        if(!file) return;
                        this.thumbnail_image = file;
                        this.thumbnailPreview = URL.createObjectURL(file);
                    },

                    handleFileSelect(event) {
                        const file = event.target.files[0];
                        if(file) this.handleFile(file);
                    },

                    handleFile(file) {
                        this.videoFile = file;
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        this.$refs.videoInput.files = dataTransfer.files;
                        this.$refs.videoPreview.src = URL.createObjectURL(file);
                        this.title = file.name.replace(/\.[^/.]+$/, "");
                    },

                    clearFile() {
                        this.videoFile = null;
                        this.title = '';
                        this.description = '';
                        this.$refs.videoInput.value = '';
                        this.$refs.videoPreview.src = '';
                        this.thumbnail_image = null;
                        this.thumbnailPreview = null;
                        this.progress = 0;
                        this.isUploading = false;
                        this.visibility = 'public';
                        this.errors = {};
                        this.successMessage = '';
                    },

                    uploadVideo(event) {
                        event.preventDefault();
                        if (!this.videoFile) return;
                        this.errors = {};
                        this.successMessage = '';

                        const formData = new FormData();
                        formData.append('video', this.videoFile);
                        formData.append('title', this.title);
                        formData.append('description', this.description);
                        formData.append('visibility', this.visibility);
                        if (this.thumbnail_image) formData.append('thumbnail_image', this.thumbnail_image);
                        formData.append('_token', '{{ csrf_token() }}');

                        this.isUploading = true;
                        this.progress = 0;

                        axios.post('{{ route("videos.store", Auth::user()->channel->uid) }}', formData, {
                            headers: { 'Content-Type': 'multipart/form-data' },
                            onUploadProgress: (progressEvent) => {
                                this.progress = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                            }
                        }).then(response => {
                            this.isUploading = false;
                            if (response.status === 201 && response.data.success) {
                                this.successMessage = `
                        <div class="flex flex-col items-center text-center space-y-2">
                            <svg class="w-14 h-14 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12l2 2l4-4m6 2a9 9 0 11-18 0a9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-lg text-green-600 font-semibold">Video başarıyla yüklendi!</p>
                            <p class="text-gray-500 text-sm animate-pulse">Yönlendiriliyorsunuz...</p>
                        </div>
                    `;
                                setTimeout(() => window.location.href = response.data.redirect, 2500);
                            } else {
                                this.successMessage = '<p class="text-red-500">Beklenmeyen bir yanıt alındı.</p>';
                            }
                            this.clearFile();
                        }).catch(error => {
                            this.isUploading = false;
                            if (error.response?.data?.errors) {
                                Object.keys(error.response.data.errors).forEach(key => {
                                    this.errors[key] = error.response.data.errors[key][0];
                                });
                            } else {
                                alert('Yükleme sırasında bir hata oluştu.');
                            }
                        });
                    }
                }));
            });
        </script>
    @endpush
@endsection
