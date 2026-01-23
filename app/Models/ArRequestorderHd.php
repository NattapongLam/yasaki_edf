<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArRequestorderHd extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ar_requestorder_hds';
    protected $primaryKey = 'ar_requestorder_hds_id';
    protected $guarded = ['ar_requestorder_hds_id'];
}
