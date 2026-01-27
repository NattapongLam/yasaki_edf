<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApPurchaseorderDt extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ap_purchaseorder_dts';
    protected $primaryKey = 'ap_purchaseorder_dts_id';
    protected $guarded = ['ap_purchaseorder_dts_id'];
}
