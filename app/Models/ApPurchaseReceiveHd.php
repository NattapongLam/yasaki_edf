<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApPurchaseReceiveHd extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ap_purchase_receive_hds';
    protected $primaryKey = 'ap_purchase_receive_hds_id';
    protected $guarded = ['ap_purchase_receive_hds_id'];
}
