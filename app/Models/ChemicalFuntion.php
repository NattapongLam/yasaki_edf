<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChemicalFuntion extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'chemical_funtions';
    protected $primaryKey = 'chemical_funtions_id';
    protected $guarded = ['chemical_funtions_id'];
    public function Groups()
    {
        return $this->hasMany(ChemicalGroup::class, 'chemical_groups_id', 'chemical_groups_id');
    }
}
