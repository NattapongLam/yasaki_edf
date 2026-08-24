<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionCalibrationHd extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'inspection_calibration_hds';
    protected $primaryKey = 'inspection_calibration_hds_id';
    protected $guarded = ['inspection_calibration_hds_id'];
}
