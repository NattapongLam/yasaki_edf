<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhReturnstockHd extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'wh_returnstock_hds';
    protected $primaryKey = 'wh_returnstock_hds_id';
    protected $guarded = ['wh_returnstock_hds_id'];
}
