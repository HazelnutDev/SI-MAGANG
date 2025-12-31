@extends('layouts.app')

@section('title', 'Edit Sertifikat')
@section('header', 'Edit Sertifikat')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-medium text-gray-900">Form Edit Sertifikat</h3>
                <a href="{{ route('admin.sertifikat.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 flex items-center transition-colors duration-200">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>

            <form action="{{ route('admin.sertifikat.update', $sertifikat->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="user_id" class="block text-sm font-medium text-gray-700">Mahasiswa <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <select name="user_id" id="user_id" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg">
                                @foreach($mahasiswa as $m)
                                    <option value="{{ $m->id }}" {{ old('user_id', $sertifikat->user_id) == $m->id ? 'selected' : '' }}>{{ $m->name }} ({{ $m->nim }})</option>
                                @endforeach
                            </select>
                        </div>
                        @error('user_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nomor_sertifikat" class="block text-sm font-medium text-gray-700">Nomor Sertifikat <span class="text-red-500">*</span></label>
                        <input type="text" name="nomor_sertifikat" id="nomor_sertifikat" value="{{ old('nomor_sertifikat', $sertifikat->nomor_sertifikat) }}" required class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg">
                        @error('nomor_sertifikat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="tanggal_terbit" class="block text-sm font-medium text-gray-700">Tanggal Terbit <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_terbit" id="tanggal_terbit" value="{{ old('tanggal_terbit', optional($sertifikat->tanggal_terbit)->format('Y-m-d')) }}" required class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg">
                        @error('tanggal_terbit')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tanggal_mulai_magang" class="block text-sm font-medium text-gray-700">Tanggal Mulai Magang <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_mulai_magang" id="tanggal_mulai_magang" value="{{ old('tanggal_mulai_magang', optional($sertifikat->tanggal_mulai_magang)->format('Y-m-d')) }}" required class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg">
                        @error('tanggal_mulai_magang')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="tanggal_selesai_magang" class="block text-sm font-medium text-gray-700">Tanggal Selesai Magang <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_selesai_magang" id="tanggal_selesai_magang" value="{{ old('tanggal_selesai_magang', optional($sertifikat->tanggal_selesai_magang)->format('Y-m-d')) }}" required class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg">
                        @error('tanggal_selesai_magang')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nama_instansi" class="block text-sm font-medium text-gray-700">Nama Instansi</label>
                        <input type="text" name="nama_instansi" id="nama_instansi" value="{{ old('nama_instansi', $sertifikat->nama_instansi) }}" class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg">
                        @error('nama_instansi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="lokasi_instansi" class="block text-sm font-medium text-gray-700">Lokasi Instansi</label>
                        <input type="text" name="lokasi_instansi" id="lokasi_instansi" value="{{ old('lokasi_instansi', $sertifikat->lokasi_instansi) }}" class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg">
                        @error('lokasi_instansi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="kepala_dinas" class="block text-sm font-medium text-gray-700">Kepala Dinas</label>
                        <input type="text" name="kepala_dinas" id="kepala_dinas" value="{{ old('kepala_dinas', $sertifikat->kepala_dinas) }}" class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg">
                        @error('kepala_dinas')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="file_sertifikat" class="block text-sm font-medium text-gray-700">File Sertifikat (PDF, maks 5MB)</label>
                        <input type="file" name="file_sertifikat" id="file_sertifikat" accept="application/pdf" class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        @if($sertifikat->file_sertifikat)
                            <p class="mt-2 text-xs text-gray-500">File saat ini: {{ $sertifikat->file_sertifikat }}</p>
                        @endif
                        @error('file_sertifikat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="inline-flex justify-center py-2.5 px-6 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:-translate-y-0.5">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
