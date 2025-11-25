<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccTypevat extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'acc_typevats';
    protected $primaryKey = 'acc_typevats_id';
    protected $guarded = ['acc_typevats_id'];
}
