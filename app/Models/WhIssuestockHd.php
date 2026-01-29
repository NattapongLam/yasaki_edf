<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhIssuestockHd extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'wh_issuestock_hds';
    protected $primaryKey = 'wh_issuestock_hds_id';
    protected $guarded = ['wh_issuestock_hds_id'];
}
