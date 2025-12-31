<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TugasKegiatanHarian;
use App\Models\TugasMahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TugasController extends Controller
{
    public function index(Request $request)
    {
        $query = TugasKegiatanHarian::query();
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Search by title
        if ($request->filled('search')) {
            $query->where('judul_tugas', 'like', '%' . $request->search . '%');
        }
        
        // Filter by date range
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_mulai', '>=', $request->tanggal_mulai);
        }
        
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal_selesai', '<=', $request->tanggal_selesai);
        }
        
        $tugas = $query->withCount('tugasMahasiswa')->latest()->paginate(10);
        
        $statusOptions = [
            'pending' => 'Pending',
            'active' => 'Active',
            'completed' => 'Completed'
        ];
        
        return view('admin.tugas.index', compact('tugas', 'statusOptions'));
    }
    
    public function create()
    {
        $mahasiswa = User::where('role', 'mahasiswa')->orderBy('name')->get();
        return view('admin.tugas.create', compact('mahasiswa'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_tugas' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:pending,active,completed',
        ]);

        $mahasiswaInput = collect($request->input('mahasiswa', []))
            ->filter(function ($item) {
                return isset($item['user_id']) && $item['user_id'];
            })->values();

        if ($mahasiswaInput->isEmpty()) {
            return back()->withErrors(['mahasiswa' => 'Silakan pilih minimal satu mahasiswa.'])->withInput();
        }

        $assignValidator = Validator::make($mahasiswaInput->toArray(), [
            '*.user_id' => 'required|exists:users,id',
            '*.kategori' => 'required|in:photographer,videographer,pressrelease',
        ]);

        if ($assignValidator->fails()) {
            return back()->withErrors($assignValidator)->withInput();
        }

        $tugas = TugasKegiatanHarian::create([
            'judul_tugas' => $validated['judul_tugas'],
            'deskripsi' => $validated['deskripsi'],
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'status' => $validated['status'],
        ]);

        foreach ($mahasiswaInput as $mahasiswaData) {
            TugasMahasiswa::create([
                'tugas_id' => $tugas->id,
                'user_id' => $mahasiswaData['user_id'],
                'kategori' => $mahasiswaData['kategori'],
                'status_pengerjaan' => 'belum_mulai',
            ]);
        }

        return redirect()->route('admin.tugas.index')
            ->with('success', 'Tugas berhasil dibuat dan diassign ke mahasiswa');
    }
    
    public function show(TugasKegiatanHarian $tuga)
    {
        $tugas = $tuga;
        $tugas->load(['tugasMahasiswa.user']);
        return view('admin.tugas.show', compact('tugas'));
    }
    
    public function edit(TugasKegiatanHarian $tuga)
    {
        $tugas = $tuga;
        $tugas->load(['tugasMahasiswa.user']);
        $mahasiswa = User::where('role', 'mahasiswa')->orderBy('name')->get();
        return view('admin.tugas.edit', compact('tugas', 'mahasiswa'));
    }
    
    public function update(Request $request, TugasKegiatanHarian $tuga)
    {
        $tugas = $tuga;
        $validated = $request->validate([
            'judul_tugas' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:pending,active,completed',
        ]);

        $mahasiswaInput = collect($request->input('mahasiswa', []))
            ->filter(function ($item) {
                return isset($item['user_id']) && $item['user_id'];
            })->values();

        if ($mahasiswaInput->isEmpty()) {
            return back()->withErrors(['mahasiswa' => 'Silakan pilih minimal satu mahasiswa.'])->withInput();
        }

        $assignValidator = Validator::make($mahasiswaInput->toArray(), [
            '*.user_id' => 'required|exists:users,id',
            '*.kategori' => 'required|in:photographer,videographer,pressrelease',
        ]);

        if ($assignValidator->fails()) {
            return back()->withErrors($assignValidator)->withInput();
        }

        $tugas->update([
            'judul_tugas' => $validated['judul_tugas'],
            'deskripsi' => $validated['deskripsi'],
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'status' => $validated['status'],
        ]);

        $tugas->tugasMahasiswa()->delete();

        foreach ($mahasiswaInput as $mahasiswaData) {
            TugasMahasiswa::create([
                'tugas_id' => $tugas->id,
                'user_id' => $mahasiswaData['user_id'],
                'kategori' => $mahasiswaData['kategori'],
                'status_pengerjaan' => 'belum_mulai',
            ]);
        }

        return redirect()->route('admin.tugas.index')
            ->with('success', 'Tugas berhasil diperbarui');
    }
    
    public function destroy(TugasKegiatanHarian $tuga)
    {
        $tugas = $tuga;
        // Delete assignments first
        $tugas->tugasMahasiswa()->delete();
        
        // Delete tugas
        $tugas->delete();
        
        return redirect()->route('admin.tugas.index')
            ->with('success', 'Tugas berhasil dihapus');
    }
}
