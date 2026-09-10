<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckFormHd extends Model
{
    use HasFactory;
    protected $table = 'check_form_hds';
    protected $primaryKey = 'check_form_hds_id';
    protected $guarded = [];
}
