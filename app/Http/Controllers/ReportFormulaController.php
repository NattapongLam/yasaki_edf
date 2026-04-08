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
            ->whereIn('SampleSet',['N1','N2','N3'])
            ->orderBy('TestID')
            ->orderBy('SampleSet')
            ->orderBy('Listno')
            ->get();

        $temps = [100,150,200,250,300,350,'Fall'];

        $result = [];

        foreach($temps as $t){

            $keyU = "Friction{$t}_u";
            $keyC = "Friction{$t}_c";

            foreach(
                $rows->groupBy(['TestID','SampleSet'])
                as $testID => $sampleGroups
            ){

                foreach($sampleGroups as $sampleSet => $items){

                    $result[$t]['labels'] =
                        $items->pluck('Listno');

                    $result[$t]['u'][$testID][$sampleSet] =
                        $items->pluck($keyU)->map(fn($v)=>(float)$v);

                    $result[$t]['c'][$testID][$sampleSet] =
                        $items->pluck($keyC)->map(fn($v)=>(float)$v);

                }
            }
        }

        return response()->json($result);
    }

    public function PrintCompareFormula($id)
    {
        $hd = DB::table('TestHeaders')
            ->where('TestID',$id)
            ->first();

        if(!$hd){
            abort(404);
        }

        $friction = DB::table('TestFrictions')
            ->where('TestID',$id)
            ->orderBy('Listno')
            ->get();

        $dt = DB::table('TestDetails')
        ->select(
            'Temperature',

            DB::raw("
                MAX(CASE WHEN SampleSet='N1'
                THEN (T_Inc + T_Dec)/2 END) as F1
            "),

            DB::raw("
                MAX(CASE WHEN SampleSet='N2'
                THEN (T_Inc + T_Dec)/2 END) as F2
            "),

            DB::raw("
                MAX(CASE WHEN SampleSet='N3'
                THEN (T_Inc + T_Dec)/2 END) as F3
            "),

            DB::raw("
                MAX(CASE WHEN SampleSet='N1'
                THEN WearRate END) as W1
            "),

            DB::raw("
                MAX(CASE WHEN SampleSet='N2'
                THEN WearRate END) as W2
            "),

            DB::raw("
                MAX(CASE WHEN SampleSet='N3'
                THEN WearRate END) as W3
            "),

            DB::raw("
                AVG(
                    CASE
                    WHEN SampleSet IN ('N1','N2','N3')
                    THEN (T_Inc + T_Dec)/2
                    END
                ) as FAvg
            "),

            DB::raw("
                AVG(
                    CASE
                    WHEN SampleSet IN ('N1','N2','N3')
                    THEN WearRate
                    END
                ) as WAvg
            ")

        )
        ->where('TestID',$id)
        ->groupBy('Temperature')
        ->orderBy('Temperature')
        ->get(); 
        $frictionPoints = $dt->pluck('FAvg','Temperature');   // FAvg chart
        $wearRatePoints = $dt->pluck('WAvg','Temperature');   // WAvg chart
        /*
        |--------------------------------------------------------------------------
        | zone config (แทน JISStandardResolver)
        |--------------------------------------------------------------------------
        */

        $targetMu   = 0.45;   // DefaultDesignated
        $tolerance  = 0.08;   // ±
        $jisMaxVal  = 0.55;
        $jisMinVal  = 0.35;


        /*
        |--------------------------------------------------------------------------
        | build zone arrays ตาม Temperature จริง
        |--------------------------------------------------------------------------
        */

        $temps = $dt->pluck('Temperature')->values();

        $safeUpper = [];
        $safeLower = [];

        $jisMax = [];
        $jisMin = [];

        $targetUpper = [];
        $targetLower = [];

        foreach($temps as $t){

            $safeUpper[] = $targetMu + $tolerance;
            $safeLower[] = $targetMu - $tolerance;

            $jisMax[] = $jisMaxVal;
            $jisMin[] = $jisMinVal;

            $targetUpper[] = $targetMu + $tolerance;
            $targetLower[] = $targetMu - $tolerance;
        }
        return view(
            'report.report-compareformulas-print',compact(
                'hd','friction','dt','frictionPoints','wearRatePoints','temps','safeUpper','safeLower','jisMin','jisMax','targetUpper','targetLower'
            )
        );
    }
}
