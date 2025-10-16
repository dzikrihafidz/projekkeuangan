@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto flex flex-col gap-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">✏️ Edit Kategori</h2>
        <a href="{{ route('kategori.index') }}"
           class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition">
            ← Kembali ke Daftar
        </a>
    </div>

    <!-- Card Form -->
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow p-6">
        <form action="{{ route('kategori.update', $kategori->id) }}" method="POST" class="flex flex-col gap-5">
            @csrf
            @method('PUT')

            <!-- Input -->
            <div>
                <label for="nama_kategori" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Nama Kategori
                </label>
                <input id="nama_kategori" type="text" name="nama_kategori" value="{{ $kategori->nama_kategori }}"
                       class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-600 
                              dark:bg-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                       placeholder="Masukkan nama kategori baru..." required>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('kategori.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 
                          dark:text-gray-200 px-5 py-2.5 rounded-lg transition-all shadow-sm">
                    Batal
                </a>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg transition-all shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
