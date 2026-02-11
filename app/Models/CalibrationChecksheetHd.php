<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalibrationChecksheetHd extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'calibration_checksheet_hds';
    protected $primaryKey = 'calibration_checksheet_hds_id';
    protected $guarded = ['calibration_checksheet_hds_id'];
}
