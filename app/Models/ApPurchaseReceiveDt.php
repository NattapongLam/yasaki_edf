<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApPurchaseReceiveDt extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ap_purchase_receive_dts';
    protected $primaryKey = 'ap_purchase_receive_dts_id';
    protected $guarded = ['ap_purchase_receive_dts_id'];
}
