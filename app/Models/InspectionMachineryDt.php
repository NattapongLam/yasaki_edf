<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionMachineryDt extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'inspection_machinery_dts';
    protected $primaryKey = 'inspection_machinery_dts_id';
    protected $guarded = ['inspection_machinery_dts_id'];
}
