<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairMachineryStatus extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'repair_machinery_statuses';
    protected $primaryKey = 'repair_machinery_statuses_id';
    protected $guarded = ['repair_machinery_statuses_id'];
}
