<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhAdjuststockHd extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'wh_adjuststock_hds';
    protected $primaryKey = 'wh_adjuststock_hds_id';
    protected $guarded = ['wh_adjuststock_hds_id'];
}
