@extends('layouts.app')

@section('title', 'Buat Laporan Akhir')
@section('header', 'Buat Laporan Akhir')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8">
            <form action="{{ route('mahasiswa.laporan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
                    <input id="judul" name="judul" type="text" required class="mt-1 block w-full border-gray-300 rounded-lg" value="{{ old('judul') }}">
                    @error('judul')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="ringkasan" class="block text-sm font-medium text-gray-700">Ringkasan</label>
                    <textarea id="ringkasan" name="ringkasan" rows="4" class="mt-1 block w-full border-gray-300 rounded-lg">{{ old('ringkasan') }}</textarea>
                    @error('ringkasan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="file_laporan" class="block text-sm font-medium text-gray-700">File Laporan (PDF)</label>
                    <input id="file_laporan" name="file_laporan" type="file" accept="application/pdf" required class="mt-1 block w-full text-sm">
                    @error('file_laporan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="inline-flex justify-center py-2.5 px-6 rounded-xl text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

