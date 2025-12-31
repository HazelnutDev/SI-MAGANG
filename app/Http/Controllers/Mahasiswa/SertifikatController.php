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

class SertifikatController extends Controller
{
    public function index()
    {
        $sertifikat = Sertifikat::where('user_id', Auth::id())->first();
        return view('mahasiswa.sertifikat.index', compact('sertifikat'));
    }

    public function download($id)
    {
        $sertifikat = Sertifikat::where('user_id', Auth::id())
            ->findOrFail($id);

        if (!$sertifikat->file_sertifikat) {
            return back()->with('error', 'File sertifikat tidak tersedia.');
        }

        return Storage::disk('public')->download($sertifikat->file_sertifikat);
    }
}
