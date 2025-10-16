@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto flex flex-col gap-6">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">✏️ Edit Transaksi</h2>

    <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST"
          class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 border border-gray-200 dark:border-gray-700 space-y-5">
        @csrf
        @method('PUT')

        <!-- Dropdown Kategori -->
        <label class="block">
            <span class="font-semibold text-gray-700 dark:text-gray-200">Kategori</span>
            <select name="kategori_id" class="w-full p-3 rounded-lg border dark:bg-gray-900" required>
                @foreach ($kategoris as $k)
                    <option value="{{ $k->id }}" {{ $transaksi->kategori_id == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </label>

        <!-- Jenis -->
        <label class="block">
            <span class="font-semibold text-gray-700 dark:text-gray-200">Jenis</span>
            <select name="jenis" class="w-full p-3 rounded-lg border dark:bg-gray-900" required>
                <option value="pemasukan" {{ $transaksi->jenis == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                <option value="pengeluaran" {{ $transaksi->jenis == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
            </select>
        </label>

        <!-- Jumlah -->
        <label class="block">
            <span class="font-semibold text-gray-700 dark:text-gray-200">Jumlah</span>
            <input type="number" name="jumlah" value="{{ $transaksi->jumlah }}"
                   class="w-full p-3 rounded-lg border dark:bg-gray-900" required>
        </label>

        <!-- Tanggal -->
        <label class="block">
            <span class="font-semibold text-gray-700 dark:text-gray-200">Tanggal</span>
            <input type="date" name="tanggal" value="{{ $transaksi->tanggal }}"
                   class="w-full p-3 rounded-lg border dark:bg-gray-900" required>
        </label>

        <!-- Deskripsi -->
        <label class="block">
            <span class="font-semibold text-gray-700 dark:text-gray-200">Deskripsi</span>
            <textarea name="deskripsi" class="w-full p-3 rounded-lg border dark:bg-gray-900"
                      placeholder="Opsional...">{{ $transaksi->deskripsi }}</textarea>
        </label>

        <!-- Tombol -->
        <div class="flex justify-between items-center">
            <a href="{{ route('transaksi.index') }}"
               class="text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-100 transition">
                ← Kembali
            </a>

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg transition-all">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
