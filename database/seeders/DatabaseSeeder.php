<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ProfilePerusahaan;
use App\Models\TugasKegiatanHarian;
use App\Models\TugasMahasiswa;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Si-Magang',
            'email' => 'noreply.simagang@gmail.com',
            'password' => Hash::make('simagang123'),
            'role' => 'admin',
            'foto_profil' => 'profile/default.jpg',
            'email_verified_at' => now(),
        ]);

        // Mahasiswa Users
        $mahasiswa = [
            [
                'name' => 'akbar hidayat',
                'email' => 'akbar@mahasiswa.com',
                'password' => Hash::make('Akbar#2101'),
                'role' => 'mahasiswa',
                'nim' => '231001022',
                'no_telp' => '085156905988',
                'alamat' => 'Sumbawa Besar, Nusa Tenggara Barat',
                'asal_sekolah' => 'Universitas Teknologi Sumbawa',
                'foto_profil' => 'profile/default.jpg',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Eza al qodri',
                'email' => 'eza@mahasiswa.com',
                'password' => Hash::make('eza123'),
                'role' => 'mahasiswa',
                'nim' => '231001023',
                'no_telp' => '085156905988',
                'alamat' => 'Sumbawa Besar, Nusa Tenggara Barat',
                'asal_sekolah' => 'Universitas Teknologi Sumbawa',
                'foto_profil' => 'profile/profile.jpg',
            ],
            [
                'name' => 'qonita al adiba',
                'email' => 'qonita@mahasiswa.com',
                'password' => Hash::make('qonita123'),
                'role' => 'mahasiswa',
                'nim' => '231001024',
                'no_telp' => '085156905988',
                'alamat' => 'Sumbawa Besar, Nusa Tenggara Barat',
                'asal_sekolah' => 'Universitas Teknologi Sumbawa',
                'foto_profil' => 'profile/profile.jpg',
            ],
            [
                'name' => 'Yudistira',
                'email' => 'yudistira@mahasiswa.com',
                'password' => Hash::make('yudistira123'),
                'role' => 'mahasiswa',
                'nim' => '231001025',
                'no_telp' => '085156905988',
                'alamat' => 'Sumbawa Besar, Nusa Tenggara Barat',
                'asal_sekolah' => 'Universitas Teknologi Sumbawa',
                'foto_profil' => 'profile/profile.jpg',
            ],
        ];

        foreach ($mahasiswa as $mhs) {
            User::create([
                'name' => $mhs['name'],
                'email' => $mhs['email'],
                'password' => $mhs['password'],
                'role' => 'mahasiswa',
                'nim' => $mhs['nim'],
                'no_telp' => $mhs['no_telp'],
                'alamat' => $mhs['alamat'],
                'asal_sekolah' =>$mhs['asal_sekolah'],
                'foto_profil' =>$mhs['foto_profil'],
                'email_verified_at' => now(),
            ]);
        }

        // Profile Perusahaan
        ProfilePerusahaan::create([
            'nama_perusahaan' => 'INFORMASI KOMUNIKASI DAN PENYIARAN',
            'logo'=> 'logo/diskominfo.png',
            'alamat' => 'Jl. Udayana No.14, Monjok Bar., Kec. Selaparang, Kota Mataram, Nusa Tenggara Bar. 83122',
            'telepon' => '(0370) 644264',
            'email' => 'diskominfotik.ntb@gmail.com',
            'website' => 'https://data.ntbprov.go.id/',
            'deskripsi' => 'DISKOMINFOTIK NTB adalah singkatan dari Dinas Komunikasi, Informatika, Persandian, dan Statistik Provinsi Nusa Tenggara Barat. Instansi ini bertugas untuk melaksanakan urusan pemerintahan di bidang komunikasi, informatika, persandian, dan statistik,
serta membantu Gubernur dalam menyelenggarakan kewenangan di bidang-bidang tersebut. Tujuannya adalah untuk membangun NTB yang makmur melalui informasi dan komunikasi yang baik.',
            'Kepala_Dinas' => 'H. Yusron Hadi, S.T., M.UM',
            'Penanggung_Jawab' => 'Syafrudin S.H.,M.H',
            'pembimbing_lapangan' => 'Lalu Muhammad Taufik, S.P',
            'Kordinator_Photos_Videos' => 'Syamsun Rijal, S.I.Kom',
            'Kordinator_Releas_Berita' => 'Lalu M. Hairidho Azwari S.I.Kom'
        ]);

        // Sample Tugas Kegiatan Harian
        $tugas = [
            [
                'judul_tugas' => 'Dokumentasi Agenda Pak Gubernur',
                'deskripsi' => 'Mengambil foto dokumentasi agenda Pak Gubernur',
                'tanggal_mulai' => now(),
                'tanggal_selesai' => now()->addDays(7),
            ],
            [
                'judul_tugas' => 'Editing Video Agenda Pak Gubernur',
                'deskripsi' => 'Mengedit video untuk keperluan Instagram dan YouTube',
                'tanggal_mulai' => now(),
                'tanggal_selesai' => now()->addDays(10),
            ],
            [
                'judul_tugas' => 'Persiapan Siaran Pers',
                'deskripsi' => 'Menyusun dan menyiapkan materi siaran pers untuk media massa',
                'tanggal_mulai' => now(),
                'tanggal_selesai' => now()->addDays(5),
            ],
        ];

        foreach ($tugas as $t) {
            TugasKegiatanHarian::create($t);
        }

        // Sekarang buat assignment tugas ke mahasiswa dengan kategori
        $tugasAssignments = [
            ['tugas_id' => 1, 'user_id' => 2, 'kategori' => 'photographer'], // Akbar - Dokumentasi
            ['tugas_id' => 1, 'user_id' => 3, 'kategori' => 'photographer'], // Eza - Dokumentasi
            ['tugas_id' => 2, 'user_id' => 4, 'kategori' => 'videographer'], // Qonita - Video
            ['tugas_id' => 3, 'user_id' => 5, 'kategori' => 'pressrelease'], // Yudistira - Press Release
        ];

        foreach ($tugasAssignments as $assignment) {
            \App\Models\TugasMahasiswa::create([
                'tugas_id' => $assignment['tugas_id'],
                'user_id' => $assignment['user_id'],
                'kategori' => $assignment['kategori'],
                'status_pengerjaan' => 'belum_mulai',
            ]);
        }
    }
}
