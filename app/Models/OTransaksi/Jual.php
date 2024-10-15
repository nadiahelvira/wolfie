<?php

namespace App\Models\OTransaksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;


//ganti 1
class Jual extends Model
{
     use HasFactory;

// ganti 2
    protected $table = 'jual';
    protected $primaryKey = 'NO_ID';
    public $timestamps = true;

//ganti 3
    protected $fillable = 
    [
        "NO_BUKTI", "TGL", "PER",  "FLAG", "NO_SO", "TOTAL_QTY",
        "KODEC", "NAMAC","ALAMAT", "KOTA",   		 
		 "TOTAL",  "SISA", "PPN", "NETT",  "NOTES", "USRNM", "TG_SMP", 
		 "created_by", "updated_by"
    ];
}
