@extends('layouts.app')

@section('title', 'Detail Tugas')
@section('header', 'Detail Tugas')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold text-gray-900">{{ $tugasMahasiswa->tugas->judul_tugas }}</h3>
                <p class="text-xs text-gray-500 mt-1">Deadline: {{ \Carbon\Carbon::parse($tugasMahasiswa->tugas->tanggal_selesai)->format('d M Y') }}</p>
            </div>
            <div class="flex items-center gap-2">
                @php
                    $taskClasses = [
                        'pending' => 'bg-amber-100 text-amber-800',
                        'active' => 'bg-green-100 text-green-800',
                        'completed' => 'bg-violet-100 text-violet-800',
                    ];
                @endphp
                <span class="px-2.5 py-0.5 inline-flex text-xs font-bold rounded-full {{ $taskClasses[$tugasMahasiswa->tugas->status] ?? 'bg-gray-100 text-gray-800' }}">{{ ucfirst($tugasMahasiswa->tugas->status) }}</span>
            </div>
        </div>
        <div class="p-6 sm:p-8">
            <div class="mb-6">
                <p class="text-sm text-gray-700">{{ $tugasMahasiswa->tugas->deskripsi }}</p>
            </div>

            <form action="{{ route('mahasiswa.tugas.upload', $tugasMahasiswa->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label for="catatan" class="block text-sm font-bold text-gray-700">Catatan</label>
                    <textarea id="catatan" name="catatan" rows="4" placeholder="Tambahkan catatan untuk tugas ini..." class="mt-1 block w-full border border-gray-300 rounded-xl focus:ring-violet-500 focus:border-violet-500">{{ old('catatan', $tugasMahasiswa->catatan) }}</textarea>
                    @error('catatan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700">Upload File</label>
                    <div class="mt-1 border-2 border-dashed border-gray-300 rounded-xl p-4 bg-gray-50/50">
                        <input id="file_upload" name="file_upload" type="file" class="block w-full text-sm">
                        <p class="mt-2 text-xs text-gray-500">Format bebas, maks 10MB.</p>
                        @if($tugasMahasiswa->file_upload)
                            <p class="mt-2 text-xs text-gray-600">File saat ini: <span class="font-medium">{{ basename($tugasMahasiswa->file_upload) }}</span></p>
                        @endif
                    </div>
                    @error('file_upload')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="inline-flex justify-center py-2.5 px-6 rounded-xl text-sm font-bold text-white bg-violet-600 hover:bg-violet-700">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
