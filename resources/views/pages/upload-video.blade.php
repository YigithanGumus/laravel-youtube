@extends('layouts.app', [
    "title" => "Video Yükle | LaravelTube"
])

@section('content')
    <div class="max-w-5xl mx-auto mt-6 p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-medium text-white">Video Yükle</h1>
            <button type="button" onclick="history.back()" class="text-[#3ea6ff] hover:text-[#65b8ff] transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div id="upload-container" class="bg-[#282828] rounded-lg p-8">
            <div
                x-data="uploadForm()"
                x-on:dragover.prevent="isDragging = true"
                x-on:dragleave.prevent="isDragging = false"
                x-on:drop.prevent="handleDrop($event)"
            >
                <!-- Yükleme Öncesi Görünüm -->
                <div x-show="!videoFile" class="text-center">
                    <div class="mb-6">
                        <div class="w-24 h-24 mx-auto mb-4 rounded-full bg-[#3f3f3f] flex items-center justify-center">
                            <svg class="w-12 h-12 text-[#aaa]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                        </div>
                        <h2 class="text-lg font-medium text-white mb-2">Videolarını yüklemek için buraya sürükle ve bırak</h2>
                        <p class="text-[#aaa] text-sm mb-4">Dosyalarınız gizli kalacak</p>

                        <label class="inline-block">
                            <input
                                type="file"
                                name="video"
                                accept="video/*"
                                class="hidden"
                                x-on:change="handleFileSelect($event)"
                            >
                            <span class="bg-[#3ea6ff] text-black px-6 py-2.5 rounded-lg font-medium cursor-pointer hover:bg-[#65b8ff] transition-colors duration-200">
                            Dosya Seç
                        </span>
                        </label>
                    </div>
                </div>

                <!-- Video Detayları Formu -->
                <form x-show="videoFile"
                      x-on:submit="uploadVideo($event)"
                      class="space-y-6">
                    <input type="file" name="video" class="hidden" x-ref="videoInput">

                    <div class="grid grid-cols-12 gap-6">
                        <!-- Sol Taraf - Video Önizleme -->
                        <div class="col-span-7">
                            <div class="aspect-video bg-[#1f1f1f] rounded-lg overflow-hidden">
                                <video x-ref="videoPreview" class="w-full h-full" controls></video>
                            </div>

                            <!-- Progress Bar -->
                            <div x-show="isUploading" class="mt-4">
                                <div class="w-full bg-[#3f3f3f] h-2.5 rounded-full">
                                    <div class="bg-[#3ea6ff] h-2.5 rounded-full transition-all duration-300" x-bind:style="'width:' + progress + '%'"></div>
                                </div>
                                <p class="text-white text-sm mt-1" x-text="'Yükleniyor... ' + progress + '%'"></p>
                            </div>
                        </div>

                        <!-- Sağ Taraf - Form Alanları -->
                        <div class="col-span-5 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">Başlık (zorunlu)</label>
                                <input
                                    type="text"
                                    name="title"
                                    x-model="title"
                                    class="w-full px-4 py-2 bg-[#1f1f1f] border border-[#3f3f3f] text-white rounded-lg focus:outline-none focus:border-[#3ea6ff] focus:ring-1 focus:ring-[#3ea6ff]"
                                    placeholder="Videonuzu açıklayan bir başlık ekleyin"
                                    required
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">Açıklama</label>
                                <textarea
                                    name="description"
                                    x-model="description"
                                    rows="4"
                                    class="w-full px-4 py-2 bg-[#1f1f1f] border border-[#3f3f3f] text-white rounded-lg focus:outline-none focus:border-[#3ea6ff] focus:ring-1 focus:ring-[#3ea6ff]"
                                    placeholder="İzleyicileriniz için video içeriğini açıklayın"
                                ></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">Küçük Resim</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-[#3f3f3f] border-dashed rounded-lg">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-400">
                                            <label class="relative cursor-pointer bg-[#1f1f1f] rounded-md font-medium text-[#3ea6ff] hover:text-[#65b8ff] focus-within:outline-none">
                                                <span>Resim Yükle</span>
                                                <input type="file" name="thumbnail_image" class="sr-only" accept="image/*" x-ref="thumbnailInput">
                                            </label>
                                            <p class="pl-1 text-gray-400">veya sürükle ve bırak</p>
                                        </div>
                                        <p class="text-xs text-gray-400">
                                            PNG, JPG, GIF (max. 2MB)
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-between items-center pt-4">
                                <button type="button"
                                        class="px-6 py-2 border border-[#3f3f3f] text-white rounded-lg hover:bg-[#3f3f3f] transition-colors duration-200"
                                        x-on:click="clearFile()">
                                    İptal
                                </button>
                                <button type="submit"
                                        class="px-6 py-2 bg-[#3ea6ff] text-black rounded-lg font-medium hover:bg-[#65b8ff] transition-colors duration-200"
                                        x-bind:disabled="!title || isUploading">
                                    Yükle
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('footer')
        <!-- Alpine.js ve Axios CDN -->
        <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('uploadForm', () => ({
                    videoFile: null,
                    title: '',
                    description: '',
                    thumbnail: null,
                    progress: 0,
                    isUploading: false,

                    handleDrop(event) {
                        this.isDragging = false;
                        const file = event.dataTransfer.files[0];
                        if(file && file.type.startsWith('video/')) {
                            this.handleFile(file);
                        }
                    },

                    handleFileSelect(event) {
                        const file = event.target.files[0];
                        if(file) {
                            this.handleFile(file);
                        }
                    },

                    handleFile(file) {
                        this.videoFile = file;

                        // file input
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        this.$refs.videoInput.files = dataTransfer.files;

                        // video preview
                        this.$refs.videoPreview.src = URL.createObjectURL(file);

                        // otomatik başlık
                        this.title = file.name.replace(/\.[^/.]+$/, "");
                    },

                    clearFile() {
                        this.videoFile = null;
                        this.title = '';
                        this.description = '';
                        this.$refs.videoInput.value = '';
                        this.$refs.videoPreview.src = '';
                        this.progress = 0;
                        this.isUploading = false;
                    },

                    uploadVideo(event) {
                        event.preventDefault();
                        if(!this.videoFile) return;

                        const formData = new FormData();
                        formData.append('video', this.videoFile);
                        formData.append('title', this.title);
                        formData.append('description', this.description);
                        if(this.$refs.thumbnailInput && this.$refs.thumbnailInput.files[0]){
                            formData.append('thumbnail', this.$refs.thumbnailInput.files[0]);
                        }
                        formData.append('_token', '{{ csrf_token() }}');

                        this.isUploading = true;
                        this.progress = 0;

                        axios.post('{{ route("videos.store", Auth::user()->channel->uid) }}', formData, {
                            headers: { 'Content-Type': 'multipart/form-data' },
                            onUploadProgress: (progressEvent) => {
                                this.progress = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                            }
                        }).then(response => {
                            alert('Yükleme tamamlandı!');
                            this.clearFile();
                        }).catch(error => {
                            console.error(error);
                            alert('Yükleme sırasında bir hata oluştu.');
                            this.isUploading = false;
                        });
                    }
                }));
            });
        </script>
    @endpush
@endsection
