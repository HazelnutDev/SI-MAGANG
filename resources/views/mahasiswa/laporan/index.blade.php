@extends('layouts.app')

@section('title', 'Laporan Akhir')
@section('header', 'Laporan Akhir')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8">
            @if($laporan)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-semibold text-gray-500">Judul</p>
                        <p class="mt-1 text-sm font-bold text-gray-900">{{ $laporan->judul }}</p>
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
                        <p class="text-xs font-semibold text-gray-500">Ringkasan</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $laporan->ringkasan ?? '-' }}</p>
                    </div>
                </div>
                <div class="mt-6">
                    @if($laporan->file_laporan)
                        <a href="{{ asset('storage/'.$laporan->file_laporan) }}" target="_blank" class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50">Lihat File</a>
                    @endif
                    @if($laporan->status !== 'approved')
                        <a href="{{ route('mahasiswa.laporan.create') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 ml-2">Unggah Ulang</a>
                    @endif
                </div>
            @else
                <div class="text-center">
                    <p class="text-gray-600">Belum ada laporan yang diunggah.</p>
                    <a href="{{ route('mahasiswa.laporan.create') }}" class="mt-4 inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700">Buat Laporan</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

