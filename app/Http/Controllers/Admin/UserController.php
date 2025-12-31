<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'mahasiswa');
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('asal_sekolah', 'like', "%{$search}%");
            });
        }
        
        // Filter by school
        if ($request->filled('asal_sekolah')) {
            $query->where('asal_sekolah', $request->asal_sekolah);
        }
        
        $users = $query->latest()->paginate(10);
        $schools = User::where('role', 'mahasiswa')
            ->whereNotNull('asal_sekolah')
            ->distinct()
            ->pluck('asal_sekolah');
            
        return view('admin.users.index', compact('users', 'schools'));
    }
    
    public function create()
    {
        return view('admin.users.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'nim' => 'required|string|unique:users,nim',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'asal_sekolah' => 'required|string|max:255',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'mahasiswa';
        
        if ($request->hasFile('foto_profil')) {
            $validated['foto_profil'] = $request->file('foto_profil')->store('profile', 'public');
        }
        
        User::create($validated);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Mahasiswa berhasil ditambahkan');
    }
    
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }
    
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }
    
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8',
            'nim' => ['required', 'string', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'asal_sekolah' => 'required|string|max:255',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        
        if ($request->hasFile('foto_profil')) {
            // Delete old photo
            if ($user->foto_profil) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $validated['foto_profil'] = $request->file('foto_profil')->store('profile', 'public');
        }
        
        $user->update($validated);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui');
    }
    
    public function destroy(User $user)
    {
        // Delete profile photo
        if ($user->foto_profil) {
            Storage::disk('public')->delete($user->foto_profil);
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Mahasiswa berhasil dihapus');
    }
    
    public function export()
    {
        $users = User::where('role', 'mahasiswa')->get();
        
        $filename = 'mahasiswa_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
        
        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($file, [
                'Nama',
                'Email', 
                'NIM',
                'No. Telepon',
                'Alamat',
                'Asal Sekolah',
                'Tanggal Daftar'
            ]);
            
            // Data
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->name,
                    $user->email,
                    $user->nim,
                    $user->phone,
                    $user->address,
                    $user->asal_sekolah,
                    $user->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}