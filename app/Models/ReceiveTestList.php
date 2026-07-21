<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiveTestList extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'receive_test_lists';
    protected $primaryKey = 'receive_test_lists_id';
    protected $guarded = ['receive_test_lists_id'];
}
