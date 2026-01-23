<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArInvoiceStatus extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ar_invoice_statuses';
    protected $primaryKey = 'ar_invoice_statuses_id';
    protected $guarded = ['ar_invoice_statuses_id'];
}
