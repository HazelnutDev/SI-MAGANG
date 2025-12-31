<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sertifikat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SertifikatController extends Controller
{
    public function index(Request $request)
    {
        $query = Sertifikat::with('user');
        
        // Filter by mahasiswa
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_sertifikat', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('nim', 'like', "%{$search}%");
                  });
            });
        }
        
        // Filter by date range
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_terbit', '>=', $request->tanggal_mulai);
        }
        
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal_terbit', '<=', $request->tanggal_selesai);
        }
        
        $sertifikat = $query->latest('tanggal_terbit')->paginate(10);
        
        $mahasiswa = User::where('role', 'mahasiswa')->orderBy('name')->get();
        
        return view('admin.sertifikat.index', compact('sertifikat', 'mahasiswa'));
    }
    
    public function create()
    {
        $mahasiswa = User::where('role', 'mahasiswa')->orderBy('name')->get();
        return view('admin.sertifikat.create', compact('mahasiswa'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'nomor_sertifikat' => 'required|string|unique:sertifikat,nomor_sertifikat',
            'tanggal_terbit' => 'required|date',
            'tanggal_mulai_magang' => 'required|date',
            'tanggal_selesai_magang' => 'required|date|after_or_equal:tanggal_mulai_magang',
            'nama_instansi' => 'nullable|string|max:255',
            'lokasi_instansi' => 'nullable|string|max:255',
            'kepala_dinas' => 'nullable|string|max:255',
            'file_sertifikat' => 'nullable|file|mimes:pdf|max:5120'
        ]);
        
        // Calculate duration
        $mulai = Carbon::parse($validated['tanggal_mulai_magang']);
        $selesai = Carbon::parse($validated['tanggal_selesai_magang']);
        $durasi = $mulai->diffInDays($selesai) + 1;
        $validated['durasi_magang'] = $durasi . ' hari';
        
        // Handle file upload
        if ($request->hasFile('file_sertifikat')) {
            $validated['file_sertifikat'] = $request->file('file_sertifikat')->store('sertifikat', 'public');
        }
        
        Sertifikat::create($validated);
        
        return redirect()->route('admin.sertifikat.index')
            ->with('success', 'Sertifikat berhasil dibuat');
    }
    
    public function show(Sertifikat $sertifikat)
    {
        $sertifikat->load('user');
        return view('admin.sertifikat.show', compact('sertifikat'));
    }
    
    public function edit(Sertifikat $sertifikat)
    {
        $sertifikat->load('user');
        $mahasiswa = User::where('role', 'mahasiswa')->orderBy('name')->get();
        return view('admin.sertifikat.edit', compact('sertifikat', 'mahasiswa'));
    }
    
    public function update(Request $request, Sertifikat $sertifikat)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'nomor_sertifikat' => 'required|string|unique:sertifikat,nomor_sertifikat,' . $sertifikat->id,
            'tanggal_terbit' => 'required|date',
            'tanggal_mulai_magang' => 'required|date',
            'tanggal_selesai_magang' => 'required|date|after_or_equal:tanggal_mulai_magang',
            'nama_instansi' => 'nullable|string|max:255',
            'lokasi_instansi' => 'nullable|string|max:255',
            'kepala_dinas' => 'nullable|string|max:255',
            'file_sertifikat' => 'nullable|file|mimes:pdf|max:5120'
        ]);
        
        // Calculate duration
        $mulai = Carbon::parse($validated['tanggal_mulai_magang']);
        $selesai = Carbon::parse($validated['tanggal_selesai_magang']);
        $durasi = $mulai->diffInDays($selesai) + 1;
        $validated['durasi_magang'] = $durasi . ' hari';
        
        // Handle file upload
        if ($request->hasFile('file_sertifikat')) {
            // Delete old file
            if ($sertifikat->file_sertifikat) {
                Storage::disk('public')->delete($sertifikat->file_sertifikat);
            }
            $validated['file_sertifikat'] = $request->file('file_sertifikat')->store('sertifikat', 'public');
        }
        
        $sertifikat->update($validated);
        
        return redirect()->route('admin.sertifikat.index')
            ->with('success', 'Sertifikat berhasil diperbarui');
    }
    
    public function destroy(Sertifikat $sertifikat)
    {
        // Delete file if exists
        if ($sertifikat->file_sertifikat) {
            Storage::disk('public')->delete($sertifikat->file_sertifikat);
        }
        
        $sertifikat->delete();
        
        return redirect()->route('admin.sertifikat.index')
            ->with('success', 'Sertifikat berhasil dihapus');
    }
    
    public function export(Request $request)
    {
        $query = Sertifikat::with('user');
        
        // Apply same filters as index
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_terbit', '>=', $request->tanggal_mulai);
        }
        
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal_terbit', '<=', $request->tanggal_selesai);
        }
        
        $sertifikat = $query->latest('tanggal_terbit')->get();
        
        $filename = 'sertifikat_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
        
        $callback = function() use ($sertifikat) {
            $file = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($file, [
                'Nama Mahasiswa',
                'NIM',
                'Nomor Sertifikat',
                'Tanggal Terbit',
                'Tanggal Mulai Magang',
                'Tanggal Selesai Magang',
                'Durasi Magang',
                'Nama Instansi',
                'Lokasi Instansi',
                'Kepala Dinas'
            ]);
            
            // Data
            foreach ($sertifikat as $item) {
                fputcsv($file, [
                    $item->user->name,
                    $item->user->nim,
                    $item->nomor_sertifikat,
                    $item->tanggal_terbit,
                    $item->tanggal_mulai_magang,
                    $item->tanggal_selesai_magang,
                    $item->durasi_magang,
                    $item->nama_instansi,
                    $item->lokasi_instansi,
                    $item->kepala_dinas
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    public function downloadTemplate()
    {
        $filename = 'template_sertifikat.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
        
        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($file, [
                'user_id',
                'nomor_sertifikat',
                'tanggal_terbit',
                'tanggal_mulai_magang',
                'tanggal_selesai_magang',
                'nama_instansi',
                'lokasi_instansi',
                'kepala_dinas'
            ]);
            
            // Example data
            fputcsv($file, [
                '1',
                '800.1.12.a/589/2/KOMINFOTIK/2024',
                '2024-12-25',
                '2024-01-15',
                '2024-03-15',
                'Dinas Komunikasi dan Informatika',
                'Kota Bandung',
                'Dr. John Doe, S.Kom., M.T.'
            ]);
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt'
        ]);
        
        $file = $request->file('file');
        $csvData = file_get_contents($file);
        $rows = array_map('str_getcsv', explode("\n", $csvData));
        $header = array_shift($rows);
        
        $imported = 0;
        $errors = [];
        
        foreach ($rows as $index => $row) {
            if (empty(array_filter($row))) continue;
            
            try {
                $data = array_combine($header, $row);
                
                // Calculate duration
                $mulai = Carbon::parse($data['tanggal_mulai_magang']);
                $selesai = Carbon::parse($data['tanggal_selesai_magang']);
                $durasi = $mulai->diffInDays($selesai) + 1;
                
                Sertifikat::create([
                    'user_id' => $data['user_id'],
                    'nomor_sertifikat' => $data['nomor_sertifikat'],
                    'tanggal_terbit' => $data['tanggal_terbit'],
                    'tanggal_mulai_magang' => $data['tanggal_mulai_magang'],
                    'tanggal_selesai_magang' => $data['tanggal_selesai_magang'],
                    'durasi_magang' => $durasi . ' hari',
                    'nama_instansi' => $data['nama_instansi'] ?? null,
                    'lokasi_instansi' => $data['lokasi_instansi'] ?? null,
                    'kepala_dinas' => $data['kepala_dinas'] ?? null
                ]);
                
                $imported++;
            } catch (\Exception $e) {
                $errors[] = "Baris " . ($index + 2) . ": " . $e->getMessage();
            }
        }
        
        $message = "Berhasil import {$imported} sertifikat";
        if (!empty($errors)) {
            $message .= ". Error: " . implode(', ', array_slice($errors, 0, 3));
        }
        
        return redirect()->route('admin.sertifikat.index')->with('success', $message);
    }
}