<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DensityWorkclothHd extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'density_workcloth_hds';
    protected $primaryKey = 'density_workcloth_hds_id';
    protected $guarded = ['density_workcloth_hds_id'];
}
