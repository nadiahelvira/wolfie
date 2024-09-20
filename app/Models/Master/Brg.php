<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


//ganti 1
class Brg extends Model
{
    use HasFactory;

// ganti 2
    protected $table = 'brg';
    protected $primaryKey = 'NO_ID';
    public $timestamps = false;

//ganti 3
    protected $fillable = 
    [
        "KD_BRG", "NA_BRG", "JENIS", "SATUAN","GOL", "USRNM", "TG_SMP", "PN", "KODES", "NAMAS",
        "SATUAN_BELI", "KALI", "ACNOA", "NACNOA", "ACNOB","NACNOB", "ROP", "HJUAL", "SMIN", "SMAX"
		
    ];
}
