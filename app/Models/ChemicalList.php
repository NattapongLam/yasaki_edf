<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChemicalList extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'chemical_lists';
    protected $primaryKey = 'chemical_lists_id';
    protected $guarded = ['chemical_lists_id'];
    public function Groups()
    {
        return $this->hasMany(ChemicalGroup::class, 'chemical_groups_id', 'chemical_groups_id');
    }
}
