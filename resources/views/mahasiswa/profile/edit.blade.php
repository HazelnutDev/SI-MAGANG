@extends('layouts.app')

@section('title', 'Edit Profil')
@section('header', 'Edit Profil')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8">
            <form action="{{ route('mahasiswa.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input id="name" name="name" type="text" required class="mt-1 block w-full border-gray-300 rounded-lg" value="{{ old('name', $user->name) }}">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" name="email" type="email" required class="mt-1 block w-full border-gray-300 rounded-lg" value="{{ old('email', $user->email) }}">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                        <input id="nim" name="nim" type="text" required class="mt-1 block w-full border-gray-300 rounded-lg" value="{{ old('nim', $user->nim) }}">
                        @error('nim')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="no_telp" class="block text-sm font-medium text-gray-700">No. Telp</label>
                        <input id="no_telp" name="no_telp" type="text" class="mt-1 block w-full border-gray-300 rounded-lg" value="{{ old('no_telp', $user->no_telp) }}">
                        @error('no_telp')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                        <input id="alamat" name="alamat" type="text" class="mt-1 block w-full border-gray-300 rounded-lg" value="{{ old('alamat', $user->alamat) }}">
                        @error('alamat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label for="foto_profil" class="block text-sm font-medium text-gray-700">Foto Profil</label>
                        <input id="foto_profil" name="foto_profil" type="file" accept="image/*" class="mt-1 block w-full text-sm">
                        @error('foto_profil')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-4 flex justify-between">
                    <a href="{{ route('mahasiswa.profile.change-password') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50">Ganti Password</a>
                    <button type="submit" class="inline-flex justify-center py-2.5 px-6 rounded-xl text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

