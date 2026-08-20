<?php

namespace App\Http\Controllers;

use App\Models\ArRequestorderDt;
use App\Models\ArRequestorderHd;
use App\Models\CalibrationList;
use App\Models\ReceiveTestList;
use App\Models\ReceiveTestSub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportFormulaController extends Controller
{
    public function CompareFormulas(Request $request)
    {
        $hd = DB::table('TestHeaders')
        ->leftjoin('chemistry_hd','TestHeaders.FormulaNumber','=','chemistry_hd.chemistry_hd_name')
        ->get();
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
                THEN CASE WHEN T_Dec = 0 OR T_Dec IS NULL THEN T_Inc ELSE (T_Inc + T_Dec)/2 END END) as F1
            "),

            DB::raw("
                MAX(CASE WHEN SampleSet='N2'
                THEN CASE WHEN T_Dec = 0 OR T_Dec IS NULL THEN T_Inc ELSE (T_Inc + T_Dec)/2 END END) as F2
            "),

            DB::raw("
                MAX(CASE WHEN SampleSet='N3'
                THEN CASE WHEN T_Dec = 0 OR T_Dec IS NULL THEN T_Inc ELSE (T_Inc + T_Dec)/2 END END) as F3
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
                    THEN CASE WHEN T_Dec = 0 OR T_Dec IS NULL THEN T_Inc ELSE (T_Inc + T_Dec)/2 END
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

        $targetMu   = 0.45;   // ค่าสัมประสิทธิ์แรงเสียดทานที่กำหนด ตาม JIS D 4411
        $tolerance  = 0.08;   // ค่าความเบี่ยงเบนที่ยอมรับได้ ตาม JIS D 4411
        $jisMaxVal  = 0.55;   // การคำนวณช่วงการยอมรับ ตาม JIS D 4411
        $jisMinVal  = 0.35;   // การคำนวณช่วงการยอมรับ ตาม JIS D 4411


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
        $reqhd = ArRequestorderHd::where('ar_requestorder_hds_docuno',$hd->Lot)->first();
        $reqdt = ArRequestorderDt::where('ar_requestorder_hds_id',$reqhd->ar_requestorder_hds_id)->where('ar_requestorder_dts_flag',true)->first();
        $rechd = ReceiveTestList::where('ar_requestorder_hds_id',$reqhd->ar_requestorder_hds_id)->where('receive_test_lists_flag',true)->first();
        $caldimensions = CalibrationList::where('calibration_lists_id',$rechd->dimensions_id)->first();
        $caldimensions1 = CalibrationList::where('calibration_lists_id',$rechd->dimensions_id1)->first();
        $calweight = CalibrationList::where('calibration_lists_id',$rechd->weight_id)->first();
        $cal = ReceiveTestSub::leftjoin('calibration_lists','receive_test_subs.calibration_lists_id','=','calibration_lists.calibration_lists_id')
        ->where('receive_test_subs.receive_test_lists_id',$rechd->receive_test_lists_id)
        ->where('receive_test_subs.receive_test_lists_flag',true)
        ->get();
        $bomhd = DB::table('chemistry_hd')->where('chemistry_hd_id',$rechd->chemistry_hd_id)->first();
        $bomdt = null;
        if($bomhd){
            $bomdt = DB::table('chemistry_dt')
            ->leftjoin('chemical_lists', 'chemistry_dt.code', '=', 'chemical_lists.chemical_lists_refcode')
            ->leftjoin('chemical_groups', 'chemical_groups.chemical_groups_id', '=', 'chemical_lists.chemical_groups_id')
            ->leftjoin('chemical_funtions', 'chemical_funtions.chemical_funtions_id', '=', 'chemical_lists.chemical_funtions_id')
            ->where('chemistry_hd_id', $bomhd->chemistry_hd_id)
            ->where('flag', 1)->get();
        }     
        $mjis = DB::table('ms_jisdclass')->where('ms_jisdclass_type',$reqdt->ar_requestorder_dts_jis_class)->get();
        $rmp1 = (($rechd->result_n1_rpm ?? 0) * (22 / 7) * 300) / (60 * 1000);
        $rmp2 = (($rechd->result_n2_rpm ?? 0) * (22 / 7) * 300) / (60 * 1000);
        $rmp3 = (($rechd->result_n3_rpm ?? 0) * (22 / 7) * 300) / (60 * 1000);
        $average_rmp = ($rmp1 + $rmp2 + $rmp3) / 3;
        return view(
            'report.report-compareformulas-print',compact(
                'hd','friction','dt','frictionPoints','wearRatePoints','temps','safeUpper','safeLower','jisMin','jisMax','targetUpper','targetLower'
                ,'reqhd','reqdt','rechd','caldimensions','calweight','cal','bomdt','caldimensions1','mjis','average_rmp'
            )
        );
    }

    public function AnalyzeFormulas(Request $request)
    {
        $hd = DB::table('TestHeaders')->get();      
        return view('report.report-analyzaformulas', compact('hd'));
    }

    public function getFormulaDetail(Request $request)
{
    // เปลี่ยนจาก get() เป็น first() เพื่อให้ได้ Object ของแถวแรกโดยตรง
    $doc = DB::table('TestHeaders')->where('TestID', $request->formula_name)->first();

    // ป้องกันกรณีไม่พบข้อมูล TestID นี้
    if (!$doc) {
        return response()->json([
            'header' => null,
            'details' => [],
            'test' => [],
            'test_detail' => [],
            'roadlist' => [],
            'frictions' => ['n1' => [], 'n2' => [], 'n3' => []]
        ]);
    }

    $formulaName = $doc->FormulaNumber;

    /*
    |--------------------------------------------------------------------------
    | chemistry_hd
    |--------------------------------------------------------------------------
    */
    $header = DB::table('chemistry_hd')
        ->where('chemistry_hd_name', $formulaName)
        ->where('chemistry_hd_flag', true)
        ->first();

    if (!$header) {
        return response()->json([
            'header' => null,
            'details' => [],
            'test' => [],
            'test_detail' => [],
            'roadlist' => [],
            'frictions' => ['n1' => [], 'n2' => [], 'n3' => []]
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | chemistry_dt
    |--------------------------------------------------------------------------
    */
    $details = DB::table('chemistry_dt')
        ->leftJoin(
            'chemical_lists',
            'chemistry_dt.code',
            '=',
            'chemical_lists.chemical_lists_refcode'
        )
        ->leftJoin(
            'chemical_groups',
            'chemical_groups.chemical_groups_id',
            '=',
            'chemical_lists.chemical_groups_id'
        )
        ->where('chemistry_hd_id', $header->chemistry_hd_id)
        ->where('flag', true)
        ->orderBy('no', 'asc')
        ->get();

    /*
    |--------------------------------------------------------------------------
    | Test Header & Test IDs (ใช้ตัวแปรชุดเดียวกันเพื่อความเร็วและลด Query ซ้ำ)
    |--------------------------------------------------------------------------
    */
    $test = DB::table('TestHeaders')
    ->where('TestID', $request->formula_name) // ดึงตาม TestID ที่เลือกโดยตรง ไม่ใช่หาตาม FormulaNumber ทั้งหมด
    ->get();

    $testIds = $test->pluck('TestID');

    /*
    |--------------------------------------------------------------------------
    | Test Frictions
    |--------------------------------------------------------------------------
    */
    if ($testIds->isEmpty()) {
        $frictions = collect();
    } else {
        $frictions = DB::table('TestFrictions')
        ->whereIn('TestID', $testIds)
        ->orderBy('Listno')
        ->get([
            'Listno',
            'SampleSet',
            'Friction100_u', 'Friction100_c',
            'Friction150_u', 'Friction150_c',
            'Friction200_u', 'Friction200_c',
            'Friction250_u', 'Friction250_c',
            'Friction300_u', 'Friction300_c',
            'Friction350_u', 'Friction350_c',
            'FrictionFall_u', 'FrictionFall_c',
        ]);
    }

    $frictionN1 = $frictions->filter(fn ($row) => str_contains(strtoupper($row->SampleSet ?? ''), 'N1'))->values();
    $frictionN2 = $frictions->filter(fn ($row) => str_contains(strtoupper($row->SampleSet ?? ''), 'N2'))->values();
    $frictionN3 = $frictions->filter(fn ($row) => str_contains(strtoupper($row->SampleSet ?? ''), 'N3'))->values();

    /*
    |--------------------------------------------------------------------------
    | Test Details & Road Lists
    |--------------------------------------------------------------------------
    */
    $testDetail = DB::table('TestDetails')
        ->whereIn('TestID', $testIds)
        ->where('Temperature', '<>', 0)
        ->get([
            'Temperature',
            'SampleSet',
            'WearRate',
            'T_Inc',
            'T_Dec'
        ]);

    $roadlist = DB::table('TestRoads')
        ->whereIn('TestID', $testIds)
        ->get([
            'LowSpeed1', 'LowSpeed4', 'LowSpeed5',
            'HighSpeed1', 'HighSpeed2', 'HighSpeed3', 'HighSpeed4', 'HighSpeed5',
            'Pillion1', 'Pillion2',
            'Avg5',
            'RoadTestRemark',
            'TestRoadName'
        ]);

    return response()->json([
        'header' => $header,
        'details' => $details,
        'test' => $test,
        'test_detail' => $testDetail,
        'roadlist' => $roadlist,
        'frictions' => [
            'n1' => $frictionN1,
            'n2' => $frictionN2,
            'n3' => $frictionN3,
        ]
    ]);
}
}
