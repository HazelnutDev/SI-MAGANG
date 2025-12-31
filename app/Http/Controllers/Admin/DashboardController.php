<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Absensi;
use App\Models\TugasKegiatanHarian;
use App\Models\TugasMahasiswa;
use App\Models\LaporanAkhir;
use App\Models\Sertifikat;
use App\Models\IndeksNilai;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik untuk dashboard admin
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();
        $totalAbsensi = Absensi::count();
        $totalTugas = TugasKegiatanHarian::count();
        $totalLaporan = LaporanAkhir::count();
        $totalSertifikat = Sertifikat::count();
        
        // Absensi hari ini
        $absensiHariIni = Absensi::whereDate('tanggal', today())->count();
        
        // Tugas aktif
        $tugasAktif = TugasKegiatanHarian::where('status', 'active')->count();
        
        // Laporan pending
        $laporanPending = LaporanAkhir::where('status', 'pending')->count();
        
        // Data untuk chart/grafik
        $absensiPerBulan = Absensi::selectRaw('MONTH(tanggal) as bulan, COUNT(*) as total')
            ->whereYear('tanggal', date('Y'))
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();
            
        // Mahasiswa terbaru
        $mahasiswaTerbaru = User::where('role', 'mahasiswa')
            ->latest()
            ->take(5)
            ->get();
            
        // Tugas terbaru
        $tugasTerbaru = TugasKegiatanHarian::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalMahasiswa',
            'totalAbsensi', 
            'totalTugas',
            'totalLaporan',
            'totalSertifikat',
            'absensiHariIni',
            'tugasAktif',
            'laporanPending',
            'absensiPerBulan',
            'mahasiswaTerbaru',
            'tugasTerbaru'
        ));
    }
}