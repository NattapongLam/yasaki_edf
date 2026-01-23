<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArInvoiceHd extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ar_invoice_hds';
    protected $primaryKey = 'ar_invoice_hds_id';
    protected $guarded = ['ar_invoice_hds_id'];
}
