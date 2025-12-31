@extends('layouts.app')

@section('title', 'Indeks Nilai')
@section('header', 'Indeks Nilai Mahasiswa')

@section('content')
<div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden mb-6">
    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
        <form action="{{ route('admin.nilai.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label for="user_id" class="block text-xs font-medium text-gray-700 mb-1">Mahasiswa</label>
                <select name="user_id" id="user_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="">Semua Mahasiswa</option>
                    @foreach($mahasiswa as $m)
                        <option value="{{ $m->id }}" {{ request('user_id') == $m->id ? 'selected' : '' }}>{{ $m->name }} ({{ $m->nim }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="grade" class="block text-xs font-medium text-gray-700 mb-1">Grade</label>
                <select name="grade" id="grade" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="">Semua Grade</option>
                    @foreach($gradeOptions as $key => $label)
                        <option value="{{ $key }}" {{ request('grade') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="lg:col-span-2 flex items-end justify-end space-x-2">
                <a href="{{ route('admin.nilai.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">Reset</a>
                <button type="submit" class="px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="flex-1 w-full sm:w-auto">
            <form action="{{ route('admin.nilai.index') }}" method="GET" class="relative group">
                @if(request('user_id')) <input type="hidden" name="user_id" value="{{ request('user_id') }}"> @endif
                @if(request('grade')) <input type="hidden" name="grade" value="{{ request('grade') }}"> @endif
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIM..." 
                       class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 group-hover:border-indigo-300">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 group-hover:text-indigo-500 transition duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </form>
        </div>
        <div>
            <a href="{{ route('admin.nilai.create') }}" class="inline-flex items-center px-4 py-2.5 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200 transform hover:-translate-y-0.5">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Indeks Nilai
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Mahasiswa</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Komponen Nilai</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nilai Akhir</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Grade</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($nilai as $row)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $row->user->name }}</div>
                        <div class="text-xs text-gray-500">{{ $row->user->nim }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div class="bg-gray-50 rounded-md p-2 border border-gray-200">Absensi: <span class="font-semibold">{{ $row->nilai_absensi }}</span></div>
                            <div class="bg-gray-50 rounded-md p-2 border border-gray-200">Tugas: <span class="font-semibold">{{ $row->nilai_tugas }}</span></div>
                            <div class="bg-gray-50 rounded-md p-2 border border-gray-200">Laporan: <span class="font-semibold">{{ $row->nilai_laporan }}</span></div>
                            <div class="bg-gray-50 rounded-md p-2 border border-gray-200">Sikap: <span class="font-semibold">{{ $row->nilai_sikap }}</span></div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-gray-900">{{ number_format($row->nilai_akhir, 2) }}</div>
                        <div class="text-xs text-gray-500">Terhitung otomatis</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $gradeClasses = [
                                'A' => 'bg-green-100 text-green-800',
                                'B' => 'bg-blue-100 text-blue-800',
                                'C' => 'bg-yellow-100 text-yellow-800',
                                'D' => 'bg-orange-100 text-orange-800',
                                'E' => 'bg-red-100 text-red-800',
                            ];
                        @endphp
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $gradeClasses[$row->grade] ?? 'bg-gray-100 text-gray-800' }}">{{ $row->grade }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('admin.nilai.show', $row->id) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                            <a href="{{ route('admin.nilai.edit', $row->id) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                            <form action="{{ route('admin.nilai.destroy', $row->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus indeks nilai ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <p class="text-gray-500 text-lg font-medium">Belum ada data indeks nilai.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($nilai->hasPages())
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $nilai->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection
