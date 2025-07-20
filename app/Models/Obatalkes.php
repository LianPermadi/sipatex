<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obatalkes extends Model
{
    protected $table = 'obatalkes_m';
    protected $primaryKey = 'obatalkes_id';
    public $timestamps = false;

    protected $fillable = [
        'obatalkes_kode',
        'obatalkes_nama',
        'stok',
        'created_date'
    ];

    // Contoh relasi (jika ada foreign key signa_id)
    public function signa()
    {
        return $this->belongsTo(Signa::class, 'signa_id', 'signa_id');
    }

        // Function custom (contoh)
    public function isStokMenipis()
    {
        return $this->stok < 10;
    }
}
