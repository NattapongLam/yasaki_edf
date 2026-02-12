<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineryPlan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'machinery_plans';
    protected $primaryKey = 'machinery_plans_id';
    protected $guarded = ['machinery_plans_id'];
}
