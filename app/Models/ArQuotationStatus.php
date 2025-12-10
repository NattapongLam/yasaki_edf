<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArQuotationStatus extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ar_quotation_statuses';
    protected $primaryKey = 'ar_quotation_statuses_id';
    protected $guarded = ['ar_quotation_statuses_id'];
}
