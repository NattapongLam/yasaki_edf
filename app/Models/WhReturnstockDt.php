<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhReturnstockDt extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'wh_returnstock_dts';
    protected $primaryKey = 'wh_returnstock_dts_id';
    protected $guarded = ['wh_returnstock_dts_id'];
}
