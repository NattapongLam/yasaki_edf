<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhAdjuststockDt extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'wh_adjuststock_dts';
    protected $primaryKey = 'wh_adjuststock_dts_id';
    protected $guarded = ['wh_adjuststock_dts_id'];
}
