<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineryList extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'machinery_lists';
    protected $primaryKey = 'machinery_lists_id';
    protected $guarded = ['machinery_lists_id'];
     public function Groups()
    {
        return $this->belongsTo(MachineryGroup::class, 'machinery_groups_id', 'machinery_groups_id');
    }
}
