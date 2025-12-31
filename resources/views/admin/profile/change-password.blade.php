@extends('layouts.app')

@section('title', 'Ganti Password')
@section('header', 'Ganti Password')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-medium text-gray-900">Ubah Password Akun</h3>
                <a href="{{ route('admin.profile.edit') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 flex items-center transition-colors duration-200">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Profil
                </a>
            </div>

            <form action="{{ route('admin.profile.update-password') }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')

                <div class="max-w-xl">
                    <div class="space-y-6">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700">Password Saat Ini <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input type="password" name="current_password" id="current_password" required
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition duration-200">
                            </div>
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password Baru <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input type="password" name="password" id="password" required
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition duration-200">
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter.</p>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition duration-200">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-5 border-t border-gray-200">
                    <div class="flex justify-end sm:justify-start">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200 transform hover:-translate-y-0.5">
                            Simpan Password Baru
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
