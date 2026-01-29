<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhIssuestockStatus extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'wh_issuestock_statuses';
    protected $primaryKey = 'wh_issuestock_statuses_id';
    protected $guarded = ['wh_issuestock_statuses_id'];
}
