<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalibrationPlan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'calibration_plans';
    protected $primaryKey = 'calibration_plans_id';
    protected $guarded = ['calibration_plans_id'];
}
