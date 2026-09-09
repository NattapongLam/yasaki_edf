<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProficiencyTestResult extends Model
{
    use HasFactory;

    protected $table = 'proficiency_test_results';
    protected $primaryKey = 'proficiency_test_results_id';

    protected $fillable = [
        'receive_test_lists_id',
        'proficiency_test_results_no',
        'reportsize',
        'sizeuncertainty',
        'refvalue',
        'sizecurve1',
        'sizecurve2',
        'sizecurve3',
        'sizecurve4',
        'labuncertainty',
        'sizename',
        'ratiocurve1',
        'ratiocurve2',
        'ratiocurve3',
        'ratiocurve4',
        'evaluation',
        'proficiency_test_results_date',
        'person_at',
        'approved_date',
        'approved_at',
        'proficiency_test_results_flag',
        'measuring_instrument'
    ];
}
