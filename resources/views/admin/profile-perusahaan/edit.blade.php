@extends('layouts.app')

@section('title', 'Edit Profile Perusahaan')
@section('header', 'Edit Profile Perusahaan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-medium text-gray-900">Form Edit Profile</h3>
                <a href="{{ route('admin.profile-perusahaan.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Kembali</a>
            </div>

            <form action="{{ route('admin.profile-perusahaan.update', $profilePerusahaan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PATCH')
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Nama Perusahaan<span class="text-red-500"> *</span></label>
                        <input type="text" name="nama_perusahaan" value="{{ old('nama_perusahaan', $profilePerusahaan->nama_perusahaan) }}" required class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('nama_perusahaan')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Alamat<span class="text-red-500"> *</span></label>
                        <textarea name="alamat" rows="3" required class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('alamat', $profilePerusahaan->alamat) }}</textarea>
                        @error('alamat')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Telepon<span class="text-red-500"> *</span></label>
                        <input type="text" name="telepon" value="{{ old('telepon', $profilePerusahaan->telepon) }}" required class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('telepon')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email<span class="text-red-500"> *</span></label>
                        <input type="email" name="email" value="{{ old('email', $profilePerusahaan->email) }}" required class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Website</label>
                        <input type="url" name="website" value="{{ old('website', $profilePerusahaan->website) }}" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('website')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" rows="4" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('deskripsi', $profilePerusahaan->deskripsi) }}</textarea>
                        @error('deskripsi')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kepala Dinas<span class="text-red-500"> *</span></label>
                        <input type="text" name="kepala_dinas" value="{{ old('kepala_dinas', $profilePerusahaan->kepala_dinas ?? $profilePerusahaan->Kepala_Dinas) }}" required class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('kepala_dinas')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pembimbing Lapangan</label>
                        <input type="text" name="pembimbing_lapangan" value="{{ old('pembimbing_lapangan', $profilePerusahaan->pembimbing_lapangan) }}" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('pembimbing_lapangan')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Penanggung Jawab</label>
                        <input type="text" name="penanggung_jawab" value="{{ old('penanggung_jawab', $profilePerusahaan->penanggung_jawab ?? $profilePerusahaan->Penanggung_Jawab) }}" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('penanggung_jawab')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Koordinator Foto/Video</label>
                        <input type="text" name="kordinator_photos_videos" value="{{ old('kordinator_photos_videos', $profilePerusahaan->Kordinator_Photos_Videos) }}" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('kordinator_photos_videos')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Koordinator Rilis Berita</label>
                        <input type="text" name="kordinator_releas_berita" value="{{ old('kordinator_releas_berita', $profilePerusahaan->Kordinator_Releas_Berita) }}" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('kordinator_releas_berita')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Logo</label>
                        <div class="flex items-center gap-4 mt-1">
                            @if($profilePerusahaan->logo)
                                <img src="{{ asset('storage/' . $profilePerusahaan->logo) }}" alt="Logo" class="h-12 w-12 rounded-lg object-cover ring-2 ring-indigo-50">
                            @endif
                            <input type="file" name="logo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700">
                        </div>
                        @error('logo')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="pt-5 border-t border-gray-200">
                    <div class="flex justify-end">
                        <a href="{{ route('admin.profile-perusahaan.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</a>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
