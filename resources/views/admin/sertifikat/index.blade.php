@extends('layouts.app')

@section('title', 'Sertifikat')
@section('header', 'Sertifikat Mahasiswa')

@section('content')
<div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden mb-6">
    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
        <form action="{{ route('admin.sertifikat.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
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
                <label for="tanggal_mulai" class="block text-xs font-medium text-gray-700 mb-1">Dari Tanggal Terbit</label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ request('tanggal_mulai') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm">
            </div>
            <div>
                <label for="tanggal_selesai" class="block text-xs font-medium text-gray-700 mb-1">Sampai Tanggal Terbit</label>
                <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ request('tanggal_selesai') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm">
            </div>
            <div class="lg:col-span-1 flex items-end justify-end space-x-2">
                <a href="{{ route('admin.sertifikat.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">Reset</a>
                <button type="submit" class="px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="flex-1 w-full sm:w-auto">
            <form action="{{ route('admin.sertifikat.index') }}" method="GET" class="relative group">
                @if(request('user_id')) <input type="hidden" name="user_id" value="{{ request('user_id') }}"> @endif
                @if(request('tanggal_mulai')) <input type="hidden" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}"> @endif
                @if(request('tanggal_selesai')) <input type="hidden" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}"> @endif
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor sertifikat atau nama..." 
                       class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 group-hover:border-indigo-300">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 group-hover:text-indigo-500 transition duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </form>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.sertifikat.export') }}" class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-xl shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                Export
            </a>
            <a href="{{ route('admin.sertifikat.create') }}" class="inline-flex items-center px-4 py-2.5 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition transform hover:-translate-y-0.5">
                Buat Sertifikat
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nomor Sertifikat</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Mahasiswa</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal Terbit</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($sertifikat as $row)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $row->nomor_sertifikat }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $row->user->name }}</div>
                        <div class="text-xs text-gray-500">{{ $row->user->nim }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($row->tanggal_terbit)->format('d F Y') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('admin.sertifikat.show', $row->id) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                            <a href="{{ route('admin.sertifikat.edit', $row->id) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                            <form action="{{ route('admin.sertifikat.destroy', $row->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus sertifikat ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center">
                        <p class="text-gray-500 text-lg font-medium">Belum ada data sertifikat.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($sertifikat->hasPages())
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $sertifikat->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection
