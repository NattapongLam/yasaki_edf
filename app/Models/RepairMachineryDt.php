<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairMachineryDt extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'repair_machinery_dts';
    protected $primaryKey = 'repair_machinery_dts_id';
    protected $guarded = ['repair_machinery_dts_id'];
}
