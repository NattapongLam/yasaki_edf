<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntermediateCheckHd extends Model
{
    use HasFactory;
    protected $table = 'intermediate_check_hds';
    protected $primaryKey = 'intermediate_check_hds_id';
    protected $guarded = []; 
}
