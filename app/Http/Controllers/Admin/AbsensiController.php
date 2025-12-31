<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $query = Absensi::with('user');
        
        // Filter by date range
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }
        
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_selesai);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by mahasiswa
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        // Search by name or NIM
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }
        
        $absensi = $query->latest('tanggal')->paginate(15);
        
        $mahasiswa = User::where('role', 'mahasiswa')
            ->orderBy('name')
            ->get(['id', 'name', 'nim']);
            
        $statusOptions = [
            'hadir' => 'Hadir',
            'izin' => 'Izin', 
            'sakit' => 'Sakit',
            'alpha' => 'Alpha'
        ];
        
        return view('admin.absensi.index', compact('absensi', 'mahasiswa', 'statusOptions'));
    }
    
    public function create()
    {
        $mahasiswa = User::where('role', 'mahasiswa')
            ->orderBy('name')
            ->get(['id', 'name', 'nim']);
            
        return view('admin.absensi.create', compact('mahasiswa'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_keluar' => 'nullable|date_format:H:i',
            'status' => 'required|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable|string|max:500'
        ]);
        
        // Check if absensi already exists for this date and user
        $exists = Absensi::where('user_id', $validated['user_id'])
            ->whereDate('tanggal', $validated['tanggal'])
            ->exists();
            
        if ($exists) {
            return back()->withErrors(['tanggal' => 'Absensi untuk tanggal ini sudah ada'])
                ->withInput();
        }
        
        Absensi::create($validated);
        
        return redirect()->route('admin.absensi.index')
            ->with('success', 'Data absensi berhasil ditambahkan');
    }
    
    public function show(Absensi $absensi)
    {
        $absensi->load('user');
        return view('admin.absensi.show', compact('absensi'));
    }
    
    public function edit(Absensi $absensi)
    {
        $mahasiswa = User::where('role', 'mahasiswa')
            ->orderBy('name')
            ->get(['id', 'name', 'nim']);
            
        return view('admin.absensi.edit', compact('absensi', 'mahasiswa'));
    }
    
    public function update(Request $request, Absensi $absensi)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_keluar' => 'nullable|date_format:H:i',
            'status' => 'required|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable|string|max:500'
        ]);
        
        // Check if absensi already exists for this date and user (except current record)
        $exists = Absensi::where('user_id', $validated['user_id'])
            ->whereDate('tanggal', $validated['tanggal'])
            ->where('id', '!=', $absensi->id)
            ->exists();
            
        if ($exists) {
            return back()->withErrors(['tanggal' => 'Absensi untuk tanggal ini sudah ada'])
                ->withInput();
        }
        
        $absensi->update($validated);
        
        return redirect()->route('admin.absensi.index')
            ->with('success', 'Data absensi berhasil diperbarui');
    }
    
    public function destroy(Absensi $absensi)
    {
        $absensi->delete();
        
        return redirect()->route('admin.absensi.index')
            ->with('success', 'Data absensi berhasil dihapus');
    }
    
    public function export(Request $request)
    {
        $query = Absensi::with('user');
        
        // Apply same filters as index
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }
        
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_selesai);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        $absensi = $query->latest('tanggal')->get();
        
        $filename = 'absensi_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
        
        $callback = function() use ($absensi) {
            $file = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($file, [
                'Nama Mahasiswa',
                'NIM',
                'Tanggal',
                'Jam Masuk',
                'Jam Keluar',
                'Status',
                'Keterangan'
            ]);
            
            // Data
            foreach ($absensi as $item) {
                fputcsv($file, [
                    $item->user->name,
                    $item->user->nim,
                    $item->tanggal,
                    $item->jam_masuk,
                    $item->jam_keluar,
                    ucfirst($item->status),
                    $item->keterangan
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}