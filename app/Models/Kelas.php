<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'datakelas';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'idkelas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idwalas',
        'idsiswa',
    ];

    public function walas()
    {
        return $this->belongsTo(Walas::class, 'idwalas', 'idwalas');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'idsiswa', 'idsiswa');
    }
}
