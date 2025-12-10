<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArQuotationHd extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ar_quotation_hds';
    protected $primaryKey = 'ar_quotation_hds_id';
    protected $guarded = ['ar_quotation_hds_id'];
}
