<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApVendorGroup extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ap_vendor_groups';
    protected $primaryKey = 'ap_vendor_groups_id';
    protected $guarded = ['ap_vendor_groups_id'];
    public function Vendors()
    {
        return $this->hasMany(ApVendorList::class, 'ap_vendor_groups_id', 'ap_vendor_groups_id');
    }
}
