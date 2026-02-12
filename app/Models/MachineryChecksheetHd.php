<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineryChecksheetHd extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'machinery_checksheet_hds';
    protected $primaryKey = 'machinery_checksheet_hds_id';
    protected $guarded = ['machinery_checksheet_hds_id'];
}
