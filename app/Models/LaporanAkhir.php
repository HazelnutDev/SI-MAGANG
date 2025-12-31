<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaporanAkhir extends Model
{
    use HasFactory;

    protected $table = 'laporan';

    protected $fillable = [
        'user_id',
        'judul',
        'ringkasan',
        'file_laporan',
        'tanggal_submit',
        'status',
        'catatan_revisi',
    ];

    protected $casts = [
        'tanggal_submit' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => ['text' => 'Menunggu Review', 'class' => 'warning'],
            'revisi' => ['text' => 'Perlu Revisi', 'class' => 'danger'],
            'approved' => ['text' => 'Disetujui', 'class' => 'success'],
            default => ['text' => 'Unknown', 'class' => 'secondary']
        };
    }
}
