<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArCustomerList extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ar_customer_lists';
    protected $primaryKey = 'ar_customer_lists_id';
    protected $guarded = ['ar_customer_lists_id'];
    public function Groups()
    {
        return $this->belongsTo(ArCustomerGroup::class, 'ar_customer_groups_id', 'ar_customer_groups_id');
    }
}
