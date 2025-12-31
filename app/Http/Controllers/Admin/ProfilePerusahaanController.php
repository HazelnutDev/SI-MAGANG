<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilePerusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilePerusahaanController extends Controller
{
    public function index()
    {
        $profile = ProfilePerusahaan::first();
        return view('admin.profile-perusahaan.index', compact('profile'));
    }
    
    public function create()
    {
        return view('admin.profile-perusahaan.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'website' => 'nullable|url|max:255',
            'deskripsi' => 'nullable|string',
            'kepala_dinas' => 'required|string|max:255',
            'pembimbing_lapangan' => 'nullable|string|max:255',
            'penanggung_jawab' => 'nullable|string|max:255',
            'kordinator_photos_videos' => 'nullable|string|max:255',
            'kordinator_releas_berita' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logo', 'public');
        }
        
        ProfilePerusahaan::create($validated);
        
        return redirect()->route('admin.profile-perusahaan.index')
            ->with('success', 'Profile perusahaan berhasil dibuat');
    }
    
    public function edit(ProfilePerusahaan $profilePerusahaan)
    {
        return view('admin.profile-perusahaan.edit', compact('profilePerusahaan'));
    }
    
    public function update(Request $request, ProfilePerusahaan $profilePerusahaan)
    {
        $validated = $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'website' => 'nullable|url|max:255',
            'deskripsi' => 'nullable|string',
            'kepala_dinas' => 'required|string|max:255',
            'pembimbing_lapangan' => 'nullable|string|max:255',
            'penanggung_jawab' => 'nullable|string|max:255',
            'kordinator_photos_videos' => 'nullable|string|max:255',
            'kordinator_releas_berita' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($profilePerusahaan->logo) {
                Storage::disk('public')->delete($profilePerusahaan->logo);
            }
            $validated['logo'] = $request->file('logo')->store('logo', 'public');
        }
        
        $profilePerusahaan->update($validated);
        
        return redirect()->route('admin.profile-perusahaan.index')
            ->with('success', 'Profile perusahaan berhasil diperbarui');
    }
}