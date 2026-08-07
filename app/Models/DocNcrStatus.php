<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocNcrStatus extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'doc_ncr_statuses';
    protected $primaryKey = 'doc_ncr_statuses_id';
    protected $guarded = ['doc_ncr_statuses_id'];
}
