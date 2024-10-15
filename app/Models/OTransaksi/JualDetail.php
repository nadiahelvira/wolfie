<?php

namespace App\Models\OTransaksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JualDetail extends Model
{
    use HasFactory;

    protected $table = 'juald';
    protected $primaryKey = 'NO_ID';
    public $timestamps = false;

    protected $fillable =
    [
        "REC", "NO_BUKTI", "ID", "KD_BRG", "NA_BRG", "SATUAN", "QTY", 
		"HARGA",
		"TOTAL". "FLAG","created_by", "updated_by", "PN"
    ];
}
