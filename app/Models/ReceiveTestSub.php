<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiveTestSub extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'receive_test_subs';
    protected $primaryKey = 'receive_test_subs_id';
    protected $guarded = ['receive_test_subs_id'];
}
