<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocNcr extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'doc_ncrs';
    protected $primaryKey = 'doc_ncrs_id';
    protected $guarded = ['doc_ncrs_id'];
}
