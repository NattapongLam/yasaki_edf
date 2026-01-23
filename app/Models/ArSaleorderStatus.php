<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArSaleorderStatus extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ar_saleorder_statuses';
    protected $primaryKey = 'ar_saleorder_statuses_id';
    protected $guarded = ['ar_saleorder_statuses_id'];
}
