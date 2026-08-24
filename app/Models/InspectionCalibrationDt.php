<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionCalibrationDt extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'inspection_calibration_dts';
    protected $primaryKey = 'inspection_calibration_dts_id';
    protected $guarded = ['inspection_calibration_dts_id'];
}
