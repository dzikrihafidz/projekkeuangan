@extends('layouts.app')

@section('content')
<div class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-6 max-w-xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-center">📝 Tambah Transaksi</h2>

    <form action="{{ route('transaksi.store') }}" method="POST" class="space-y-4">
        @csrf

        {{-- Kategori --}}
        <div>
            <label class="font-semibold block mb-1">Kategori</label>
            <select name="kategori_id" class="w-full p-2 rounded border dark:bg-gray-900" required>
                <option value="">-- Pilih Kategori --</option>
                @forelse ($kategoris as $k)
                    <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                @empty
                    <option disabled>Belum ada kategori</option>
                @endforelse
            </select>
            @error('kategori_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Jenis --}}
        <div>
            <label class="font-semibold block mb-1">Jenis</label>
            <select name="jenis" class="w-full p-2 rounded border dark:bg-gray-900" required>
                <option value="">-- Pilih Jenis --</option>
                <option value="pemasukan">Pemasukan</option>
                <option value="pengeluaran">Pengeluaran</option>
            </select>
            @error('jenis') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Jumlah --}}
        <div>
            <label class="font-semibold block mb-1">Jumlah</label>
            <input type="number" name="jumlah" value="{{ old('jumlah') }}" class="w-full p-2 rounded border dark:bg-gray-900" required>
            @error('jumlah') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Tanggal --}}
        <div>
            <label class="font-semibold block mb-1">Tanggal</label>
            <input type="date" name="tanggal" value="{{ old('tanggal') }}" class="w-full p-2 rounded border dark:bg-gray-900" required>
            @error('tanggal') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Deskripsi --}}
        <div>
            <label class="font-semibold block mb-1">Deskripsi</label>
            <textarea name="deskripsi" class="w-full p-2 rounded border dark:bg-gray-900">{{ old('deskripsi') }}</textarea>
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
