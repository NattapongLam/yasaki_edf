<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalibrationCategory extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'calibration_categories';
    protected $primaryKey = 'calibration_categories_id';
    protected $guarded = ['calibration_categories_id'];
}
