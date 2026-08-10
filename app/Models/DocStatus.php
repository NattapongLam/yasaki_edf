<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocStatus extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'doc_statuses';
    protected $primaryKey = 'doc_statuses_id';
    protected $guarded = ['doc_statuses_id'];
}
