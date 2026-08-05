<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerComplaintsList extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'customer_complaints_lists';
    protected $primaryKey = 'customer_complaints_lists_id';
    protected $guarded = ['customer_complaints_lists_id'];
}
