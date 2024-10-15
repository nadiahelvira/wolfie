<?php

namespace App\Models\OTransaksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;


//ganti 1
class Piu extends Model
{
     use HasFactory;

// ganti 2
    protected $table = 'piu';
    protected $primaryKey = 'NO_ID';
    public $timestamps = true;

//ganti 3
    protected $fillable = 
    [
       "NO_BUKTI", "TGL", "NO_SO", "PER","KODEC", "NAMAC",  "TOTAL", "BAYAR", "GOL", "BACNO", "BNAMA", "FLAG", "NO_BANK", "NO_BG",
	   "USRNM", "TG_SMP", "NOTES", "USRINS", "TG_INS", "created_by", "updated_by","FLAG2", "UMUKA", "LAIN","TRANSF1"
    ];
}
