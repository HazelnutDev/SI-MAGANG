@extends('layouts.app')

@section('title', 'Detail Indeks Nilai')
@section('header', 'Detail Indeks Nilai')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-medium text-gray-900">Informasi Indeks Nilai</h3>
                <a href="{{ route('admin.nilai.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 flex items-center transition-colors duration-200">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="sm:col-span-2">
                    <p class="text-xs font-semibold text-gray-500">Mahasiswa</p>
                    <p class="mt-1 text-sm font-bold text-gray-900">{{ $nilai->user->name }} <span class="text-gray-500 font-medium">({{ $nilai->user->nim }})</span></p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-gray-500">Nilai Absensi</p>
                    <p class="mt-1 text-sm font-bold text-gray-900">{{ $nilai->nilai_absensi }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500">Nilai Tugas</p>
                    <p class="mt-1 text-sm font-bold text-gray-900">{{ $nilai->nilai_tugas }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500">Nilai Laporan</p>
                    <p class="mt-1 text-sm font-bold text-gray-900">{{ $nilai->nilai_laporan }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500">Nilai Sikap</p>
                    <p class="mt-1 text-sm font-bold text-gray-900">{{ $nilai->nilai_sikap }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-gray-500">Nilai Akhir</p>
                    <p class="mt-1 text-sm font-bold text-gray-900">{{ $nilai->nilai_akhir }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500">Grade</p>
                    <p class="mt-1 text-sm font-bold text-gray-900">{{ $nilai->grade }}</p>
                </div>

                <div class="sm:col-span-2">
                    <p class="text-xs font-semibold text-gray-500">Catatan</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $nilai->catatan ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
