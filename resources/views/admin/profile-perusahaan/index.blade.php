@extends('layouts.app')

@section('title', 'Profile Perusahaan')
@section('header', 'Profile Perusahaan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-medium text-gray-900">Informasi Instansi</h3>
                @if($profile)
                    <a href="{{ route('admin.profile-perusahaan.edit', $profile->id) }}" class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700">Edit</a>
                @else
                    <a href="{{ route('admin.profile-perusahaan.create') }}" class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700">Buat Profile</a>
                @endif
            </div>

            @if($profile)
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="sm:col-span-2 flex items-center gap-4">
                    @if($profile->logo)
                        <img src="{{ asset('storage/' . $profile->logo) }}" alt="Logo" class="h-16 w-16 rounded-lg object-cover ring-2 ring-indigo-50">
                    @endif
                    <div>
                        <div class="text-xl font-bold text-gray-900">{{ $profile->nama_perusahaan }}</div>
                        <div class="text-sm text-gray-500">{{ $profile->website }}</div>
                    </div>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-500">Alamat</div>
                    <div class="mt-1 text-sm text-gray-900">{{ $profile->alamat }}</div>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-500">Kontak</div>
                    <div class="mt-1 text-sm text-gray-900">Telepon: {{ $profile->telepon }}</div>
                    <div class="mt-1 text-sm text-gray-900">Email: {{ $profile->email }}</div>
                </div>
                <div class="sm:col-span-2">
                    <div class="text-sm font-medium text-gray-500">Deskripsi</div>
                    <div class="mt-1 text-sm text-gray-900 bg-gray-50 p-4 rounded-lg border border-gray-200">{{ $profile->deskripsi }}</div>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-500">Kepala Dinas</div>
                    <div class="mt-1 text-sm text-gray-900">{{ $profile->Kepala_Dinas }}</div>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-500">Penanggung Jawab</div>
                    <div class="mt-1 text-sm text-gray-900">{{ $profile->Penanggung_Jawab }}</div>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-500">Pembimbing Lapangan</div>
                    <div class="mt-1 text-sm text-gray-900">{{ $profile->pembimbing_lapangan }}</div>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-500">Koordinator Foto/Video</div>
                    <div class="mt-1 text-sm text-gray-900">{{ $profile->Kordinator_Photos_Videos }}</div>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-500">Koordinator Rilis Berita</div>
                    <div class="mt-1 text-sm text-gray-900">{{ $profile->Kordinator_Releas_Berita }}</div>
                </div>
            </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500 text-lg font-medium">Belum ada profile perusahaan. Buat sekarang.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
