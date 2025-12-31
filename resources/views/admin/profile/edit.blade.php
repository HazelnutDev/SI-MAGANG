@extends('layouts.app')

@section('title', 'Edit Profil')
@section('header', 'Edit Profil Saya')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-medium text-gray-900">Informasi Pribadi</h3>
            </div>

            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition duration-200">
                        </div>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition duration-200">
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="no_telp" class="block text-sm font-medium text-gray-700">No. Telepon</label>
                        <div class="mt-1">
                            <input type="text" name="no_telp" id="no_telp" value="{{ old('no_telp', $user->no_telp) }}"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition duration-200">
                        </div>
                        @error('no_telp')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                        <div class="mt-1">
                            <textarea name="alamat" id="alamat" rows="3"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition duration-200">{{ old('alamat', $user->alamat) }}</textarea>
                        </div>
                        @error('alamat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="foto_profil" class="block text-sm font-medium text-gray-700">Foto Profil</label>
                        <div class="mt-2 flex items-center">
                            @if($user->foto_profil)
                                <span class="h-16 w-16 rounded-full overflow-hidden bg-gray-100 mr-4 ring-2 ring-indigo-50">
                                    <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="{{ $user->name }}" class="h-full w-full object-cover">
                                </span>
                            @else
                                <span class="h-16 w-16 rounded-full overflow-hidden bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold mr-4 ring-2 ring-indigo-50 text-xl">
                                    {{ substr($user->name, 0, 1) }}
                                </span>
                            @endif
                            <div class="flex-1">
                                <input type="file" name="foto_profil" id="foto_profil"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition duration-200">
                                <p class="mt-1 text-xs text-gray-500">JPG, JPEG, atau PNG. Maksimal 2MB.</p>
                            </div>
                        </div>
                        @error('foto_profil')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-5 border-t border-gray-200">
                    <div class="flex justify-end">
                        <a href="{{ route('admin.dashboard') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                            Batal
                        </a>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200 transform hover:-translate-y-0.5">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-6 bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Keamanan</h3>
                    <p class="text-sm text-gray-500">Update password anda untuk menjaga keamanan akun.</p>
                </div>
                <a href="{{ route('admin.profile.change-password') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Ganti Password
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
