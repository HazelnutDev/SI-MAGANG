@extends('layouts.app')

@section('title', 'Sertifikat')
@section('header', 'Sertifikat')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8">
            @if($sertifikat)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-semibold text-gray-500">Nomor Sertifikat</p>
                        <p class="mt-1 text-sm font-bold text-gray-900">{{ $sertifikat->nomor_sertifikat }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500">Tanggal Terbit</p>
                        <p class="mt-1 text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($sertifikat->tanggal_terbit)->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500">Instansi</p>
                        <p class="mt-1 text-sm font-bold text-gray-900">{{ $sertifikat->nama_instansi ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500">Lokasi</p>
                        <p class="mt-1 text-sm font-bold text-gray-900">{{ $sertifikat->lokasi_instansi ?? '-' }}</p>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('mahasiswa.sertifikat.download', $sertifikat->id) }}" class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700">Download PDF</a>
                </div>
            @else
                <p class="text-gray-600">Sertifikat belum tersedia.</p>
            @endif
        </div>
    </div>
</div>
@endsection

