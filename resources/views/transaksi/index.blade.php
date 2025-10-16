@extends('layouts.app')

@section('content')
<div class="flex flex-col gap-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">📜 Data Transaksi</h2>
        <a href="{{ route('transaksi.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-center w-full sm:w-auto transition-all duration-200 shadow">
            + Tambah Transaksi
        </a>
    </div>

    <!-- Table Wrapper -->
    <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-md rounded-xl border border-gray-200 dark:border-gray-700">
        <table class="min-w-full text-sm text-left border-collapse">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                <tr>
                    <th class="py-3 px-4 font-semibold">Tanggal</th>
                    <th class="py-3 px-4 font-semibold">Kategori</th>
                    <th class="py-3 px-4 font-semibold">Jenis</th>
                    <th class="py-3 px-4 font-semibold">Jumlah</th>
                    <th class="py-3 px-4 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($transaksis as $t)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-900 transition-all">
                        <td class="py-3 px-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($t->tanggal)->format('d M Y') }}</td>
                        <td class="py-3 px-4 whitespace-nowrap">{{ $t->kategori->nama_kategori ?? '-' }}</td>
                        <td class="py-3 px-4">
                            <span class="px-3 py-1 text-xs rounded-full 
                                {{ $t->jenis === 'pemasukan' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ ucfirst($t->jenis) }}
                            </span>
                        </td>
                        <td class="py-3 px-4 whitespace-nowrap font-semibold text-gray-900 dark:text-gray-100">
                            Rp {{ number_format($t->jumlah, 0, ',', '.') }}
                        </td>
                       <td class="py-3 px-4 text-center flex justify-center gap-3">
    <a href="{{ route('transaksi.edit', $t->id) }}"
       class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-medium px-4 py-1.5 rounded-lg transition-all shadow-sm">
        Edit
    </a>
    <form action="{{ route('transaksi.destroy', $t->id) }}" method="POST"
          onsubmit="return confirm('Hapus transaksi ini?')" class="inline">
        @csrf
        @method('DELETE')
        <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-1.5 rounded-lg transition-all shadow-sm">
            Hapus
        </button>
    </form>
</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500 dark:text-gray-400">
                            Belum ada transaksi yang ditambahkan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Total Saldo -->
    @if(isset($saldo))
        <div class="bg-gray-100 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-lg p-4 text-right shadow-sm">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Saldo Saat Ini:</h3>
            <p class="text-2xl font-bold 
                {{ $saldo >= 0 ? 'text-green-600' : 'text-red-600' }}">
                Rp {{ number_format($saldo, 0, ',', '.') }}
            </p>
        </div>
    @endif
</div>
@endsection
