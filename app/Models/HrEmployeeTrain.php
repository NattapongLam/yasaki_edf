<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrEmployeeTrain extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'hr_employee_trains';
    protected $primaryKey = 'hr_employee_trains_id';
    protected $guarded = ['hr_employee_trains_id'];
}
