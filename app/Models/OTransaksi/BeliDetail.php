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
        "REC", "NO_BUKTI", "ID", "KD_BHN", "NA_BHN", "KD_BHN", "NA_BHN", "QTY", "HARGA", "TOTAL", 
        "KET", "TTOTAL_QTY", "TTOTAL", "GOL", "PER", "FLAG", "KD_BRG", "NA_BRG", "KALI", "SATUAN_PO", "QTY_PO",
        "DPP", "PPN"
    ];
}
