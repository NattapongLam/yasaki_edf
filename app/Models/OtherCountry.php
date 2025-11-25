<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherCountry extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'other_countries';
    protected $primaryKey = 'other_countries_id';
    protected $guarded = ['other_countries_id'];
    public function Province()
    {
        return $this->hasMany(OtherProvince::class, 'other_countries_id', 'other_countries_id');
    }
}
