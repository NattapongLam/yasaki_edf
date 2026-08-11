<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocRiskDt extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'doc_risk_dts';
    protected $primaryKey = 'doc_risk_dts_id';
    protected $guarded = ['doc_risk_dts_id'];
}
