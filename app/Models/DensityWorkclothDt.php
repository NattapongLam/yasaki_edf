<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DensityWorkclothDt extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'density_workcloth_dts';
    protected $primaryKey = 'density_workcloth_dts_id';
    protected $guarded = ['density_workcloth_dts_id'];
}
