<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChemicalSub extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'chemical_subs';
    protected $primaryKey = 'chemical_subs_id';
    protected $guarded = ['chemical_subs_id'];
}
