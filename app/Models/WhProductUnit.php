<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhProductUnit extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'wh_product_units';
    protected $primaryKey = 'wh_product_units_id';
    protected $guarded = ['wh_product_units_id'];
}
