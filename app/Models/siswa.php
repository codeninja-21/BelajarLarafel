<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class siswa extends Model
{
    use HasFactory;

    protected $table = 'datasiswa';
    protected $fillable = [
        'id',
        'nama',
        'tb',
        'bb'
    ];
    protected $primaryKey = 'idsiswa';

    public function admin() {
        return $this->belongsTo(admin::class, 'id', 'id');
    }
    
    public function kelas() {
        return $this->hasMany(Kelas::class, 'idsiswa', 'idsiswa');
    }
}
