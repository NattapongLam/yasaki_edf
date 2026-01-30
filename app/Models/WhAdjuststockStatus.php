<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhAdjuststockStatus extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'wh_adjuststock_statuses';
    protected $primaryKey = 'wh_adjuststock_statuses_id';
    protected $guarded = ['wh_adjuststock_statuses_id'];
}
