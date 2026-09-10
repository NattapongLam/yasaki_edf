<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckFormDt extends Model
{
    use HasFactory;
    protected $table = 'check_form_dts';
    protected $primaryKey = 'check_form_dts_id';
    protected $guarded = [];
}
