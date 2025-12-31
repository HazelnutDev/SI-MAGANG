@extends('layouts.app')

@section('title', 'Detail Absensi')
@section('header', 'Detail Absensi Mahasiswa')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-16 w-16">
                        @if($absensi->user->foto_profil)
                            <img class="h-16 w-16 rounded-full object-cover ring-4 ring-indigo-50" src="{{ asset('storage/' . $absensi->user->foto_profil) }}" alt="{{ $absensi->user->name }}">
                        @else
                            <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-2xl ring-4 ring-indigo-50">
                                {{ substr($absensi->user->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-gray-900">{{ $absensi->user->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $absensi->user->nim }}</p>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.absensi.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>
                    <a href="{{ route('admin.absensi.edit', $absensi->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </a>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Tanggal</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-medium">{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d F Y') }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            @php
                                $statusClasses = [
                                    'hadir' => 'bg-green-100 text-green-800',
                                    'izin' => 'bg-yellow-100 text-yellow-800',
                                    'sakit' => 'bg-blue-100 text-blue-800',
                                    'alpha' => 'bg-red-100 text-red-800',
                                ];
                            @endphp
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $statusClasses[$absensi->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($absensi->status) }}
                            </span>
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Jam Masuk</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $absensi->jam_masuk ? \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i') . ' WIB' : '-' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Jam Keluar</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $absensi->jam_keluar ? \Carbon\Carbon::parse($absensi->jam_keluar)->format('H:i') . ' WIB' : '-' }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Keterangan</dt>
                        <dd class="mt-1 text-sm text-gray-900 bg-gray-50 p-4 rounded-lg border border-gray-200">
                            {{ $absensi->keterangan ?: 'Tidak ada keterangan' }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
