<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IndeksNilai;
use App\Models\User;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $query = IndeksNilai::with('user');
        
        // Filter by mahasiswa
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        // Filter by grade
        if ($request->filled('grade')) {
            $query->where('grade', $request->grade);
        }
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($userQuery) use ($search) {
                $userQuery->where('name', 'like', "%{$search}%")
                         ->orWhere('nim', 'like', "%{$search}%");
            });
        }
        
        $nilai = $query->latest()->paginate(10);
        
        $mahasiswa = User::where('role', 'mahasiswa')->orderBy('name')->get();
        
        $gradeOptions = [
            'A' => 'A (85-100)',
            'B' => 'B (70-84)',
            'C' => 'C (60-69)',
            'D' => 'D (50-59)',
            'E' => 'E (0-49)'
        ];
        
        return view('admin.nilai.index', compact('nilai', 'mahasiswa', 'gradeOptions'));
    }
    
    public function create()
    {
        $mahasiswa = User::where('role', 'mahasiswa')
            ->whereNotIn('id', IndeksNilai::pluck('user_id'))
            ->orderBy('name')
            ->get();
            
        return view('admin.nilai.create', compact('mahasiswa'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id|unique:indeks_nilai,user_id',
            'nilai_absensi' => 'required|numeric|min:0|max:100',
            'nilai_tugas' => 'required|numeric|min:0|max:100',
            'nilai_laporan' => 'required|numeric|min:0|max:100',
            'nilai_sikap' => 'required|numeric|min:0|max:100',
            'catatan' => 'nullable|string|max:1000'
        ]);
        
        // Calculate final grade
        $nilaiAkhir = ($validated['nilai_absensi'] * 0.2) + 
                     ($validated['nilai_tugas'] * 0.4) + 
                     ($validated['nilai_laporan'] * 0.3) + 
                     ($validated['nilai_sikap'] * 0.1);
        
        // Determine grade
        if ($nilaiAkhir >= 85) {
            $grade = 'A';
        } elseif ($nilaiAkhir >= 70) {
            $grade = 'B';
        } elseif ($nilaiAkhir >= 60) {
            $grade = 'C';
        } elseif ($nilaiAkhir >= 50) {
            $grade = 'D';
        } else {
            $grade = 'E';
        }
        
        $validated['nilai_akhir'] = round($nilaiAkhir, 2);
        $validated['grade'] = $grade;
        
        IndeksNilai::create($validated);
        
        return redirect()->route('admin.nilai.index')
            ->with('success', 'Indeks nilai berhasil dibuat');
    }
    
    public function show(IndeksNilai $nilai)
    {
        $nilai->load('user');
        return view('admin.nilai.show', compact('nilai'));
    }
    
    public function edit(IndeksNilai $nilai)
    {
        $nilai->load('user');
        return view('admin.nilai.edit', compact('nilai'));
    }
    
    public function update(Request $request, IndeksNilai $nilai)
    {
        $validated = $request->validate([
            'nilai_absensi' => 'required|numeric|min:0|max:100',
            'nilai_tugas' => 'required|numeric|min:0|max:100',
            'nilai_laporan' => 'required|numeric|min:0|max:100',
            'nilai_sikap' => 'required|numeric|min:0|max:100',
            'catatan' => 'nullable|string|max:1000'
        ]);
        
        // Calculate final grade
        $nilaiAkhir = ($validated['nilai_absensi'] * 0.2) + 
                     ($validated['nilai_tugas'] * 0.4) + 
                     ($validated['nilai_laporan'] * 0.3) + 
                     ($validated['nilai_sikap'] * 0.1);
        
        // Determine grade
        if ($nilaiAkhir >= 85) {
            $grade = 'A';
        } elseif ($nilaiAkhir >= 70) {
            $grade = 'B';
        } elseif ($nilaiAkhir >= 60) {
            $grade = 'C';
        } elseif ($nilaiAkhir >= 50) {
            $grade = 'D';
        } else {
            $grade = 'E';
        }
        
        $validated['nilai_akhir'] = round($nilaiAkhir, 2);
        $validated['grade'] = $grade;
        
        $nilai->update($validated);
        
        return redirect()->route('admin.nilai.index')
            ->with('success', 'Indeks nilai berhasil diperbarui');
    }
    
    public function destroy(IndeksNilai $nilai)
    {
        $nilai->delete();
        
        return redirect()->route('admin.nilai.index')
            ->with('success', 'Indeks nilai berhasil dihapus');
    }
}