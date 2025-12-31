@extends('layouts.app')

@section('title', 'Absensi')
@section('header', 'Absensi Saya')

@section('content')
<div class="space-y-6">
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6 flex flex-col sm:flex-row justify-between items-center gap-4 border-b border-gray-100 bg-gray-50/50">
            <div>
                <p class="text-sm text-gray-600">Status hari ini:</p>
                <p class="text-lg font-bold text-gray-900">
                    @if($absensiHariIni)
                        @if($absensiHariIni->jam_keluar)
                            Selesai
                        @else
                            Masuk: {{ $absensiHariIni->jam_masuk }}
                        @endif
                    @else
                        Belum absen
                    @endif
                </p>
            </div>
            <div class="flex items-center gap-3">
                @if($canAbsenMasuk || $canAbsenKeluar)
                    <a href="{{ route('mahasiswa.absensi.create') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700">Absen</a>
                @else
                    <button class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-bold text-white bg-gray-400 cursor-not-allowed" disabled>Absen tidak tersedia</button>
                @endif
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Masuk</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Keluar</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($absensi as $row)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($row->tanggal)->format('d F Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $row->jam_masuk ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $row->jam_keluar ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($row->status) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <p class="text-gray-500 text-lg font-medium">Belum ada data absensi.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($absensi->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $absensi->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

