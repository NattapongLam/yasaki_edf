<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveredTestHd extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'delivered_test_hds';
    protected $primaryKey = 'delivered_test_hds_id';
    protected $guarded = ['delivered_test_hds_id'];
}
