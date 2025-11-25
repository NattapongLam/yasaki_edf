<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccPeriod extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'acc_periods';
    protected $primaryKey = 'acc_periods_id';
    protected $guarded = ['acc_periods_id'];
}
