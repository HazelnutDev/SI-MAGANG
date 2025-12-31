<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable 
    // class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nim',
        'foto_profil',
        'no_telp',
        'alamat',
        'asal_sekolah',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isMahasiswa()
    {
        return $this->role === 'mahasiswa';
    }

    // Relations
    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function tugasMahasiswa()
    {
        return $this->hasMany(TugasMahasiswa::class);
    }

    public function laporanAkhir()
    {
        return $this->hasOne(LaporanAkhir::class);
    }

    public function indeksNilai()
    {
        return $this->hasOne(IndeksNilai::class);
    }

    public function sertifikat()
    {
        return $this->hasOne(Sertifikat::class);
    }
}
