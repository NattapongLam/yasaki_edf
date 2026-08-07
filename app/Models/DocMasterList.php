<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocMasterList extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'doc_master_lists';
    protected $primaryKey = 'doc_master_lists_id';
    protected $guarded = ['doc_master_lists_id'];
    protected $casts = [
        'doc_master_lists_options' => 'array',
    ];
}
