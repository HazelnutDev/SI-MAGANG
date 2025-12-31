@extends('layouts.app')

@section('title', 'Tambah Indeks Nilai')
@section('header', 'Tambah Indeks Nilai')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-medium text-gray-900">Form Tambah Indeks Nilai</h3>
                <a href="{{ route('admin.nilai.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 flex items-center transition-colors duration-200">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>

            <form action="{{ route('admin.nilai.store') }}" method="POST" class="space-y-6">
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

                    <div>
                        <label for="nilai_absensi" class="block text-sm font-medium text-gray-700">Nilai Absensi (0-100) <span class="text-red-500">*</span></label>
                        <input type="number" name="nilai_absensi" id="nilai_absensi" value="{{ old('nilai_absensi') }}" required min="0" max="100" step="1" class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg">
                        @error('nilai_absensi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="nilai_tugas" class="block text-sm font-medium text-gray-700">Nilai Tugas (0-100) <span class="text-red-500">*</span></label>
                        <input type="number" name="nilai_tugas" id="nilai_tugas" value="{{ old('nilai_tugas') }}" required min="0" max="100" step="1" class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg">
                        @error('nilai_tugas')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nilai_laporan" class="block text-sm font-medium text-gray-700">Nilai Laporan (0-100) <span class="text-red-500">*</span></label>
                        <input type="number" name="nilai_laporan" id="nilai_laporan" value="{{ old('nilai_laporan') }}" required min="0" max="100" step="1" class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg">
                        @error('nilai_laporan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="nilai_sikap" class="block text-sm font-medium text-gray-700">Nilai Sikap (0-100) <span class="text-red-500">*</span></label>
                        <input type="number" name="nilai_sikap" id="nilai_sikap" value="{{ old('nilai_sikap') }}" required min="0" max="100" step="1" class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg">
                        @error('nilai_sikap')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan</label>
                        <textarea name="catatan" id="catatan" rows="4" class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg">{{ old('catatan') }}</textarea>
                        @error('catatan')
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
