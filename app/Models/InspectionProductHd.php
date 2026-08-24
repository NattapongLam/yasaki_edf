<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionProductHd extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'inspection_product_hds';
    protected $primaryKey = 'inspection_product_hds_id';
    protected $guarded = ['inspection_product_hds_id'];
}
