<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairMachineryHd extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'repair_machinery_hds';
    protected $primaryKey = 'repair_machinery_hds_id';
    protected $guarded = ['repair_machinery_hds_id'];
}
