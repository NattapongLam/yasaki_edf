<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChemicalGroup extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'chemical_groups';
    protected $primaryKey = 'chemical_groups_id';
    protected $guarded = ['chemical_groups_id'];
    public function Funtions()
    {
        return $this->hasMany(ChemicalFuntion::class, 'chemical_groups_id', 'chemical_groups_id');
    }
}
