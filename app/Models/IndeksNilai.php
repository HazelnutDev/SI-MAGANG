<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// IndeksNilai Model
class IndeksNilai extends Model
{
    use HasFactory;

    protected $table = 'indeks_nilai';

    protected $fillable = [
        'user_id',
        'nilai_absensi',
        'nilai_tugas',
        'nilai_laporan',
        'nilai_sikap',
        'nilai_akhir',
        'grade',
        'catatan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hitungNilaiAkhir()
    {
        $this->nilai_akhir = (
            ($this->nilai_absensi * 0.2) +
            ($this->nilai_tugas * 0.4) +
            ($this->nilai_laporan * 0.3) +
            ($this->nilai_sikap * 0.1)
        );

        $this->grade = $this->tentukanGrade($this->nilai_akhir);
        $this->save();
    }

    private function tentukanGrade($nilai)
    {
        if ($nilai >= 85) return 'A';
        if ($nilai >= 70) return 'B';
        if ($nilai >= 60) return 'C';
        if ($nilai >= 50) return 'D';
        return 'E';
    }
}

