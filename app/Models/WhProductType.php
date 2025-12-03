<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhProductType extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'wh_product_types';
    protected $primaryKey = 'wh_product_types_id';
    protected $guarded = ['wh_product_types_id'];
}
