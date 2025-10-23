@extends('layouts.app', [
    'title' => 'Video Düzenle | LaravelTube'
])

@section('content')

    <div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md mt-10">
        <h1 class="text-2xl font-bold mb-6">Video Düzenle</h1>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('video.edit', ['channel' => $channel, 'video' => $video]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Video Başlığı --}}
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Başlık</label>
                <input type="text" name="title" id="title" value="{{ old('title', $video->title) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-indigo-200 focus:border-indigo-500 @error('title') border-red-500 @enderror">
                @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Video Açıklaması --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Açıklama</label>
                <textarea name="description" id="description" rows="4"
                          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-indigo-200 focus:border-indigo-500 @error('description') border-red-500 @enderror">{{ old('description', $video->description) }}</textarea>
                @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Görünürlük --}}
            <div>
                <label for="visibility" class="block text-sm font-medium text-gray-700 mb-1">Görünürlük</label>
                <select name="visibility" id="visibility"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-indigo-200 focus:border-indigo-500 @error('visibility') border-red-500 @enderror">
                    <option value="public" {{ old('visibility', $video->visibility) == 'public' ? 'selected' : '' }}>Herkese Açık</option>
                    <option value="private" {{ old('visibility', $video->visibility) == 'private' ? 'selected' : '' }}>Özel</option>
                    <option value="unlisted" {{ old('visibility', $video->visibility) == 'unlisted' ? 'selected' : '' }}>Liste Dışı</option>
                </select>
                @error('visibility')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <div class="flex justify-end">
                <button type="submit"
                        class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
                    Kaydet
                </button>
            </div>
        </form>
    </div>
@endsection
