<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckoutRacikan extends Model
{
    protected $table = 'checkout_racikan';
    protected $fillable = ['racikan_nama', 'obat_id', 'qty', 'signa_id', 'checkout_at'];

    public function obat() {
        return $this->belongsTo(Obatalkes::class, 'obat_id', 'obatalkes_id');
    }

    public function signa() {
        return $this->belongsTo(Signa::class, 'signa_id', 'signa_id');
    }
}

