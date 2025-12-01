<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApVendorList extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ap_vendor_lists';
    protected $primaryKey = 'ap_vendor_lists_id';
    protected $guarded = ['ap_vendor_lists_id'];
    public function Groups()
    {
        return $this->belongsTo(ApVendorGroup::class, 'ap_vendor_groups_id', 'ap_vendor_groups_id');
    }
}
