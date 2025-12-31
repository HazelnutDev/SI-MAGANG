<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Sertifikat Model
class Sertifikat extends Model
{
    use HasFactory;

    protected $table = 'sertifikat';

    protected $fillable = [
        'user_id',
        'nomor_sertifikat',
        'tanggal_terbit',
        'tanggal_mulai_magang',
        'tanggal_selesai_magang',
        'nama_instansi',
        'lokasi_instansi',
        'kepala_dinas',
        'file_sertifikat',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
        'tanggal_mulai_magang' => 'date',
        'tanggal_selesai_magang' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
