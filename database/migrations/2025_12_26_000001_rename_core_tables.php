<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('tugas_kegiatan_harian') && !Schema::hasTable('tugas_kegiatan')) {
            Schema::rename('tugas_kegiatan_harian', 'tugas_kegiatan');
        }

        if (Schema::hasTable('laporan_akhir') && !Schema::hasTable('laporan')) {
            Schema::rename('laporan_akhir', 'laporan');
        }

        if (Schema::hasTable('profile_perusahaan') && !Schema::hasTable('instansi')) {
            Schema::rename('profile_perusahaan', 'instansi');
        }

        if (Schema::hasTable('tugas_mahasiswa')) {
            Schema::table('tugas_mahasiswa', function (Blueprint $table) {
                try {
                    $table->dropForeign(['tugas_id']);
                } catch (\Throwable $e) {
                    // ignore if FK name differs
                }
            });

            Schema::table('tugas_mahasiswa', function (Blueprint $table) {
                $table->foreign('tugas_id')->references('id')->on('tugas_kegiatan')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('tugas_kegiatan') && !Schema::hasTable('tugas_kegiatan_harian')) {
            Schema::rename('tugas_kegiatan', 'tugas_kegiatan_harian');
        }

        if (Schema::hasTable('laporan') && !Schema::hasTable('laporan_akhir')) {
            Schema::rename('laporan', 'laporan_akhir');
        }

        if (Schema::hasTable('instansi') && !Schema::hasTable('profile_perusahaan')) {
            Schema::rename('instansi', 'profile_perusahaan');
        }

        if (Schema::hasTable('tugas_mahasiswa')) {
            Schema::table('tugas_mahasiswa', function (Blueprint $table) {
                try {
                    $table->dropForeign(['tugas_id']);
                } catch (\Throwable $e) {
                }
            });

            Schema::table('tugas_mahasiswa', function (Blueprint $table) {
                $table->foreign('tugas_id')->references('id')->on('tugas_kegiatan_harian')->onDelete('cascade');
            });
        }
    }
};

