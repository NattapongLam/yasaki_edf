<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineryGroup extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'machinery_groups';
    protected $primaryKey = 'machinery_groups_id';
    protected $guarded = ['machinery_groups_id'];
}
