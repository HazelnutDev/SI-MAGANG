@extends('layouts.app')

@section('title', 'Ganti Password')
@section('header', 'Ganti Password')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8">
            <form action="{{ route('mahasiswa.profile.update-password') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700">Password Saat Ini</label>
                    <input id="current_password" name="current_password" type="password" required class="mt-1 block w-full border-gray-300 rounded-lg">
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                    <input id="password" name="password" type="password" required class="mt-1 block w-full border-gray-300 rounded-lg">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required class="mt-1 block w-full border-gray-300 rounded-lg">
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="inline-flex justify-center py-2.5 px-6 rounded-xl text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

