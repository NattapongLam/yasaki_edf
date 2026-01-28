<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApPurchaseReceiveStatus extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ap_purchase_receive_statuses';
    protected $primaryKey = 'ap_purchase_receive_statuses_id';
    protected $guarded = ['ap_purchase_receive_statuses_id'];
}
