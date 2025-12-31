<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sertifikat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nomor_sertifikat')->unique();
            $table->date('tanggal_terbit');
            $table->date('tanggal_mulai_magang');
            $table->date('tanggal_selesai_magang');
            $table->string('nama_instansi')->default('Dinas Komunikasi, Informatika dan Statistik Provinsi NTB');
            $table->string('lokasi_instansi')->default('Mataram');
            $table->string('kepala_dinas')->default('H. Yusron Hadi, S.T., M.UM');
            $table->string('file_sertifikat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikat');
    }
};
