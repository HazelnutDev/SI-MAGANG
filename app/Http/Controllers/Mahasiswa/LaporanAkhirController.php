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

class LaporanAkhirController extends Controller
{
    public function index()
    {
        $laporan = LaporanAkhir::where('user_id', Auth::id())->first();
        return view('mahasiswa.laporan.index', compact('laporan'));
    }

    public function create()
    {
        $laporan = LaporanAkhir::where('user_id', Auth::id())->first();

        if ($laporan && $laporan->status == 'approved') {
            return redirect()->route('mahasiswa.laporan.index')
                ->with('error', 'Laporan Anda sudah disetujui.');
        }

        return view('mahasiswa.laporan.create', compact('laporan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'ringkasan' => 'nullable|string',
            'file_laporan' => 'required|file|mimes:pdf|max:10240',
        ]);

        if ($request->hasFile('file_laporan')) {
            $path = $request->file('file_laporan')->store('laporan', 'public');
            $validated['file_laporan'] = $path;
        }

        $validated['user_id'] = Auth::id();
        $validated['tanggal_submit'] = today();
        $validated['status'] = 'pending';

        LaporanAkhir::create($validated);

        return redirect()->route('mahasiswa.laporan.index')
            ->with('success', 'Laporan berhasil disubmit!');
    }
}

