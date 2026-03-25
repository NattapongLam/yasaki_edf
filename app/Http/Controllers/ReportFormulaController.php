<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportFormulaController extends Controller
{
    public function CompareFormulas(Request $request)
    {
        $hd = DB::table('TestHeaders')->get();
        return view('report.report-compareformulas', compact('hd'));
    }

    public function getFrictionChart(Request $request)
    {
        $ids = $request->testIDs ?? [];

        $rows = DB::table('TestFrictions')
            ->whereIn('TestID',$ids)
            ->where('SampleSet','N1')
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
