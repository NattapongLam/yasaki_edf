<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApPurchaseorderHd extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ap_purchaseorder_hds';
    protected $primaryKey = 'ap_purchaseorder_hds_id';
    protected $guarded = ['ap_purchaseorder_hds_id'];
}
