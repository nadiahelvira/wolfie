<?php

namespace App\Models\FTransaksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


//ganti 1
class Bank extends Model
{
    use HasFactory;

// ganti 2
    protected $table = 'bank';
    protected $primaryKey = 'NO_ID';
    public $timestamps = false;

//ganti 3
    protected $fillable = 
    [
        "NO_BUKTI","TGL", "PER","BACNO", "BNAMA", "JUMLAH", "TYPE", "FLAG", "KET", "JTEMPO", "BG", 
		"USRNM", "TG_SMP"
    ];
}
