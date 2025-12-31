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

class TugasController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = TugasMahasiswa::where('user_id', $user->id)
            ->with(['tugas', 'user']);

        if ($request->filled('status')) {
            $query->whereHas('tugas', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        if ($request->filled('search')) {
            $query->whereHas('tugas', function ($q) use ($request) {
                $q->where('judul_tugas', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('tanggal_mulai')) {
            $query->whereHas('tugas', function ($q) use ($request) {
                $q->whereDate('tanggal_mulai', '>=', $request->tanggal_mulai);
            });
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereHas('tugas', function ($q) use ($request) {
                $q->whereDate('tanggal_selesai', '<=', $request->tanggal_selesai);
            });
        }

        $tugas = $query->latest()->paginate(10);

        $statusOptions = [
            'pending' => 'Pending',
            'active' => 'Active',
            'completed' => 'Completed'
        ];

        return view('mahasiswa.tugas.index', compact('tugas', 'statusOptions'));
    }

    public function show($id)
    {
        $tugasMahasiswa = TugasMahasiswa::with('tugas')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('mahasiswa.tugas.show', compact('tugasMahasiswa'));
    }

    public function upload(Request $request, $id)
    {
        $tugasMahasiswa = TugasMahasiswa::where('user_id', Auth::id())
            ->findOrFail($id);

        $request->validate([
            'catatan' => 'nullable|string',
            'file_upload' => 'required|file|max:10240', // 10MB
        ]);

        // Delete old file if exists
        if ($tugasMahasiswa->file_upload) {
            Storage::disk('public')->delete($tugasMahasiswa->file_upload);
        }

        $path = $request->file('file_upload')->store('tugas', 'public');

        $tugasMahasiswa->update([
            'catatan' => $request->catatan,
            'file_upload' => $path,
            'status_pengerjaan' => 'selesai',
            'tanggal_submit' => now(),
        ]);

        return redirect()->route('mahasiswa.tugas.index')
            ->with('success', 'Tugas berhasil diupload!');
    }
}
