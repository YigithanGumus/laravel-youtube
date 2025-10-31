@extends('layouts.app', [
    'title' => '404 | Sayfa Bulunamadı'
])

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="flex flex-col items-center justify-center min-h-[70vh] text-center text-white">
        <h2 class="text-2xl font-semibold mb-2">Sayfa Bulunamadı</h2>
        <p class="text-gray-400 mb-6 max-w-md">
            Aradığınız sayfa mevcut değil ya da taşınmış olabilir. Lütfen adresi kontrol edin veya ana sayfaya dönün.
        </p>

        <a href="{{ url('/') }}"
           class="inline-block bg-blue-600 hover:bg-blue-700 transition-colors px-6 py-3 rounded-lg font-medium">
            Ana Sayfaya Dön
        </a>
        </div>
    </div>
@endsection
