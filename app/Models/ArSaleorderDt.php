<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArSaleorderDt extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ar_saleorder_dts';
    protected $primaryKey = 'ar_saleorder_dts_id';
    protected $guarded = ['ar_saleorder_dts_id'];
}
