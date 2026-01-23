<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArSaleorderHd extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ar_saleorder_hds';
    protected $primaryKey = 'ar_saleorder_hds_id';
    protected $guarded = ['ar_saleorder_hds_id'];
}
