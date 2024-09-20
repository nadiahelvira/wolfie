<?php

namespace App\Models\OTransaksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


//ganti 1
class Po extends Model
{
    use HasFactory;

// ganti 2
    protected $table = 'po';
    protected $primaryKey = 'NO_ID';
    public $timestamps = false;

//ganti 3
    protected $fillable = 
    [
        "NO_BUKTI", "TGL", "JTEMPO", "PER","KODES", "NAMAS", "ALAMAT", "KOTA", "FLAG", "GOL", 
        "TOTAL", "TOTAL_QTY", "NOTES", "FLAG", "GOL", "USRNM", "TG_SMP", "TERM", "VIA", "PKP"
    ];
}
