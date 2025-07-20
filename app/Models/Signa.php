<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Signa extends Model
{
//     protected $table = 'signa_m';
// protected $primaryKey = 'signa_id';
// public $timestamps = false;
// protected $fillable = ['signa_nama', 'keterangan'];
    protected $table = 'signa_m';
    protected $primaryKey = 'signa_id';
    public $timestamps = false;

    protected $fillable = [
        'signa_kode',
        'signa_nama', 
        'additional_data'
    ];
}
