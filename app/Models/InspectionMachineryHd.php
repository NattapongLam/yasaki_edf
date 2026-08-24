<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionMachineryHd extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'inspection_machinery_hds';
    protected $primaryKey = 'inspection_machinery_hds_id';
    protected $guarded = ['inspection_machinery_hds_id'];
}
