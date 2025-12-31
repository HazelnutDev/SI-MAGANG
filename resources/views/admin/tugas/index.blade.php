@extends('layouts.app')

@section('title', 'Data Tugas')
@section('header', 'Data Tugas Kegiatan')

@section('content')
<div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden mb-6">
    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
        <form action="{{ route('admin.tugas.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label for="tanggal_mulai" class="block text-xs font-medium text-gray-700 mb-1">Dari Tanggal</label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ request('tanggal_mulai') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm">
            </div>
            <div>
                <label for="tanggal_selesai" class="block text-xs font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ request('tanggal_selesai') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm">
            </div>
            <div>
                <label for="status" class="block text-xs font-medium text-gray-700 mb-1">Status Tugas</label>
                <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="">Semua Status</option>
                    @foreach($statusOptions as $key => $value)
                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <div class="flex space-x-2 w-full">
                    <a href="{{ route('admin.tugas.index') }}" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200 text-center">
                        Reset
                    </a>
                    <button type="submit" class="flex-1 px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                        Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="flex-1 w-full sm:w-auto">
            <form action="{{ route('admin.tugas.index') }}" method="GET" class="relative group">
                @if(request('tanggal_mulai')) <input type="hidden" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}"> @endif
                @if(request('tanggal_selesai')) <input type="hidden" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}"> @endif
                @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif

                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul tugas..." 
                       class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 group-hover:border-indigo-300">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 group-hover:text-indigo-500 transition duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </form>
        </div>
        <div>
            <a href="{{ route('admin.tugas.create') }}" class="inline-flex items-center px-4 py-2.5 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200 transform hover:-translate-y-0.5">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Tugas Baru
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                        Judul Tugas
                    </th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                        Periode
                    </th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                        Mahasiswa
                    </th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($tugas as $item)
                <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $item->judul_tugas }}</div>
                        <div class="text-sm text-gray-500 line-clamp-1">{{ \Illuminate\Support\Str::limit($item->deskripsi, 50) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                        </div>
                        <div class="text-xs text-gray-500">
                            {{ \Carbon\Carbon::parse($item->tanggal_selesai)->diffForHumans() }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex -space-x-2 overflow-hidden">
                            @foreach($item->tugasMahasiswa->take(3) as $tm)
                                @if($tm->user->foto_profil)
                                    <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="{{ asset('storage/' . $tm->user->foto_profil) }}" alt="{{ $tm->user->name }}" title="{{ $tm->user->name }}">
                                @else
                                    <div class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 ring-2 ring-white text-xs font-bold text-indigo-600" title="{{ $tm->user->name }}">
                                        {{ substr($tm->user->name, 0, 1) }}
                                    </div>
                                @endif
                            @endforeach
                            @if($item->tugas_mahasiswa_count > 3)
                                <div class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 ring-2 ring-white text-xs font-medium text-gray-500">
                                    +{{ $item->tugas_mahasiswa_count - 3 }}
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $statusClasses = [
                                'active' => 'bg-green-100 text-green-800',
                                'pending' => 'bg-amber-100 text-amber-800',
                                'completed' => 'bg-violet-100 text-violet-800',
                            ];
                        @endphp
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClasses[$item->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('admin.tugas.show', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 p-1.5 rounded-lg transition-colors duration-200" title="Detail">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <a href="{{ route('admin.tugas.edit', $item->id) }}" class="text-yellow-600 hover:text-yellow-900 bg-yellow-50 hover:bg-yellow-100 p-1.5 rounded-lg transition-colors duration-200" title="Edit">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('admin.tugas.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-1.5 rounded-lg transition-colors duration-200" title="Hapus">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="h-12 w-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <p class="text-gray-500 text-lg font-medium">Tidak ada data tugas ditemukan.</p>
                            <p class="text-gray-400 text-sm mt-1">Coba sesuaikan filter pencarian atau buat tugas baru.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($tugas->hasPages())
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $tugas->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection
