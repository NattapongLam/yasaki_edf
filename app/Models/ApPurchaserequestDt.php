<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApPurchaserequestDt extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ap_purchaserequest_dts';
    protected $primaryKey = 'ap_purchaserequest_dts_id';
    protected $guarded = ['ap_purchaserequest_dts_id'];
}
