@extends('layouts.app')

@section('content')
<div class="flex flex-col gap-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">🏷️ Daftar Kategori</h2>
    </div>

    <!-- Form Tambah Kategori -->
    <form action="{{ route('kategori.store') }}" method="POST"
          class="flex flex-col sm:flex-row gap-3 bg-white dark:bg-gray-800 p-5 rounded-2xl shadow border border-gray-200 dark:border-gray-700">
        @csrf
        <input type="text" name="nama_kategori" placeholder="Nama kategori..."
               class="w-full sm:flex-1 p-3 rounded-xl border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 
                      focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all"
               required>
        <button class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-xl shadow-sm transition-all">
            + Tambah
        </button>
    </form>

    <!-- Table Wrapper -->
    <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-2xl border border-gray-200 dark:border-gray-700">
        <table class="min-w-full text-sm text-left border-collapse">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                <tr>
                    <th class="py-4 px-6 font-semibold">Nama Kategori</th>
                    <th class="py-4 px-6 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($kategoris as $k)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-900 transition-all">
                        <td class="py-4 px-6 whitespace-nowrap text-gray-800 dark:text-gray-100">{{ $k->nama_kategori }}</td>
                        <td class="py-4 px-6 text-center flex justify-center gap-3">
                            <a href="{{ route('kategori.edit', $k->id) }}"
                               class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-medium px-4 py-1.5 rounded-lg transition-all shadow-sm">
                                Edit
                            </a>
                            <form action="{{ route('kategori.destroy', $k->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus kategori ini?')" class="inline">
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
                        <td colspan="2" class="text-center py-6 text-gray-500 dark:text-gray-400">
                            Belum ada kategori yang ditambahkan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
