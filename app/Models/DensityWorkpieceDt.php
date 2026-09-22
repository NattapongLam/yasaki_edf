<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DensityWorkpieceDt extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'density_workpiece_dts';
    protected $primaryKey = 'density_workpiece_dts_id';
    protected $guarded = ['density_workpiece_dts_id'];
}
