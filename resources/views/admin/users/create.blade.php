@extends('layouts.app')

@section('title', 'Tambah Mahasiswa')
@section('header', 'Tambah Mahasiswa Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-medium text-gray-900">Informasi Mahasiswa</h3>
                <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 flex items-center transition-colors duration-200">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>

            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition duration-200" placeholder="Masukkan nama lengkap">
                        </div>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nim" class="block text-sm font-medium text-gray-700">NIM <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <input type="text" name="nim" id="nim" value="{{ old('nim') }}" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition duration-200" placeholder="Nomor Induk Mahasiswa">
                        </div>
                        @error('nim')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition duration-200" placeholder="email@contoh.com">
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">No. Telepon</label>
                        <div class="mt-1">
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition duration-200" placeholder="08xxxxxxxxxx">
                        </div>
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="asal_sekolah" class="block text-sm font-medium text-gray-700">Asal Sekolah <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <input type="text" name="asal_sekolah" id="asal_sekolah" value="{{ old('asal_sekolah') }}" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition duration-200" placeholder="Nama Universitas/Politeknik">
                        </div>
                        @error('asal_sekolah')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                        <div class="mt-1">
                            <textarea name="address" id="address" rows="3"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition duration-200" placeholder="Alamat lengkap">{{ old('address') }}</textarea>
                        </div>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <input type="password" name="password" id="password" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition duration-200" placeholder="••••••••">
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="foto_profil" class="block text-sm font-medium text-gray-700">Foto Profil</label>
                        <div class="mt-1">
                            <input type="file" name="foto_profil" id="foto_profil"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition duration-200">
                        </div>
                        @error('foto_profil')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-5 border-t border-gray-200">
                    <div class="flex justify-end">
                        <a href="{{ route('admin.users.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                            Batal
                        </a>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200 transform hover:-translate-y-0.5">
                            Simpan Mahasiswa
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
