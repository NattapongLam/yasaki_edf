<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocRiskHd extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'doc_risk_hds';
    protected $primaryKey = 'doc_risk_hds_id';
    protected $guarded = ['doc_risk_hds_id'];
    public function details()
    {
        return $this->hasMany(DocRiskDt::class, 'doc_risk_hds_id', 'doc_risk_hds_id');
    }
}
