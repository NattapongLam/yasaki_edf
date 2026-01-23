<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArRequestorderStatus extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ar_requestorder_statuses';
    protected $primaryKey = 'ar_requestorder_statuses_id';
    protected $guarded = ['ar_requestorder_statuses_id'];
}
