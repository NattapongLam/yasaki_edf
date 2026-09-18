<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSatisfactionSurvey extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'customer_satisfaction_surveys';
    protected $primaryKey = 'customer_satisfaction_surveys_id';
    protected $guarded = ['customer_satisfaction_surveys_id'];
}
