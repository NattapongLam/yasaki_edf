<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhProductList extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'wh_product_lists';
    protected $primaryKey = 'wh_product_lists_id';
    protected $guarded = ['wh_product_lists_id'];
    public function Units()
    {
        return $this->belongsTo(WhProductUnit::class, 'wh_product_units_id', 'wh_product_units_id');
    }
    public function Groups()
    {
        return $this->belongsTo(WhProductGroup::class, 'wh_product_groups_id', 'wh_product_groups_id');
    }
    public function Types()
    {
        return $this->belongsTo(WhProductType::class, 'wh_product_types_id', 'wh_product_types_id');
    }
}
