<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocCar extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'doc_cars';
    protected $primaryKey = 'doc_cars_id';
    protected $guarded = ['doc_cars_id'];
}
