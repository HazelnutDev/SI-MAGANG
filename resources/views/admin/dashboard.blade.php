@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('header', 'Dashboard Overview')

@section('content')
<div class="space-y-6">
    <!-- Grid Statistik Utama -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Kartu Total Mahasiswa -->
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-500 rounded-lg p-3 shadow-lg shadow-indigo-500/30">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Mahasiswa</dt>
                            <dd class="text-2xl font-bold text-gray-900 mt-1">{{ $totalMahasiswa }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu Total Absensi -->
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-emerald-500 rounded-lg p-3 shadow-lg shadow-emerald-500/30">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Absensi</dt>
                            <dd class="text-2xl font-bold text-gray-900 mt-1">{{ $totalAbsensi }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu Total Tugas -->
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-amber-500 rounded-lg p-3 shadow-lg shadow-amber-500/30">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Tugas</dt>
                            <dd class="text-2xl font-bold text-gray-900 mt-1">{{ $totalTugas }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu Laporan Pending -->
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-rose-500 rounded-lg p-3 shadow-lg shadow-rose-500/30">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Laporan Pending</dt>
                            <dd class="text-2xl font-bold text-gray-900 mt-1">{{ $laporanPending }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Sekunder -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Statistik Absensi Hari Ini -->
        <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 h-24 w-24 bg-indigo-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <h3 class="text-lg font-semibold text-gray-800 relative z-10">Absensi Hari Ini</h3>
            <div class="mt-4 flex items-baseline relative z-10">
                <p class="text-4xl font-bold text-indigo-600">{{ $absensiHariIni }}</p>
                <p class="ml-2 text-sm font-medium text-gray-500">mahasiswa hadir</p>
            </div>
        </div>
        
        <!-- Statistik Tugas Aktif -->
        <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 h-24 w-24 bg-amber-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <h3 class="text-lg font-semibold text-gray-800 relative z-10">Tugas Aktif</h3>
            <div class="mt-4 flex items-baseline relative z-10">
                <p class="text-4xl font-bold text-amber-500">{{ $tugasAktif }}</p>
                <p class="ml-2 text-sm font-medium text-gray-500">tugas berjalan</p>
            </div>
        </div>

        <!-- Statistik Sertifikat -->
        <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 h-24 w-24 bg-emerald-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <h3 class="text-lg font-semibold text-gray-800 relative z-10">Total Sertifikat</h3>
            <div class="mt-4 flex items-baseline relative z-10">
                <p class="text-4xl font-bold text-emerald-600">{{ $totalSertifikat }}</p>
                <p class="ml-2 text-sm font-medium text-gray-500">diterbitkan</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Tabel Mahasiswa Terbaru -->
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 flex flex-col">
            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 rounded-t-xl">
                <h3 class="text-lg font-bold text-gray-800">Mahasiswa Terbaru</h3>
                <a href="{{ route('admin.users.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-semibold transition-colors">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto flex-1">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3.5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3.5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">NIM</th>
                            <th class="px-6 py-3.5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($mahasiswaTerbaru as $mhs)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full object-cover ring-2 ring-indigo-50" src="{{ asset('storage/' . $mhs->foto_profil) }}" alt="Foto {{ $mhs->name }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900">{{ $mhs->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-mono">{{ $mhs->nim }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $mhs->email }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-sm text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    <p>Belum ada data mahasiswa</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabel Tugas Terbaru -->
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 flex flex-col">
            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 rounded-t-xl">
                <h3 class="text-lg font-bold text-gray-800">Tugas Terbaru</h3>
                <a href="#" class="text-sm text-indigo-600 hover:text-indigo-800 font-semibold transition-colors">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto flex-1">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Judul</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Deadline</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($tugasTerbaru as $tugas)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $tugas->judul_tugas }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ \Carbon\Carbon::parse($tugas->tanggal_selesai)->format('d M Y') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ $tugas->status == 'active' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-gray-100 text-gray-600 border border-gray-200' }}">
                                    {{ ucfirst($tugas->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-sm text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                    </svg>
                                    <p>Belum ada data tugas</p>
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
