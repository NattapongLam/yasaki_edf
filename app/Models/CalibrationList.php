<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalibrationList extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'calibration_lists';
    protected $primaryKey = 'calibration_lists_id';
    protected $guarded = ['calibration_lists_id'];
    public function Categorys()
    {
        return $this->belongsTo(CalibrationCategory::class, 'calibration_categories_id', 'calibration_categories_id');
    }
    public function Groups()
    {
        return $this->belongsTo(CalibrationGroup::class, 'calibration_groups_id', 'calibration_groups_id');
    }
    public function Types()
    {
        return $this->belongsTo(CalibrationType::class, 'calibration_types_id', 'calibration_types_id');
    }
    public function Vendor()
    {
        return $this->belongsTo(ApVendorList::class, 'ap_vendor_lists_id', 'ap_vendor_lists_id');
    }
}
