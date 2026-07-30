<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveredTestDt extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'delivered_test_dts';
    protected $primaryKey = 'delivered_test_dts_id';
    protected $guarded = ['delivered_test_dts_id'];
}
