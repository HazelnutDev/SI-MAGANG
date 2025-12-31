<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanAkhir;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = LaporanAkhir::with('user');
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by mahasiswa
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        // Search by title
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('nim', 'like', "%{$search}%");
                  });
            });
        }
        
        $laporan = $query->latest('tanggal_submit')->paginate(10);
        
        $mahasiswa = User::where('role', 'mahasiswa')->orderBy('name')->get();
        
        $statusOptions = [
            'pending' => 'Pending',
            'revisi' => 'Revisi',
            'approved' => 'Approved'
        ];
        
        return view('admin.laporan.index', compact('laporan', 'mahasiswa', 'statusOptions'));
    }
    
    public function create()
    {
        $mahasiswa = User::where('role', 'mahasiswa')->orderBy('name')->get();
        $statusOptions = [
            'pending' => 'Pending',
            'revisi' => 'Revisi',
            'approved' => 'Approved'
        ];
        return view('admin.laporan.create', compact('mahasiswa', 'statusOptions'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'judul' => 'required|string|max:255',
            'ringkasan' => 'nullable|string',
            'status' => 'required|in:pending,revisi,approved',
            'catatan_revisi' => 'nullable|string',
            'file_laporan' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        if ($request->hasFile('file_laporan')) {
            $validated['file_laporan'] = $request->file('file_laporan')->store('laporan', 'public');
        }

        $validated['tanggal_submit'] = now();

        LaporanAkhir::create($validated);
        
        return redirect()->route('admin.laporan.index')
            ->with('success', 'Laporan berhasil dibuat');
    }
    
    public function show(LaporanAkhir $laporan)
    {
        $laporan->load('user');
        return view('admin.laporan.show', compact('laporan'));
    }
    
    public function edit(LaporanAkhir $laporan)
    {
        $laporan->load('user');
        return view('admin.laporan.edit', compact('laporan'));
    }
    
    public function update(Request $request, LaporanAkhir $laporan)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,revisi,approved',
            'catatan_revisi' => 'nullable|string'
        ]);
        
        $laporan->update($validated);
        
        return redirect()->route('admin.laporan.index')
            ->with('success', 'Status laporan berhasil diperbarui');
    }
    
    public function approve(LaporanAkhir $laporan)
    {
        $laporan->update([
            'status' => 'approved',
            'catatan_revisi' => null
        ]);
        
        return redirect()->route('admin.laporan.index')
            ->with('success', 'Laporan berhasil disetujui');
    }
    
    public function reject(Request $request, LaporanAkhir $laporan)
    {
        $validated = $request->validate([
            'catatan_revisi' => 'required|string|max:1000'
        ]);
        
        $laporan->update([
            'status' => 'revisi',
            'catatan_revisi' => $validated['catatan_revisi']
        ]);
        
        return redirect()->route('admin.laporan.index')
            ->with('success', 'Laporan dikembalikan untuk revisi');
    }
    
    public function destroy(LaporanAkhir $laporan)
    {
        // Delete file if exists
        if ($laporan->file_laporan) {
            Storage::disk('public')->delete($laporan->file_laporan);
        }
        
        $laporan->delete();
        
        return redirect()->route('admin.laporan.index')
            ->with('success', 'Laporan berhasil dihapus');
    }
    
    public function download(LaporanAkhir $laporan)
    {
        if (!$laporan->file_laporan || !Storage::disk('public')->exists($laporan->file_laporan)) {
            return redirect()->back()->with('error', 'File laporan tidak ditemukan');
        }

        // Build a safe filename by sanitizing the title
        $safeName = preg_replace('/[^A-Za-z0-9\-_]/', '_', $laporan->judul) . '.pdf';

        return response()->download(
            Storage::disk('public')->path($laporan->file_laporan),
            $safeName
        );
    }
}
