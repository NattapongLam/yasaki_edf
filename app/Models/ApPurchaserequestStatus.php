<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApPurchaserequestStatus extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ap_purchaserequest_statuses';
    protected $primaryKey = 'ap_purchaserequest_statuses_id';
    protected $guarded = ['ap_purchaserequest_statuses_id'];
}
