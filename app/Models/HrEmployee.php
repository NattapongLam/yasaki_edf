<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrEmployee extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'hr_employees';
    protected $primaryKey = 'hr_employees_id';
    protected $guarded = ['hr_employees_id'];
    public function details()
    {
        return $this->hasMany(HrEmployeeTrain::class, 'hr_employees_id', 'hr_employees_id');
    }
}
