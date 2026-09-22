<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DensityWorkpieceHd extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'density_workpiece_hds';
    protected $primaryKey = 'density_workpiece_hds_id';
    protected $guarded = ['density_workpiece_hds_id'];
}
