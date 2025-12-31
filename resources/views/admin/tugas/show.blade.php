@extends('layouts.app')

@section('title', 'Detail Tugas')
@section('header', 'Detail Tugas Kegiatan')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden mb-6">
        <div class="p-6 sm:p-8">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">{{ $tugas->judul_tugas }}</h3>
                    <p class="mt-1 text-sm text-gray-500">{{ \Illuminate\Support\Str::limit($tugas->deskripsi, 160) }}</p>
                </div>
                @php
                    $statusClasses = [
                        'active' => 'bg-green-100 text-green-800',
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'completed' => 'bg-blue-100 text-blue-800',
                    ];
                @endphp
                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $statusClasses[$tugas->status] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ ucfirst($tugas->status) }}
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <div class="text-xs font-semibold text-gray-500 uppercase">Tanggal Mulai</div>
                    <div class="mt-1 text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($tugas->tanggal_mulai)->format('d F Y') }}</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <div class="text-xs font-semibold text-gray-500 uppercase">Tanggal Selesai</div>
                    <div class="mt-1 text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($tugas->tanggal_selesai)->format('d F Y') }}</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <div class="text-xs font-semibold text-gray-500 uppercase">Durasi</div>
                    <div class="mt-1 text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($tugas->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($tugas->tanggal_selesai)) }} hari</div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Mahasiswa Ditugaskan</h3>
                <a href="{{ route('admin.tugas.edit', $tugas->id) }}" class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition">
                    Edit Tugas
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Mahasiswa</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($tugas->tugasMahasiswa as $tm)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($tm->user->foto_profil)
                                            <img class="h-10 w-10 rounded-full object-cover ring-2 ring-indigo-50" src="{{ asset('storage/' . $tm->user->foto_profil) }}" alt="{{ $tm->user->name }}">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold ring-2 ring-indigo-50">
                                                {{ substr($tm->user->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $tm->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $tm->user->nim }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                    {{ ucfirst($tm->kategori) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $pengerjaanClasses = [
                                        'belum_mulai' => 'bg-gray-100 text-gray-800',
                                        'proses' => 'bg-yellow-100 text-yellow-800',
                                        'selesai' => 'bg-green-100 text-green-800',
                                    ];
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $pengerjaanClasses[$tm->status_pengerjaan] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucwords(str_replace('_',' ',$tm->status_pengerjaan)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <a href="{{ route('admin.users.show', $tm->user->id) }}" class="text-indigo-600 hover:text-indigo-900">Lihat Profil</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <p class="text-gray-500 text-lg font-medium">Belum ada mahasiswa ditugaskan.</p>
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
