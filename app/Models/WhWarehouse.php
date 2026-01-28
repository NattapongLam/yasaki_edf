<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhWarehouse extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'wh_warehouses';
    protected $primaryKey = 'wh_warehouses_id';
    protected $guarded = ['wh_warehouses_id'];
}
