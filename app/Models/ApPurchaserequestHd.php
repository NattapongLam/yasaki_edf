<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApPurchaserequestHd extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ap_purchaserequest_hds';
    protected $primaryKey = 'ap_purchaserequest_hds_id';
    protected $guarded = ['ap_purchaserequest_hds_id'];
}
