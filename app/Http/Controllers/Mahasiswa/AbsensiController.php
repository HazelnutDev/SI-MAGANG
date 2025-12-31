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

class AbsensiController extends Controller
{
    public function index()
    {
        $absensi = Absensi::where('user_id', Auth::id())
            ->orderBy('tanggal', 'desc')
            ->paginate(20);

        // Check absensi status for today
        $absensiHariIni = Absensi::where('user_id', Auth::id())
            ->whereDate('tanggal', today())
            ->first();

        // Check if can still absen
        $currentTime = now()->format('H:i');
        $minAbsenMasuk = '06:00';
        $maxAbsenMasuk = '08:10';
        $maxAbsenKeluar = '17:00';
        
        $canAbsenMasuk = !$absensiHariIni && $currentTime >= $minAbsenMasuk && $currentTime <= $maxAbsenMasuk;
        $canAbsenKeluar = $absensiHariIni && !$absensiHariIni->jam_keluar && $currentTime <= $maxAbsenKeluar;

        return view('mahasiswa.absensi.index', compact('absensi', 'absensiHariIni', 'canAbsenMasuk', 'canAbsenKeluar'));
    }

    public function create()
    {
        // Check if already absent today
        $today = Absensi::where('user_id', Auth::id())
            ->whereDate('tanggal', today())
            ->first();

        if ($today && $today->jam_keluar) {
            return redirect()->route('mahasiswa.absensi.index')
                ->with('error', 'Anda sudah absen hari ini.');
        }

        // Check absensi time limits
        $currentTime = now()->format('H:i');
        $minAbsenMasuk = '06:00';
        $maxAbsenMasuk = '08:10';
        $maxAbsenKeluar = '17:00';
        
        if (!$today && ($currentTime < $minAbsenMasuk || $currentTime > $maxAbsenMasuk)) {
            return redirect()->route('mahasiswa.absensi.index')
                ->with('error', 'Waktu absensi masuk adalah 06:00 - 08:10 WITA. Saat ini pukul ' . $currentTime . ' WITA.');
        }
        
        if ($today && !$today->jam_keluar && $currentTime > $maxAbsenKeluar) {
            return redirect()->route('mahasiswa.absensi.index')
                ->with('error', 'Waktu absensi keluar sudah berakhir. Batas waktu absensi keluar adalah pukul 17:00 WITA.');
        }

        return view('mahasiswa.absensi.create', compact('today'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:hadir,izin,sakit',
            'keterangan' => 'nullable|string',
            'foto_masuk' => 'nullable|image|max:2048',
        ]);

        $today = Absensi::where('user_id', Auth::id())
            ->whereDate('tanggal', today())
            ->first();

        if ($today && $today->jam_keluar) {
            return redirect()->route('mahasiswa.absensi.index')
                ->with('error', 'Anda sudah absen keluar hari ini.');
        }

        if (!$today) {
            // Check time limit for absen masuk
            $currentTime = now()->format('H:i');
            $minAbsenMasuk = '06:00';
            $maxAbsenMasuk = '08:10';
            
            if ($currentTime < $minAbsenMasuk || $currentTime > $maxAbsenMasuk) {
                return redirect()->route('mahasiswa.absensi.index')
                    ->with('error', 'Waktu absensi masuk adalah 06:00 - 08:10 WITA. Saat ini pukul ' . $currentTime . ' WITA.');
            }

            // Absen Masuk
            $data = [
                'user_id' => Auth::id(),
                'tanggal' => today(),
                'jam_masuk' => now()->format('H:i:s'),
                'status' => $validated['status'],
                'keterangan' => $validated['keterangan'],
            ];

            if ($request->hasFile('foto_masuk')) {
                $data['foto_masuk'] = $request->file('foto_masuk')
                    ->store('absensi', 'public');
            }

            Absensi::create($data);
            return redirect()->route('mahasiswa.absensi.index')
                ->with('success', 'Absen masuk berhasil!');
        } else {
            // Check time limit for absen keluar
            $currentTime = now()->format('H:i');
            $maxAbsenKeluar = '17:00';
            
            if ($currentTime > $maxAbsenKeluar) {
                return redirect()->route('mahasiswa.absensi.index')
                    ->with('error', 'Waktu absensi keluar sudah berakhir. Batas waktu absensi keluar adalah pukul 17:00 WITA.');
            }

            // Absen Keluar
            if ($request->hasFile('foto_keluar')) {
                $today->foto_keluar = $request->file('foto_keluar')
                    ->store('absensi', 'public');
            }

            $today->jam_keluar = now()->format('H:i:s');
            $today->save();

            return redirect()->route('mahasiswa.absensi.index')
                ->with('success', 'Absen keluar berhasil!');
        }
    }
}
