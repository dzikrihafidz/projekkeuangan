<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    // 📊 Halaman Index (daftar transaksi per user)
    public function index()
    {
        $transaksis = Transaksi::with('kategori')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $saldo = Transaksi::where('user_id', Auth::id())
            ->selectRaw("SUM(CASE WHEN jenis='pemasukan' THEN jumlah ELSE -jumlah END) as saldo")
            ->value('saldo');

        return view('transaksi.index', compact('transaksis', 'saldo'));
    }

    // 📈 Dashboard ringkasan transaksi per user
public function dashboard()
{
    $transaksis = Transaksi::with('kategori')
        ->where('user_id', Auth::id())
        ->latest()
        ->get();

    $saldo = $transaksis->reduce(function ($carry, $item) {
        return $item->jenis === 'pemasukan'
            ? $carry + $item->jumlah
            : $carry - $item->jumlah;
    }, 0);

    // ✅ data untuk grafik alokasi
    $labels = $transaksis->groupBy(fn($t) => $t->kategori->nama_kategori ?? 'Lainnya')->keys();
    $totals = $transaksis->groupBy(fn($t) => $t->kategori->nama_kategori ?? 'Lainnya')
        ->map(fn($g) => $g->sum('jumlah'))->values();

    return view('dashboard.index', compact('transaksis', 'saldo', 'labels', 'totals'));
}


    // ➕ Form tambah transaksi
    public function create()
    {
        // Hanya tampilkan kategori milik user yang login
        $kategoris = Kategori::where('user_id', Auth::id())->get();
        return view('transaksi.create', compact('kategoris'));
    }

    // 💾 Simpan transaksi baru
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
        ]);

        Transaksi::create([
            'user_id' => Auth::id(),
            'kategori_id' => $request->kategori_id,
            'jenis' => $request->jenis,
            'jumlah' => $request->jumlah,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    // ✏️ Edit transaksi
    public function edit($id)
    {
        $transaksi = Transaksi::where('user_id', Auth::id())->findOrFail($id);
        $kategoris = Kategori::where('user_id', Auth::id())->get();

        return view('transaksi.edit', compact('transaksi', 'kategoris'));
    }

    // 🔄 Update transaksi
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'jumlah' => 'required|numeric|min:1',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable|string',
        ]);

        $transaksi = Transaksi::where('user_id', Auth::id())->findOrFail($id);
        $transaksi->update($validated);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    // ❌ Hapus transaksi
    public function destroy($id)
    {
        $transaksi = Transaksi::where('user_id', Auth::id())->findOrFail($id);
        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus!');
    }

    // 🧾 Cetak laporan PDF per user
    public function cetakLaporan()
    {
        $bulan = Carbon::now()->format('F Y');

        $transaksis = Transaksi::with('kategori')
            ->where('user_id', Auth::id())
            ->whereMonth('tanggal', Carbon::now()->month)
            ->get();

        $saldo = $transaksis->reduce(function ($carry, $item) {
            return $carry + ($item->jenis === 'pemasukan' ? $item->jumlah : -$item->jumlah);
        }, 0);

        $labels = $transaksis->groupBy('kategori.nama_kategori')->keys();
        $totals = $transaksis->groupBy('kategori.nama_kategori')->map(fn($g) => $g->sum('jumlah'))->values();

        $pdf = Pdf::loadView('laporan.bulanan', compact('bulan', 'transaksis', 'saldo', 'labels', 'totals'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('laporan-keuangan-' . strtolower(str_replace(' ', '-', $bulan)) . '.pdf');
    }
}
