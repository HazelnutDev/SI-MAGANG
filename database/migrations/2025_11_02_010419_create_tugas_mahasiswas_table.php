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
        Schema::create('tugas_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tugas_id')->constrained('tugas_kegiatan')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('catatan')->nullable();
            $table->enum('kategori', ['photographer', 'videographer', 'pressrelease'])->nullable();
            $table->string('file_upload')->nullable();
            $table->enum('status_pengerjaan', ['belum_mulai', 'proses', 'selesai'])->default('belum_mulai');
            $table->timestamp('tanggal_submit')->nullable();
            $table->integer('nilai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_mahasiswa');
    }
};
