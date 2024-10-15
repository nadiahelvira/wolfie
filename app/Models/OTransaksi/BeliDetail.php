<?php

namespace App\Models\OTransaksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeliDetail extends Model
{
    use HasFactory;

    protected $table = 'belid';
    protected $primaryKey = 'NO_ID';
    public $timestamps = false;

    protected $fillable =
    [
        "REC", "NO_BUKTI", "PER",  "ID", "KD_BRG", "NA_BRG", "QTY",
		"HARGA", "TOTAL","KET", "FLAG", 
		"DISKON", "SATUAN","created_by", "updated_by"
    ];
}
