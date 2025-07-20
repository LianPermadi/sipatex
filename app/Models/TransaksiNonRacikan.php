<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiNonRacikan extends Model
{
    use HasFactory;

    protected $table = 'transaksi_non_racikans';

    protected $fillable = [
        'checkout_id',
        'obat_id',
        'qty',
    ];

    public function obat()
    {
        return $this->belongsTo(Obatalkes::class, 'obat_id');
    }

}

