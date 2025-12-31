<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Models\Absensi;
use App\Models\Sertifikat;
use App\Models\LaporanAkhir;
use Illuminate\Http\Request;
use App\Models\TugasMahasiswa;
use App\Models\TugasKegiatanHarian;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('mahasiswa.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nim' => 'required|string|unique:users,nim,' . $user->id,
            'no_telp' => 'nullable|string',
            'alamat' => 'nullable|string',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle foto profil upload
        if ($request->hasFile('foto_profil')) {
            // Delete old photo if exists
            if ($user->foto_profil) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            $path = $request->file('foto_profil')->store('profile-photos', 'public');
            $validated['foto_profil'] = $path;
        }

        $user->update($validated);

        return back()->with('success', 'Profile berhasil diperbarui!');
    }

    public function changePassword()
    {
        return view('mahasiswa.profile.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }
}
