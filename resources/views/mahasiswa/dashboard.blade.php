@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')
@section('header', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Banner Selamat Datang -->
    <div class="accent-banner overflow-hidden relative">
        <div class="px-6 py-8 sm:p-10 text-white flex flex-col md:flex-row items-center justify-between relative z-10">
            <div class="mb-6 md:mb-0 text-center md:text-left">
                <h2 class="text-3xl font-bold tracking-tight drop-shadow-sm">Selamat Datang, {{ Auth::user()->name }}! 👋</h2>
                <p class="mt-2 text-indigo-50 text-lg">Semangat menjalani aktivitas magang hari ini. Jangan lupa absen ya!</p>
                
                <!-- Tombol Absensi -->
                <div class="mt-8 flex flex-wrap gap-4 justify-center md:justify-start">
                    @if($canAbsenMasuk)
                        <form action="{{ route('mahasiswa.absensi.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="masuk">
                            <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-bold rounded-xl text-indigo-700 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-4 focus:ring-indigo-500/30 transition-all shadow-lg transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                                Absen Masuk
                            </button>
                        </form>
                    @elseif($canAbsenKeluar)
                        <form action="{{ route('mahasiswa.absensi.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="keluar">
                            <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-bold rounded-xl text-white bg-rose-500 hover:bg-rose-600 focus:outline-none focus:ring-4 focus:ring-rose-500/30 transition-all shadow-lg transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Absen Keluar
                            </button>
                        </form>
                    @else
                        <button disabled class="inline-flex items-center px-6 py-3 border border-indigo-400/30 text-sm font-bold rounded-xl text-indigo-200 bg-indigo-900/40 cursor-not-allowed backdrop-blur-sm">
                            @if($absensiHariIni && $absensiHariIni->jam_keluar)
                                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Sudah Selesai Absen
                            @elseif($absensiHariIni)
                                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Belum Waktunya Pulang
                            @else
                                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Belum Waktunya Absen
                            @endif
                        </button>
                    @endif
                </div>
            </div>
            
            <!-- Ilustrasi/Grafis -->
            <div class="hidden md:block">
                <div class="p-4 bg-white/15 rounded-2xl backdrop-blur-md border border-white/20 shadow-inner">
                    <div class="text-center">
                        <p class="text-xs text-indigo-200 uppercase tracking-wider font-bold mb-1">Waktu Sekarang</p>
                        <p class="text-3xl font-mono font-bold">{{ now()->format('H:i') }}</p>
                        <p class="text-sm text-indigo-100">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pola Dekoratif Background -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 rounded-full bg-indigo-500/20 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-purple-500/20 blur-3xl"></div>
    </div>

    <!-- Ringkasan Statistik -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Kartu Total Kehadiran -->
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-50 rounded-lg p-3 text-indigo-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Kehadiran</dt>
                            <dd class="flex items-baseline gap-1 mt-1">
                                <span class="text-2xl font-bold text-gray-900">{{ $absensiHadir }}</span>
                                <span class="text-sm text-gray-400">/ {{ $totalAbsensi }} hari</span>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu Tugas Selesai -->
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-emerald-50 rounded-lg p-3 text-emerald-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Tugas Selesai</dt>
                            <dd class="flex items-baseline gap-1 mt-1">
                                <span class="text-2xl font-bold text-gray-900">{{ $tugasSelesai }}</span>
                                <span class="text-sm text-gray-400">/ {{ $totalTugas }} tugas</span>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Tabel Tugas Terbaru -->
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 flex flex-col h-full">
            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 rounded-t-xl">
                <h3 class="text-lg font-bold text-gray-800">Tugas Terbaru</h3>
                <a href="{{ route('mahasiswa.tugas.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-semibold transition-colors">Lihat Semua</a>
            </div>
            <div class="flex-1 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Judul</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Deadline</th>
                            <th class="px-6 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($tugasTerbaru as $tugas)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">{{ $tugas->tugas->judul_tugas }}</div>
                                <div class="text-xs text-gray-500 truncate max-w-xs mt-0.5">{{ Str::limit($tugas->tugas->deskripsi, 40) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ \Carbon\Carbon::parse($tugas->tugas->tanggal_selesai)->format('d M Y') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('mahasiswa.tugas.show', $tugas->id) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-full text-xs font-bold transition-colors">
                                    Detail
                                    <svg class="w-3 h-3 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-sm text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-200 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="font-medium">Tidak ada tugas baru</p>
                                    <p class="text-xs text-gray-400 mt-1">Semua tugas sudah diselesaikan!</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabel Riwayat Absensi -->
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 flex flex-col h-full">
            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 rounded-t-xl">
                <h3 class="text-lg font-bold text-gray-800">Riwayat Absensi</h3>
                <a href="{{ route('mahasiswa.absensi.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-semibold transition-colors">Lihat Semua</a>
            </div>
            <div class="flex-1 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Waktu</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($absensiTerbaru as $absen)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                {{ \Carbon\Carbon::parse($absen->tanggal)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex flex-col text-xs">
                                    <span class="flex items-center gap-1">
                                        <span class="w-12 text-gray-400">Masuk:</span>
                                        <span class="font-mono text-gray-700">{{ $absen->jam_masuk ? \Carbon\Carbon::parse($absen->jam_masuk)->format('H:i') : '-' }}</span>
                                    </span>
                                    <span class="flex items-center gap-1 mt-1">
                                        <span class="w-12 text-gray-400">Keluar:</span>
                                        <span class="font-mono text-gray-700">{{ $absen->jam_keluar ? \Carbon\Carbon::parse($absen->jam_keluar)->format('H:i') : '-' }}</span>
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-bold rounded-full 
                                    {{ $absen->status == 'hadir' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 
                                       ($absen->status == 'izin' ? 'bg-amber-100 text-amber-700 border border-amber-200' : 
                                       ($absen->status == 'sakit' ? 'bg-blue-100 text-blue-700 border border-blue-200' : 'bg-rose-100 text-rose-700 border border-rose-200')) }}">
                                    {{ ucfirst($absen->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-sm text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-200 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p>Belum ada data absensi</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
