<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineryPlanSub extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'machinery_plan_subs';
    protected $primaryKey = 'machinery_plan_subs_id';
    protected $guarded = ['machinery_plan_subs_id'];
}
