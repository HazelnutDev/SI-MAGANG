@extends('layouts.app')

@section('title', 'Buat Tugas Baru')
@section('header', 'Buat Tugas Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-medium text-gray-900">Form Tugas Baru</h3>
                <a href="{{ route('admin.tugas.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 flex items-center transition-colors duration-200">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>

            <form action="{{ route('admin.tugas.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="judul_tugas" class="block text-sm font-medium text-gray-700">Judul Tugas <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <input type="text" name="judul_tugas" id="judul_tugas" value="{{ old('judul_tugas') }}" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition duration-200" placeholder="Masukkan judul tugas">
                        </div>
                        @error('judul_tugas')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Tugas <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <textarea name="deskripsi" id="deskripsi" rows="4" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition duration-200" placeholder="Jelaskan detail tugas yang harus dikerjakan">{{ old('deskripsi') }}</textarea>
                        </div>
                        @error('deskripsi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai', date('Y-m-d')) }}" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition duration-200">
                        </div>
                        @error('tanggal_mulai')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700">Tanggal Selesai <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition duration-200">
                        </div>
                        @error('tanggal_selesai')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <select name="status" id="status" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition duration-200">
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Assign ke Mahasiswa <span class="text-red-500">*</span></label>
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 grid grid-cols-12 gap-4">
                                <div class="col-span-1">
                                    <input type="checkbox" id="check-all" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </div>
                                <div class="col-span-6 text-xs font-bold text-gray-500 uppercase">Mahasiswa</div>
                                <div class="col-span-5 text-xs font-bold text-gray-500 uppercase">Kategori</div>
                            </div>
                            <div class="max-h-60 overflow-y-auto divide-y divide-gray-200 bg-white">
                                @foreach($mahasiswa as $index => $m)
                                <div class="px-4 py-3 grid grid-cols-12 gap-4 items-center hover:bg-gray-50 transition duration-150">
                                    <div class="col-span-1">
                                        <input type="checkbox" name="mahasiswa[{{ $index }}][user_id]" value="{{ $m->id }}" 
                                               class="student-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </div>
                                    <div class="col-span-6">
                                        <div class="text-sm font-medium text-gray-900">{{ $m->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $m->nim }}</div>
                                    </div>
                                    <div class="col-span-5">
                                        <select name="mahasiswa[{{ $index }}][kategori]" class="block w-full text-xs border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <option value="photographer">Photographer</option>
                                            <option value="videographer">Videographer</option>
                                            <option value="pressrelease">Press Release</option>
                                        </select>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @if($errors->has('mahasiswa'))
                            <p class="mt-1 text-sm text-red-600">{{ $errors->first('mahasiswa') }}</p>
                        @endif
                        @if($errors->has('mahasiswa.*.user_id'))
                             <p class="mt-1 text-sm text-red-600">Silakan pilih minimal satu mahasiswa.</p>
                        @endif
                    </div>
                </div>

                <div class="pt-5 border-t border-gray-200">
                    <div class="flex justify-end">
                        <a href="{{ route('admin.tugas.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                            Batal
                        </a>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200 transform hover:-translate-y-0.5">
                            Simpan Tugas
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('check-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.student-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
</script>
@endsection
