<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArQuotationDt extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ar_quotation_dts';
    protected $primaryKey = 'ar_quotation_dts_id';
    protected $guarded = ['ar_quotation_dts_id'];
}
