<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportFormulaController extends Controller
{
    public function CompareFormulas(Request $request)
    {
        $hd = DB::table('TestHeaders')->get();
        $group = DB::table('ms_formule')->get();       
        return view('report.report-compareformulas', compact('hd','group'));
    }

    public function GetCompareFormulas(Request $request)
    {
        $query = DB::table('TestHeaders');

        // filter สูตร
        if ($request->filled('formula')) {
            $query->where('FormulaName', $request->formula);
        }

        // filter วันที่
        if ($request->filled('date_from')) {
            $query->whereDate('TestDate', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('TestDate', '<=', $request->date_to);
        }

        $hd = $query->orderBy('TestDate','desc')->get();

        $group = DB::table('ms_formule')
            ->orderBy('ms_formule_name')
            ->get();

        return view('report.report-compareformulas',
            compact('hd','group')
        );
    }
    public function getFrictionChart(Request $request)
    {
        $ids = $request->testIDs ?? [];

        $rows = DB::table('TestFrictions')
            ->whereIn('TestID',$ids)
            //->where('SampleSet','N1')
            ->orderBy('TestID')
            ->orderBy('Listno')
            ->get();

        $temps = [100,150,200,250,300,350,'Fall'];

        $result = [];

        foreach($temps as $t){

            $keyU = "Friction{$t}_u";
            $keyC = "Friction{$t}_c";

            foreach($rows->groupBy('TestID') as $testID => $items){

                $result[$t]['labels'] = $items->pluck('Listno');

                $result[$t]['u'][$testID] = $items->pluck($keyU);
                $result[$t]['c'][$testID] = $items->pluck($keyC);

            }

        }

        return response()->json($result);
    }
}
