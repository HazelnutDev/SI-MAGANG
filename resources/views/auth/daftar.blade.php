@extends('layouts.auth')

@section('title', 'Daftar')

@section('content')
    <!-- Dekorasi Background -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-indigo-500/10 blur-[100px] rounded-full"></div>
        <div class="absolute top-[20%] right-[10%] w-[30%] h-[30%] bg-purple-500/10 blur-[100px] rounded-full"></div>
    </div>

    <!-- Header Logo -->
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center mb-8">
        <div class="inline-flex justify-center mb-4">
            <div
                class="bg-gradient-to-br from-indigo-600 to-indigo-700 text-white p-3.5 rounded-2xl shadow-xl shadow-indigo-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
        </div>
        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">
            SI-MAGANG
        </h2>
        <p class="mt-2 text-sm text-slate-600">
            Sistem Informasi Magang Mahasiswa
        </p>
        <p class="text-sm text-gray-500 mt-2">Daftar untuk memulai perjalanan magang Anda.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700"> Nama Lengkap </label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input id="name" name="name" type="text" autocomplete="name" required
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-200"
                        placeholder="Nama Lengkap" value="{{ old('name') }}">
                </div>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nim" class="block text-sm font-medium text-gray-700"> NIM </label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input id="nim" name="nim" type="text" required
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-200"
                        placeholder="NIM Mahasiswa" value="{{ old('nim') }}">
                </div>
                @error('nim')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700"> Email Address </label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input id="email" name="email" type="email" autocomplete="email" required
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-200"
                        placeholder="email@contoh.com" value="{{ old('email') }}">
                </div>
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="no_telp" class="block text-sm font-medium text-gray-700"> No. Telepon </label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input id="no_telp" name="no_telp" type="text"
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-200"
                        placeholder="08xxxxxxxxxx" value="{{ old('no_telp') }}">
                </div>
                @error('no_telp')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="alamat" class="block text-sm font-medium text-gray-700"> Alamat </label>
            <div class="mt-1">
                <textarea id="alamat" name="alamat" rows="2"
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-200"
                    placeholder="Alamat Lengkap">{{ old('alamat') }}</textarea>
            </div>
            @error('alamat')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700"> Password </label>
                <div class="mt-1">
                    <input id="password" name="password" type="password" autocomplete="new-password" required
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-200"
                        placeholder="••••••••">
                </div>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700"> Konfirmasi Password
                </label>
                <div class="mt-1">
                    <input id="password_confirmation" name="password_confirmation" type="password"
                        autocomplete="new-password" required
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-200"
                        placeholder="••••••••">
                </div>
            </div>
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:-translate-y-0.5">
                Daftar
            </button>
        </div>
    </form>

    <div class="mt-6">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500"> Sudah punya akun? </span>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('login') }}"
                class="w-full flex justify-center py-2.5 px-4 border border-gray-300 rounded-xl shadow-sm text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:-translate-y-0.5">
                Masuk
            </a>
        </div>
    </div>
@endsection
