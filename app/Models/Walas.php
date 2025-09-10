<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Walas extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'datawalas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'jenjang',
        'namakelas',
        'tahunajaran',
        'idguru',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'idguru');
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'idwalas');
    }
}
