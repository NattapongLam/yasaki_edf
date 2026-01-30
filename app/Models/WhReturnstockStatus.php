<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhReturnstockStatus extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'wh_returnstock_statuses';
    protected $primaryKey = 'wh_returnstock_statuses_id';
    protected $guarded = ['wh_returnstock_statuses_id'];
}
