<?php

namespace App\Models\OTransaksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Beli extends Model
{
     use HasFactory;

    protected $table = 'beli';
    protected $primaryKey = 'NO_ID';
    public $timestamps = true;

    protected $fillable = 
    [
        "NO_BUKTI","TGL", "PER","KODES", "NAMAS", "ALAMAT", "KOTA", 
		"FLAG",  "NO_FAKTUR", "TGL_FAKTUR", "JTEMPO", 
		"NO_PO", "TOTAL", "TOTAL_QTY", "PPN","PPNYM", 
		"NETT", "SISA", "NOTES", 
		"USRNM", "TG_SMP" ,  "created_at", "updated_at", "created_by", "updated_by",
		"deleted_by"
		
    ];
}