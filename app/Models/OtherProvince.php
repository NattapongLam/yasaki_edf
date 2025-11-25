<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherProvince extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'other_provinces';
    protected $primaryKey = 'other_provinces_id';
    protected $guarded = ['other_provinces_id'];
    public function Country()
    {
        return $this->belongsTo(OtherCountry::class, 'other_countries_id', 'other_countries_id');
    }
    public function District()
    {
        return $this->hasMany(OtherDistrict::class, 'other_provinces_id', 'other_provinces_id');
    }
}
