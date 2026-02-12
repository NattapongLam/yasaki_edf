<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineryChecksheetDt extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'machinery_checksheet_dts';
    protected $primaryKey = 'machinery_checksheet_dts_id';
    protected $guarded = ['machinery_checksheet_dts_id'];
}
