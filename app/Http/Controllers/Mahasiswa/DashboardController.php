<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\TugasKegiatanHarian;
use App\Models\TugasMahasiswa;
use App\Models\LaporanAkhir;
use App\Models\Sertifikat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Statistik
        $totalAbsensi = Absensi::where('user_id', $user->id)->count();
        $absensiHadir = Absensi::where('user_id', $user->id)
            ->where('status', 'hadir')->count();

        $totalTugas = TugasMahasiswa::where('user_id', $user->id)->count();
        $tugasSelesai = TugasMahasiswa::where('user_id', $user->id)
            ->where('status_pengerjaan', 'selesai')->count();

        // Tugas terbaru yang diassign ke mahasiswa
        $tugasTerbaru = TugasMahasiswa::where('user_id', $user->id)
            ->with('tugas')
            ->latest()
            ->take(5)
            ->get();

        // Absensi bulan ini
        $absensiTerbaru = Absensi::where('user_id', $user->id)
            ->whereMonth('tanggal', date('m'))
            ->whereYear('tanggal', date('Y'))
            ->latest()
            ->take(5)
            ->get();

        // Check absensi status for today
        $absensiHariIni = Absensi::where('user_id', $user->id)
            ->whereDate('tanggal', today())
            ->first();

        // Check if can still absen
        $currentTime = now()->format('H:i');
        $minAbsenMasuk = '06:00';
        $maxAbsenMasuk = '08:10';
        $maxAbsenKeluar = '17:00';
        
        $canAbsenMasuk = !$absensiHariIni && $currentTime >= $minAbsenMasuk && $currentTime <= $maxAbsenMasuk;
        $canAbsenKeluar = $absensiHariIni && !$absensiHariIni->jam_keluar && $currentTime <= $maxAbsenKeluar;

        return view('mahasiswa.dashboard', compact(
            'totalAbsensi',
            'absensiHadir',
            'totalTugas',
            'tugasSelesai',
            'tugasTerbaru',
            'absensiTerbaru',
            'absensiHariIni',
            'canAbsenMasuk',
            'canAbsenKeluar'
        ));
    }
}
