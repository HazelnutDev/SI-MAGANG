@extends('layouts.app')

@section('title', 'Edit Laporan Akhir')
@section('header', 'Edit Laporan Akhir')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-medium text-gray-900">Form Edit Laporan Akhir</h3>
                <a href="{{ route('admin.laporan.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 flex items-center transition-colors duration-200">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>

            <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="sm:col-span-2">
                    <p class="text-xs font-semibold text-gray-500">Mahasiswa</p>
                    <p class="mt-1 text-sm font-bold text-gray-900">{{ $laporan->user->name }} <span class="text-gray-500 font-medium">({{ $laporan->user->nim }})</span></p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500">Judul</p>
                    <p class="mt-1 text-sm font-bold text-gray-900">{{ $laporan->judul }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500">Tanggal Submit</p>
                    <p class="mt-1 text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($laporan->tanggal_submit)->format('d F Y') }}</p>
                </div>
            </div>

            <form action="{{ route('admin.laporan.update', $laporan->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                        <select name="status" id="status" class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg">
                            <option value="pending" {{ old('status', $laporan->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="revisi" {{ old('status', $laporan->status) == 'revisi' ? 'selected' : '' }}>Revisi</option>
                            <option value="approved" {{ old('status', $laporan->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="catatan_revisi" class="block text-sm font-medium text-gray-700">Catatan Revisi</label>
                        <input type="text" name="catatan_revisi" id="catatan_revisi" value="{{ old('catatan_revisi', $laporan->catatan_revisi) }}" class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg">
                        @error('catatan_revisi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="inline-flex justify-center py-2.5 px-6 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:-translate-y-0.5">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
