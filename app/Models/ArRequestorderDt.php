<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArRequestorderDt extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ar_requestorder_dts';
    protected $primaryKey = 'ar_requestorder_dts_id';
    protected $guarded = ['ar_requestorder_dts_id'];
}
