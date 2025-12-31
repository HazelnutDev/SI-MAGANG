<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// TugasMahasiswa Model
class TugasMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'tugas_mahasiswa';

    protected $fillable = [
        'tugas_id',
        'user_id',
        'kategori',
        'catatan',
        'file_upload',
        'status_pengerjaan',
        'tanggal_submit',
        'feedback_admin',
        'nilai',
    ];

    protected $casts = [
        'tanggal_submit' => 'datetime',
    ];

    public function tugas()
    {
        return $this->belongsTo(TugasKegiatanHarian::class, 'tugas_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
