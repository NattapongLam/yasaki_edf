<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierEvaluation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'supplier_evaluations';
    protected $primaryKey = 'supplier_evaluations_id';
    protected $guarded = ['supplier_evaluations_id'];
}
