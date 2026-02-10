<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalibrationPlanSub extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'calibration_plan_subs';
    protected $primaryKey = 'calibration_plan_subs_id';
    protected $guarded = ['calibration_plan_subs_id'];
}
