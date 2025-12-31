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
        Schema::create('instansi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan');
            $table->string('logo')->nullable();
            $table->text('alamat');
            $table->string('telepon');
            $table->string('email');
            $table->string('website')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('Kepala_Dinas')->nullable();
            $table->string('Penanggung_Jawab')->nullable();
            $table->string('pembimbing_lapangan')->nullable();
            $table->string('Kordinator_Photos_Videos')->nullable();
            $table->string('Kordinator_Releas_Berita')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instansi');
    }
};
