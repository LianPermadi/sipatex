<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiObat extends Model
{
    protected $table = 'transaksi_obat';

    protected $fillable = [
        'obat_id',
        'signa_id',
        'qty',
        'tipe',
        'racikan_nama',
    ];

public function obat() {
    return $this->belongsTo(Obatalkes::class, 'obat_id', 'obatalkes_id');
}
public function signa() {
    return $this->belongsTo(Signa::class, 'signa_id', 'signa_id');
}

}
