<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherSubDistrict extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'other_sub_districts';
    protected $primaryKey = 'other_sub_districts_id';
    protected $guarded = ['other_sub_districts_id'];
    public function District()
    {
        return $this->belongsTo(OtherDistrict::class, 'other_districts_id', 'other_districts_id');
    }
}
