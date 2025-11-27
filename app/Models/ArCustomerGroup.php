<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArCustomerGroup extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ar_customer_groups';
    protected $primaryKey = 'ar_customer_groups_id';
    protected $guarded = ['ar_customer_groups_id'];
    public function Customers()
    {
        return $this->hasMany(ArCustomerList::class, 'ar_customer_groups_id', 'ar_customer_groups_id');
    }
}
