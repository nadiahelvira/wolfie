<?php

namespace App\Models\OTransaksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;


//ganti 1
class Hut extends Model
{
     use HasFactory;

// ganti 2
    protected $table = 'hut';
    protected $primaryKey = 'NO_ID';
    public $timestamps = true;

//ganti 3
    protected $fillable = 
    [
        "NO_BUKTI", "POSTED", "TGL", "BAYAR", "LAIN", 
		"NOTES", "PER","KODES", "NAMAS","NOREK", "FLAG", 
		"USRNM", "TG_SMP",
		"created_by", "updated_by",
		
    ];
}
