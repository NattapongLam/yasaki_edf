<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherDistrict extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'other_districts';
    protected $primaryKey = 'other_districts_id';
    protected $guarded = ['other_districts_id'];
    public function SubDistrict()
    {
        return $this->hasMany(OtherSubDistrict::class, 'other_districts_id', 'other_districts_id');
    }
    public function Province()
    {
        return $this->belongsTo(OtherProvince::class, 'other_provinces_id', 'other_provinces_id');
    }
}
