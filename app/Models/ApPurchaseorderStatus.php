<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApPurchaseorderStatus extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ap_purchaseorder_statuses';
    protected $primaryKey = 'ap_purchaseorder_statuses_id';
    protected $guarded = ['ap_purchaseorder_statuses_id'];
}
