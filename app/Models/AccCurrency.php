<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccCurrency extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'acc_currencies';
    protected $primaryKey = 'acc_currencies_id';
    protected $guarded = ['acc_currencies_id'];
}
