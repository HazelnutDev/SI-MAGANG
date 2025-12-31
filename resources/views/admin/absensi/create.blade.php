@extends('layouts.app')

@section('title', 'Tambah Absensi')
@section('header', 'Tambah Data Absensi')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-medium text-gray-900">Form Tambah Absensi</h3>
                <a href="{{ route('admin.absensi.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 flex items-center transition-colors duration-200">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>

            <form action="{{ route('admin.absensi.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="user_id" class="block text-sm font-medium text-gray-700">Mahasiswa <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <select name="user_id" id="user_id" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition duration-200">
                                <option value="">Pilih Mahasiswa</option>
                                @foreach($mahasiswa as $m)
                                    <option value="{{ $m->id }}" {{ old('user_id') == $m->id ? 'selected' : '' }}>{{ $m->name }} ({{ $m->nim }})</option>
                                @endforeach
                            </select>
                        </div>
                        @error('user_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition duration-200">
                        </div>
                        @error('tanggal')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <select name="status" id="status" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition duration-200">
                                <option value="hadir" {{ old('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="izin" {{ old('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                                <option value="sakit" {{ old('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                <option value="alpha" {{ old('status') == 'alpha' ? 'selected' : '' }}>Alpha</option>
                            </select>
                        </div>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jam_masuk" class="block text-sm font-medium text-gray-700">Jam Masuk</label>
                        <div class="mt-1">
                            <input type="time" name="jam_masuk" id="jam_masuk" value="{{ old('jam_masuk') }}"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition duration-200">
                        </div>
                        @error('jam_masuk')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jam_keluar" class="block text-sm font-medium text-gray-700">Jam Keluar</label>
                        <div class="mt-1">
                            <input type="time" name="jam_keluar" id="jam_keluar" value="{{ old('jam_keluar') }}"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition duration-200">
                        </div>
                        @error('jam_keluar')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                        <div class="mt-1">
                            <textarea name="keterangan" id="keterangan" rows="3"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition duration-200" placeholder="Tambahkan keterangan jika perlu">{{ old('keterangan') }}</textarea>
                        </div>
                        @error('keterangan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-5 border-t border-gray-200">
                    <div class="flex justify-end">
                        <a href="{{ route('admin.absensi.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                            Batal
                        </a>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200 transform hover:-translate-y-0.5">
                            Simpan Data
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
