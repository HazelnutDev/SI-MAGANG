@extends('layouts.app')

@section('title', 'Detail Mahasiswa')
@section('header', 'Detail Data Mahasiswa')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-16 w-16">
                        @if($user->foto_profil)
                            <img class="h-16 w-16 rounded-full object-cover ring-4 ring-indigo-50" src="{{ asset('storage/' . $user->foto_profil) }}" alt="{{ $user->name }}">
                        @else
                            <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-2xl ring-4 ring-indigo-50">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-gray-900">{{ $user->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </a>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">NIM</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-medium">{{ $user->nim }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Asal Sekolah</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-medium">{{ $user->asal_sekolah }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">No. Telepon</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->no_telp ?? '-' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Status Akun</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Aktif
                            </span>
                        </dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->alamat ?? '-' }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Bergabung Sejak</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('d F Y, H:i') }} WIB</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
