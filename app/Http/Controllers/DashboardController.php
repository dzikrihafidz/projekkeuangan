<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil total pengeluaran per kategori
        $kategoriData = Transaksi::select('kategori_id', DB::raw('SUM(jumlah) as total'))
            ->where('jenis', 'pengeluaran')
            ->groupBy('kategori_id')
            ->with('kategori')
            ->get();

        // Buat label dan total untuk chart
        $labels = $kategoriData->pluck('kategori.nama_kategori');
        $totals = $kategoriData->pluck('total');

        // Total saldo (pemasukan - pengeluaran)
        $totalPemasukan = Transaksi::where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = Transaksi::where('jenis', 'pengeluaran')->sum('jumlah');
        $saldo = $totalPemasukan - $totalPengeluaran;

        return view('dashboard', compact('labels', 'totals', 'saldo'));
    }
}
