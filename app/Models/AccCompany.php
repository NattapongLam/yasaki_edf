<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccCompany extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'acc_companies';
    protected $primaryKey = 'acc_companies_id';
    protected $guarded = ['acc_companies_id'];
}
