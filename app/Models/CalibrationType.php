<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalibrationType extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'calibration_types';
    protected $primaryKey = 'calibration_types_id';
    protected $guarded = ['calibration_types_id'];
}
