@extends('layouts.app')

@section('title', 'Buat Laporan Akhir')
@section('header', 'Buat Laporan Akhir')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-medium text-gray-900">Form Buat Laporan Akhir</h3>
                <a href="{{ route('admin.laporan.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 flex items-center transition-colors duration-200">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>

            <form action="{{ route('admin.laporan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="user_id" class="block text-sm font-medium text-gray-700">Mahasiswa <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <select name="user_id" id="user_id" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg">
                                <option value="">Pilih Mahasiswa</option>
                                @foreach($mahasiswa as $m)
                                    <option value="{{ $m->id }}" {{ old('user_id') == $m->id ? 'selected' : '' }}>{{ $m->name }} ({{ $m->nim }})</option>
                                @endforeach
                            </select>
                        </div>
                        @error('user_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="judul" class="block text-sm font-medium text-gray-700">Judul <span class="text-red-500">*</span></label>
                        <input type="text" name="judul" id="judul" value="{{ old('judul') }}" required class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg">
                        @error('judul')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="ringkasan" class="block text-sm font-medium text-gray-700">Ringkasan</label>
                        <textarea name="ringkasan" id="ringkasan" rows="4" class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg">{{ old('ringkasan') }}</textarea>
                        @error('ringkasan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="file_laporan" class="block text-sm font-medium text-gray-700">File Laporan (PDF, maks 5MB)</label>
                        <input type="file" name="file_laporan" id="file_laporan" accept="application/pdf" class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        @error('file_laporan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                        <select name="status" id="status" class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg">
                            @foreach($statusOptions as $key => $label)
                                <option value="{{ $key }}" {{ old('status', 'pending') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="catatan_revisi" class="block text-sm font-medium text-gray-700">Catatan Revisi</label>
                        <input type="text" name="catatan_revisi" id="catatan_revisi" value="{{ old('catatan_revisi') }}" class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg">
                        @error('catatan_revisi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="inline-flex justify-center py-2.5 px-6 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:-translate-y-0.5">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
