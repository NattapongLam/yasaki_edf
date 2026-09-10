<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntermediateCheckDt extends Model
{
    use HasFactory;
    protected $table = 'intermediate_check_dts';
    protected $primaryKey = 'intermediate_check_dts_id';
    protected $guarded = [];
}
