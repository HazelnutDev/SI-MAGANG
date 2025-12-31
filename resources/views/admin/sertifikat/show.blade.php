@extends('layouts.app')

@section('title', 'Detail Sertifikat')
@section('header', 'Detail Sertifikat')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-medium text-gray-900">Informasi Sertifikat</h3>
                <a href="{{ route('admin.sertifikat.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 flex items-center transition-colors duration-200">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <p class="text-xs font-semibold text-gray-500">Nomor Sertifikat</p>
                    <p class="mt-1 text-sm font-bold text-gray-900">{{ $sertifikat->nomor_sertifikat }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500">Mahasiswa</p>
                    <p class="mt-1 text-sm font-bold text-gray-900">{{ $sertifikat->user->name }} <span class="text-gray-500 font-medium">({{ $sertifikat->user->nim }})</span></p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500">Tanggal Terbit</p>
                    <p class="mt-1 text-sm font-bold text-gray-900">{{ Carbon\Carbon::parse($sertifikat->tanggal_terbit)->format('d F Y') }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500">Periode Magang</p>
                    <p class="mt-1 text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($sertifikat->tanggal_mulai_magang)->format('d F Y') }} - {{ \Carbon\Carbon::parse($sertifikat->tanggal_selesai_magang)->format('d F Y') }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500">Nama Instansi</p>
                    <p class="mt-1 text-sm font-bold text-gray-900">{{ $sertifikat->nama_instansi ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500">Lokasi Instansi</p>
                    <p class="mt-1 text-sm font-bold text-gray-900">{{ $sertifikat->lokasi_instansi ?? '-' }}</p>
                </div>
                <div class="sm:col-span-2">
                    <p class="text-xs font-semibold text-gray-500">Kepala Dinas</p>
                    <p class="mt-1 text-sm font-bold text-gray-900">{{ $sertifikat->kepala_dinas ?? '-' }}</p>
                </div>
            </div>

            @if($sertifikat->file_sertifikat)
                <div class="mt-8">
                    <a href="{{ asset('storage/'.$sertifikat->file_sertifikat) }}" target="_blank" class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-xl shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        Lihat File Sertifikat
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
