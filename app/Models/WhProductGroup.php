<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhProductGroup extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'wh_product_groups';
    protected $primaryKey = 'wh_product_groups_id';
    protected $guarded = ['wh_product_groups_id'];
}
