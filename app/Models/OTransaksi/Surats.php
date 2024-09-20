<?php

namespace App\Models\OTransaksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


//ganti 1
class Surats extends Model
{
    use HasFactory;

// ganti 2
    protected $table = 'surats';
    protected $primaryKey = 'NO_ID';
    public $timestamps = false;

//ganti 3
    protected $fillable = 
    [
        "NO_BUKTI", "TGL", "PER", "FLAG", "TRUCK", "SOPIR", "VIA", "KODEC", "NAMAC", "ALAMAT", "KOTA", "NOTES", 
        "TOTAL_QTY", "TOTAL", "USRNM", "TG_SMP", "GOL", "NO_SO", "JTEMPO"
    ];
}
