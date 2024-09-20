<?php

namespace App\Models\OTransaksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoDetail extends Model
{
    use HasFactory;

    protected $table = 'sod';
    protected $primaryKey = 'NO_ID';
    public $timestamps = false;

    protected $fillable =
    [
        "REC", "NO_BUKTI", "ID",  "KD_BRG", "FLAG", "NA_BRG", "SATUAN", "QTY", "SISA", "HARGA", 
        "TOTAL", "KET", "TOTAL_QTY", "KD_BHN", "NA_BHN", "PER", "GOL"
    ];
}
