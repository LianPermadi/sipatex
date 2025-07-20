<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckoutNonRacikan extends Model
{
    use HasFactory;

    protected $table = 'checkout_non_racikans';

    protected $fillable = [
        'obat_id',
        'signa_id',
        'qty',
        'tanggal'
    ];

    public function obat()
    {
        return $this->belongsTo(Obatalkes::class, 'obat_id', 'obatalkes_id');
    }

    public function signa()
    {
        return $this->belongsTo(Signa::class, 'signa_id', 'signa_id');
    }
}

