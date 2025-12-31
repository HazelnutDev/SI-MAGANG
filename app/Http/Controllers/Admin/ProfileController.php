<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('admin.profile.edit', compact('user'));
    }
    
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'no_telp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        if ($request->hasFile('foto_profil')) {
            // Delete old photo
            if ($user->foto_profil) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $validated['foto_profil'] = $request->file('foto_profil')->store('profile', 'public');
        }
        
        $user->update($validated);
        
        return redirect()->route('admin.profile.edit')
            ->with('success', 'Profile berhasil diperbarui');
    }
    
    public function changePassword()
    {
        return view('admin.profile.change-password');
    }
    
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        if (!Hash::check($validated['current_password'], Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
        }
        
        Auth::user()->update([
            'password' => Hash::make($validated['password'])
        ]);
        
        return redirect()->route('admin.profile.change-password')
            ->with('success', 'Password berhasil diperbarui');
    }
}
