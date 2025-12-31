@extends('layouts.app')

@section('title', 'Detail Laporan Akhir')
@section('header', 'Detail Laporan Akhir')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-medium text-gray-900">Informasi Laporan Akhir</h3>
                <a href="{{ route('admin.laporan.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 flex items-center transition-colors duration-200">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="sm:col-span-2">
                    <p class="text-xs font-semibold text-gray-500">Mahasiswa</p>
                    <p class="mt-1 text-sm font-bold text-gray-900">{{ $laporan->user->name }} <span class="text-gray-500 font-medium">({{ $laporan->user->nim }})</span></p>
                </div>
                <div class="sm:col-span-2">
                    <p class="text-xs font-semibold text-gray-500">Judul</p>
                    <p class="mt-1 text-sm font-bold text-gray-900">{{ $laporan->judul }}</p>
                </div>
                <div class="sm:col-span-2">
                    <p class="text-xs font-semibold text-gray-500">Ringkasan</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $laporan->ringkasan ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500">Tanggal Submit</p>
                    <p class="mt-1 text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($laporan->tanggal_submit)->format('d F Y') }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500">Status</p>
                    <p class="mt-1 text-sm font-bold text-gray-900">{{ ucfirst($laporan->status) }}</p>
                </div>
                <div class="sm:col-span-2">
                    <p class="text-xs font-semibold text-gray-500">Catatan Revisi</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $laporan->catatan_revisi ?? '-' }}</p>
                </div>
            </div>

            @if($laporan->file_laporan)
                <div class="mt-8 flex gap-2">
                    <a href="{{ asset('storage/'.$laporan->file_laporan) }}" target="_blank" class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-xl shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">Lihat File</a>
                    <a href="{{ route('admin.laporan.download', $laporan->id) }}" class="inline-flex items-center px-4 py-2.5 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">Download</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
