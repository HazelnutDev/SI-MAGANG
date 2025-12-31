<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Meta tags untuk pengaturan karakter dan viewport (responsivitas) -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token untuk keamanan form di Laravel -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SI-MAGANG') }} - @yield('title', 'Portal')</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="icon" type="image/x-icon" href="{{ asset('image/SI-MAGANG.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/SI-MAGANG-logo.png') }}">

    @php
        function menuIcon($name) {
            $png = public_path('image/' . $name . '.png');
            $svg = public_path('image/' . $name . '.svg');
            if (file_exists($png)) return asset('image/' . $name . '.png');
            if (file_exists($svg)) return asset('image/' . $name . '.svg');
            return null;
        }
    @endphp

    <!-- Memuat aset CSS dan JS menggunakan Vite -->
    @vite(['resources/css/app.css', 'resources/css/shared.css', 'resources/js/app.js'])
    @php $path = request()->path(); @endphp
    @if (str_starts_with($path, 'admin-panel'))
        @vite(['resources/css/admin.css', 'resources/js/admin.js'])
    @elseif (str_starts_with($path, 'mahasiswa'))
        @vite(['resources/css/mahasiswa.css', 'resources/js/mahasiswa.js'])
    @elseif ($path === 'login' || $path === 'register' || $path === 'forgot-password' || str_starts_with($path, 'reset-password') || $path === 'change-password')
        @vite(['resources/css/auth.css', 'resources/js/auth.js'])
    @endif
</head>

<body class="font-sans antialiased bg-slate-50 text-slate-800">
    <!-- Container utama dengan x-data untuk state sidebar (Alpine.js) -->
    <div x-data="{ sidebarOpen: false }" class="min-h-screen flex flex-col md:flex-row">

        <!-- Header Mobile (Hanya muncul di layar kecil) -->
        <div
            class="md:hidden flex items-center justify-between bg-white border-b border-gray-200 px-4 py-3 sticky top-0 z-30 shadow-sm">
            <div class="flex items-center gap-2">
                <!-- Logo Aplikasi -->
                <div class="bg-indigo-600 p-1.5 rounded-lg shadow-md shadow-indigo-200">
                    <img src="{{ asset('image/SI-MAGANG-logo.png') }}" alt="Logo" class="h-6 w-6 object-contain">
                </div>
                <span class="font-bold text-xl text-slate-800 tracking-tight">SI-MAGANG</span>
            </div>
            <!-- Tombol Toggle Sidebar -->
            <button @click="sidebarOpen = !sidebarOpen"
                class="text-slate-500 hover:text-indigo-600 focus:outline-none transition-colors">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Sidebar Navigasi -->
        <aside :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }"
            class="fixed inset-y-0 left-0 z-40 w-72 bg-slate-50 text-slate-900 transform transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:inset-auto md:flex md:flex-col md:auto shadow-xl border-r border-slate-200">
            <!-- Header Sidebar -->
            <div
                class="flex items-center justify-center h-20 bg-white border-b border-slate-200 relative overflow-hidden">
                <!-- Efek Glow Background -->
                <div
                    class="absolute top-0 left-1/2 -translate-x-1/2 w-1/3 h-1/3 bg-violet-100/40 blur-3xl rounded-full">
                </div>

                <div class="flex items-center gap-3 font-bold text-xl tracking-wider relative z-10">
                    <div class="bg-gradient-to-br from-slate-100 to-slate-200 p-2 rounded-lg shadow-sm border border-slate-200">
                        <img src="{{ asset('image/SI-MAGANG-logo.png') }}" alt="Logo" class="h-6 w-6 object-contain">
                    </div>
                    <span
                        class="bg-clip-text text-transparent bg-gradient-to-r from-slate-700 to-slate-400">SI-MAGANG</span>
                </div>
            </div>

            <!-- Menu Navigasi -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto md:overflow-visible scrollbar-hide">
                @php
                    $role = Auth::user()->role ?? 'guest';
                @endphp

                <!-- Link Dashboard -->
                <a href="{{ $role === 'admin' ? url('/admin-panel/dashboard') : url('/mahasiswa/dashboard') }}"
                    class="flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group relative overflow-hidden {{ request()->is('dashboard*') || request()->is('admin-panel/dashboard*') ? 'bg-violet-50 text-violet-700 border border-violet-200 shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 border border-transparent hover:border-slate-200' }}">
                    @if ($src = menuIcon('dashboard'))
                        <img src="{{ $src }}" alt="Dashboard" class="w-5 h-5 mr-3 relative z-10 object-contain">
                    @else
                        <svg class="w-5 h-5 mr-3 relative z-10 {{ request()->is('dashboard*') || request()->is('admin-panel/dashboard*') ? 'text-violet-700' : 'text-slate-500 group-hover:text-slate-700 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    @endif
                    <span class="relative z-10">Dashboard</span>
                </a>

                @if ($role === 'admin')
                    <div class="pt-6 pb-2">
                        <p class="px-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Administrator</p>
                    </div>

                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group relative overflow-hidden {{ request()->routeIs('admin.users.*') ? 'bg-violet-50 text-violet-700 border border-violet-200 shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 border border-transparent hover:border-slate-200' }}">
                        @if ($src = menuIcon('users'))
                            <img src="{{ $src }}" alt="Data Mahasiswa" class="w-5 h-5 mr-3 relative z-10 object-contain">
                        @else
                            <svg class="w-5 h-5 mr-3 relative z-10 {{ request()->routeIs('admin.users.*') ? 'text-violet-700' : 'text-slate-500 group-hover:text-slate-700 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        @endif
                        <span class="relative z-10">Data Mahasiswa</span>
                    </a>
                    <a href="{{ route('admin.absensi.index') }}"
                        class="flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group relative overflow-hidden {{ request()->routeIs('admin.absensi.*') ? 'bg-violet-50 text-violet-700 border border-violet-200 shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 border border-transparent hover:border-slate-200' }}">
                        @if ($src = menuIcon('absensi'))
                            <img src="{{ $src }}" alt="Data Absensi" class="w-5 h-5 mr-3 relative z-10 object-contain">
                        @else
                            <svg class="w-5 h-5 mr-3 relative z-10 {{ request()->routeIs('admin.absensi.*') ? 'text-violet-700' : 'text-slate-500 group-hover:text-slate-700 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        @endif
                        <span class="relative z-10">Data Absensi</span>
                    </a>
                    <a href="{{ route('admin.tugas.index') }}"
                        class="flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group relative overflow-hidden {{ request()->routeIs('admin.tugas.*') ? 'bg-violet-50 text-violet-700 border border-violet-200 shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 border border-transparent hover:border-slate-200' }}">
                        @if ($src = menuIcon('tugas'))
                            <img src="{{ $src }}" alt="Data Tugas" class="w-5 h-5 mr-3 relative z-10 object-contain">
                        @else
                            <svg class="w-5 h-5 mr-3 relative z-10 {{ request()->routeIs('admin.tugas.*') ? 'text-violet-700' : 'text-slate-500 group-hover:text-slate-700 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        @endif
                        <span class="relative z-10">Data Tugas</span>
                    </a>
                    <a href="{{ route('admin.laporan.index') }}"
                        class="flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group relative overflow-hidden {{ request()->routeIs('admin.laporan.*') ? 'bg-violet-50 text-violet-700 border border-violet-200 shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 border border-transparent hover:border-slate-200' }}">
                        @if ($src = menuIcon('laporan'))
                            <img src="{{ $src }}" alt="Laporan Akhir" class="w-5 h-5 mr-3 relative z-10 object-contain">
                        @else
                            <svg class="w-5 h-5 mr-3 relative z-10 {{ request()->routeIs('admin.laporan.*') ? 'text-violet-700' : 'text-slate-500 group-hover:text-slate-700 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        @endif
                        <span class="relative z-10">Laporan Akhir</span>
                    </a>
                    <a href="{{ route('admin.nilai.index') }}"
                        class="flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group relative overflow-hidden {{ request()->routeIs('admin.nilai.*') ? 'bg-violet-50 text-violet-700 border border-violet-200 shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 border border-transparent hover:border-slate-200' }}">
                        @if ($src = menuIcon('nilai'))
                            <img src="{{ $src }}" alt="Indeks Nilai" class="w-5 h-5 mr-3 relative z-10 object-contain">
                        @else
                            <svg class="w-5 h-5 mr-3 relative z-10 {{ request()->routeIs('admin.nilai.*') ? 'text-violet-700' : 'text-slate-500 group-hover:text-slate-700 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.567-3 3.5S10.343 15 12 15s3-1.567 3-3.5S13.657 8 12 8zM5 20h14a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2z"/></svg>
                        @endif
                        <span class="relative z-10">Indeks Nilai</span>
                    </a>
                    <a href="{{ route('admin.sertifikat.index') }}"
                        class="flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group relative overflow-hidden {{ request()->routeIs('admin.sertifikat.*') ? 'bg-violet-50 text-violet-700 border border-violet-200 shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 border border-transparent hover:border-slate-200' }}">
                        @if ($src = menuIcon('sertifikat'))
                            <img src="{{ $src }}" alt="Sertifikat" class="w-5 h-5 mr-3 relative z-10 object-contain">
                        @else
                            <svg class="w-5 h-5 mr-3 relative z-10 {{ request()->routeIs('admin.sertifikat.*') ? 'text-violet-700' : 'text-slate-500 group-hover:text-slate-700 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5l-3 3-3-3m0 14l3-3 3 3M4 8h16M4 16h16"/></svg>
                        @endif
                        <span class="relative z-10">Sertifikat</span>
                    </a>
                    <a href="{{ route('admin.profile-perusahaan.index') }}"
                        class="flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group relative overflow-hidden {{ request()->routeIs('admin.profile-perusahaan.*') ? 'bg-violet-50 text-violet-700 border border-violet-200 shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 border border-transparent hover:border-slate-200' }}">
                        @if ($src = menuIcon('profile-perusahaan'))
                            <img src="{{ $src }}" alt="Profile Perusahaan" class="w-5 h-5 mr-3 relative z-10 object-contain">
                        @else
                            <svg class="w-5 h-5 mr-3 relative z-10 {{ request()->routeIs('admin.profile-perusahaan.*') ? 'text-violet-700' : 'text-slate-500 group-hover:text-slate-700 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        @endif
                        <span class="relative z-10">Profile Perusahaan</span>
                    </a>
                @endif

                @if ($role === 'mahasiswa' || $role === 'guest')
                    <div class="pt-6 pb-2">
                        <p class="px-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Mahasiswa</p>
                    </div>

                    <a href="{{ route('mahasiswa.absensi.index') }}"
                        class="flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group relative overflow-hidden {{ request()->routeIs('mahasiswa.absensi.*') ? 'bg-violet-50 text-violet-700 border border-violet-200 shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 border border-transparent hover:border-slate-200' }}">
                        @if ($src = menuIcon('absensi'))
                            <img src="{{ $src }}" alt="Absensi" class="w-5 h-5 mr-3 relative z-10 object-contain">
                        @else
                            <svg class="w-5 h-5 mr-3 relative z-10 {{ request()->routeIs('mahasiswa.absensi.*') ? 'text-violet-700' : 'text-slate-500 group-hover:text-slate-700 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        @endif
                        <span class="relative z-10">Absensi</span>
                    </a>

                    <a href="{{ route('mahasiswa.tugas.index') }}"
                        class="flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group relative overflow-hidden {{ request()->routeIs('mahasiswa.tugas.*') ? 'bg-violet-50 text-violet-700 border border-violet-200 shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 border border-transparent hover:border-slate-200' }}">
                        @if ($src = menuIcon('tugas'))
                            <img src="{{ $src }}" alt="Tugas" class="w-5 h-5 mr-3 relative z-10 object-contain">
                        @else
                            <svg class="w-5 h-5 mr-3 relative z-10 {{ request()->routeIs('mahasiswa.tugas.*') ? 'text-violet-700' : 'text-slate-500 group-hover:text-slate-700 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        @endif
                        <span class="relative z-10">Tugas</span>
                    </a>

                    <a href="{{ route('mahasiswa.laporan.index') }}"
                        class="flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group relative overflow-hidden {{ request()->routeIs('mahasiswa.laporan.*') ? 'bg-violet-50 text-violet-700 border border-violet-200 shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 border border-transparent hover:border-slate-200' }}">
                        @if ($src = menuIcon('laporan'))
                            <img src="{{ $src }}" alt="Laporan" class="w-5 h-5 mr-3 relative z-10 object-contain">
                        @else
                            <svg class="w-5 h-5 mr-3 relative z-10 {{ request()->routeIs('mahasiswa.laporan.*') ? 'text-violet-700' : 'text-slate-500 group-hover:text-slate-700 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        @endif
                        <span class="relative z-10">Laporan Akhir</span>
                    </a>

                    <a href="{{ route('mahasiswa.sertifikat.index') }}"
                        class="flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group relative overflow-hidden {{ request()->routeIs('mahasiswa.sertifikat.*') ? 'bg-violet-50 text-violet-700 border border-violet-200 shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 border border-transparent hover:border-slate-200' }}">
                        @if ($src = menuIcon('sertifikat'))
                            <img src="{{ $src }}" alt="Sertifikat" class="w-5 h-5 mr-3 relative z-10 object-contain">
                        @else
                            <svg class="w-5 h-5 mr-3 relative z-10 {{ request()->routeIs('mahasiswa.sertifikat.*') ? 'text-violet-700' : 'text-slate-500 group-hover:text-slate-700 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5l-3 3-3-3m0 14l3-3 3 3M4 8h16M4 16h16"/></svg>
                        @endif
                        <span class="relative z-10">Sertifikat</span>
                    </a>

                    <a href="{{ route('mahasiswa.profile.edit') }}"
                        class="flex items-center px-4 py-3.5 text-sm font-medium rounded-xl transition-all duration-200 group relative overflow-hidden {{ request()->routeIs('mahasiswa.profile.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/50' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        @if (request()->routeIs('mahasiswa.profile.*'))
                            <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-indigo-500 opacity-100">
                            </div>
                        @endif
                        @if ($src = menuIcon('profil'))
                            <img src="{{ $src }}" alt="Profil" class="w-5 h-5 mr-3 relative z-10 object-contain">
                        @else
                            <svg class="w-5 h-5 mr-3 relative z-10 {{ request()->routeIs('mahasiswa.profile.*') ? 'text-white' : 'text-slate-500 group-hover:text-white transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 8a2 2 0 01-2 2H5a2 2 0 01-2-2v-1a6 6 0 016-6h6a6 6 0 016 6v1z"/></svg>
                        @endif
                        <span class="relative z-10">Profil</span>
                    </a>
                @endif

            </nav>

            <!-- Footer Sidebar -->
            <div class="p-4 border-t border-slate-200 bg-white">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center w-full px-4 py-2.5 text-sm font-medium text-red-700 bg-red-50 border border-red-200 rounded-xl hover:bg-red-100 hover:text-red-800 transition-all duration-200 group">
                        <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-red-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Konten Utama -->
        <main class="flex-1 flex flex-col min-w-0 bg-slate-50 overflow-y-auto">

            <!-- Header Atas (Desktop) -->
            <header
                class="hidden md:flex items-center justify-between bg-white/80 backdrop-blur-md sticky top-0 z-20 px-8 py-4 border-b border-slate-200/60">
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight">
                    @yield('header', 'Dashboard')
                </h2>
                <div class="flex items-center gap-6">
                    <!-- Tombol Notifikasi -->
                    <button class="text-slate-400 hover:text-indigo-600 transition-colors relative group">
                        <div class="absolute top-0 right-0 h-2.5 w-2.5 rounded-full bg-red-500 border-2 border-white">
                        </div>
                        <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </button>

                    <div class="h-8 w-px bg-slate-200"></div>

                    <!-- Profil Singkat -->
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden lg:block">
                            <p class="text-sm font-bold text-slate-700 leading-none">
                                {{ Auth::user()->name ?? 'User' }}</p>
                            <p class="text-xs text-slate-500 mt-1">{{ Auth::user()->role ?? 'Guest' }}</p>
                        </div>
                        @php
                            $user = Auth::user();
                            $fotoPath = $user && $user->foto_profil ? $user->foto_profil : 'profile/default.jpg';
                            if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($fotoPath)) {
                                $fotoPath = 'profile/default.jpg';
                            }
                            $role = $user->role ?? 'guest';
                            $profileEditUrl = $role === 'admin' ? route('admin.profile.edit') : route('mahasiswa.profile.edit');
                        @endphp
                        <a href="{{ $profileEditUrl }}" class="flex-shrink-0 h-10 w-10">
                            <img class="h-10 w-10 rounded-full object-cover ring-2 ring-indigo-50"
                                 src="{{ asset('storage/' . $fotoPath) }}" alt="Foto {{ $user->name ?? 'User' }}">
                        </a>
                    </div>
                </div>
            </header>

            <!-- Area Scroll Konten -->
            <div class="flex-1 p-4 md:p-4 scroll-smooth">
                <!-- Pesan Flash (Sukses/Gagal) -->
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms
                        class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-4 rounded-xl flex items-start gap-3 shadow-sm relative"
                        role="alert">
                        <svg class="w-6 h-6 text-emerald-500 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="flex-1">
                            <h3 class="font-bold text-sm">Berhasil!</h3>
                            <p class="text-sm mt-0.5">{{ session('success') }}</p>
                        </div>
                        <button @click="show = false" class="text-emerald-400 hover:text-emerald-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms
                        class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-4 rounded-xl flex items-start gap-3 shadow-sm relative"
                        role="alert">
                        <svg class="w-6 h-6 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="flex-1">
                            <h3 class="font-bold text-sm">Terjadi Kesalahan!</h3>
                            <p class="text-sm mt-0.5">{{ session('error') }}</p>
                        </div>
                        <button @click="show = false" class="text-red-400 hover:text-red-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif

                <!-- Slot Konten Utama -->
                @yield('content')
            </div>
        </main>

        <!-- Overlay Gelap untuk Sidebar Mobile -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-30 md:hidden"></div>
    </div>
</body>

</html>
