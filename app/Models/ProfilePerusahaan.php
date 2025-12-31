<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilePerusahaan extends Model
{
    use HasFactory;

    protected $table = 'instansi';

    protected $fillable = [
        'nama_perusahaan',
        'logo',
        'alamat',
        'telepon',
        'email',
        'website',
        'deskripsi',
        'Kepala_Dinas',
        'pembimbing_lapangan',
        'Penanggung_Jawab',
        'Kordinator_Photos_Videos',
        'Kordinator_Releas_Berita',
    ];
}
