<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalibrationGroup extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'calibration_groups';
    protected $primaryKey = 'calibration_groups_id';
    protected $guarded = ['calibration_groups_id'];
}
