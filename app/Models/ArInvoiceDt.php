<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArInvoiceDt extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ar_invoice_dts';
    protected $primaryKey = 'ar_invoice_dts_id';
    protected $guarded = ['ar_invoice_dts_id'];
}
