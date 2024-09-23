<?php

namespace App\Models\OTransaksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


//ganti 1
class Jual extends Model
{
    use HasFactory;

// ganti 2
    protected $table = 'jual';
    protected $primaryKey = 'NO_ID';
    public $timestamps = false;

//ganti 3
    protected $fillable = 
    [
        "NO_BUKTI", "TGL", "PER", "FLAG", "NO_JUAL", "TRUCK", "SOPIR", "KODEC", "NAMAC", "ALAMAT", "KOTA", 
        "NOTES", "TOTAL_QTY", "TOTAL", "PPN", "NETT", "USRNM", "TG_SMP", "NO_SO", "GOL", "NO_SURAT", "CBG"
    ];
}
