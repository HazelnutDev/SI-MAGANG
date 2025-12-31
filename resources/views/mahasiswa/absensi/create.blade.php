@extends('layouts.app')

@section('title', 'Form Absensi')
@section('header', 'Form Absensi')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8">
            <form action="{{ route('mahasiswa.absensi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                @if(!$today)
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-lg">
                            <option value="hadir">Hadir</option>
                            <option value="izin">Izin</option>
                            <option value="sakit">Sakit</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                        <input id="keterangan" name="keterangan" type="text" class="mt-1 block w-full border-gray-300 rounded-lg" value="{{ old('keterangan') }}">
                        @error('keterangan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="foto_masuk" class="block text-sm font-medium text-gray-700">Foto Masuk</label>
                        <input id="foto_masuk" name="foto_masuk" type="file" accept="image/*" class="mt-1 block w-full text-sm">
                        @error('foto_masuk')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @else
                    <div>
                        <p class="text-sm text-gray-600">Absen masuk: {{ $today->jam_masuk }}</p>
                    </div>

                    <div>
                        <label for="foto_keluar" class="block text-sm font-medium text-gray-700">Foto Keluar</label>
                        <input id="foto_keluar" name="foto_keluar" type="file" accept="image/*" class="mt-1 block w-full text-sm">
                        @error('foto_keluar')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="inline-flex justify-center py-2.5 px-6 rounded-xl text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

