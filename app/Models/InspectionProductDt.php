<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionProductDt extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'inspection_product_dts';
    protected $primaryKey = 'inspection_product_dts_id';
    protected $guarded = ['inspection_product_dts_id'];
}
