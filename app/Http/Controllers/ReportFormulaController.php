<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportFormulaController extends Controller
{
    public function CompareFormulas(Request $request)
    {
        $hd = DB::table('vw_formula_datefeeavg')->get();
        return view('report.report-compareformulas', compact('hd'));
    }
}
