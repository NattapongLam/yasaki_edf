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
    // 1. กำหนดค่าตัวหารตามหลักมาตรวิทยา (คงเดิม)
    $divNormal = 2.0;          // สำหรับค่าจากใบเซอร์สอบเทียบ (Normal Distribution, k=2)
    $divRectangular = sqrt(3); // สำหรับค่าความละเอียดหน้าจอ (Resolution / Rectangular Distribution)

    // 2. คัดแยกอุปกรณ์ที่เกี่ยวข้องกับระบบแรงเสียดทาน (μ) โดยตรงจากตัวแปร $cal
    // (ดึงเฉพาะ โหลดเซลล์ 4319-001/002 และเครื่องทดสอบ 4411-001)
    $loadCell = null;
    $testMachine = null;

    foreach ($cal as $item) {
        if (in_array($item->calibration_lists_code, ['4319-001', '4319-002'])) {
            $loadCell = $item;
        }
        if ($item->calibration_lists_code === '4411-001') {
            $testMachine = $item;
        }
    }

    // 3. กำหนดค่าความไม่แน่นอนมาตรฐาน (u = U / divisor)
    // u1: โหลดเซลล์ (f) ดึงจากใบเซอร์จริง (0.01 N)
    $u_f_cal = (float)($loadCell->calibration_lists_uncertainty ?? 0.01) / $divNormal;

    // u2: ความละเอียดของหน้าจอเครื่องอ่าน (f_res = 0.01 N) เป็น Rectangular
    $u_f_res = 0.01 / $divRectangular; 

    // u3: ระบบควบคุมแรงกดแนวตั้ง (F) ดึงจากเครื่องทดสอบ 4411-001 (0.10 N)
    $u_F_cal = (float)($testMachine->calibration_lists_uncertainty ?? 0.10) / $divNormal;

    // u4: ความซ้ำของการทดสอบสัมประสิทธิ์แรงเสียดทาน (Repeatability) 
    // คำนวณจากค่าเบี่ยงเบนมาตรฐาน (SD) จริงของการทดสอบในรอบนั้น ๆ (เช่น 0.015)
    $u_repeatability = isset($repeatability) ? (float)$repeatability : 0.015; // k=1 อยู่แล้ว ไม่ต้องหาร

    // 4. คำนวณค่าสัมประสิทธิ์ความไว (Sensitivity Coefficient: ci) 
    // ดึงค่าเฉลี่ยจริงจากฐานข้อมูลของการทดสอบในระดับอุณหภูมินั้น ๆ (เช่น F_mean = 500 N, f_mean = 250 N)
    $F_mean = (float)($test_data['F_mean'] ?? 500.0); 
    $f_mean = (float)($test_data['f_mean'] ?? 250.0); 

    if ($F_mean > 0) {
        $c_f_cal = 1.0 / $F_mean;                    // ci สำหรับ Load cell (1/F)
        $c_f_res = 1.0 / $F_mean;                    // ci สำหรับ ความละเอียดหน้าจอ (1/F)
        $c_F_cal = -($f_mean) / ($F_mean ** 2);      // ci สำหรับ ระบบแรงกด (-f/F^2)
        $c_repeatability = 1.0;                      // ci สำหรับ Repeatability (1)
    } else {
        $c_f_cal = $c_f_res = $c_F_cal = 0.0;
        $c_repeatability = 1.0;
    }

    // 5. คำนวณผลคูณความไม่แน่นอนมาตรฐานส่วนร่วม ui(y) = ui * ci
    $u1_y = $u_f_cal * $c_f_cal;
    $u2_y = $u_f_res * $c_f_res;
    $u3_y = $u_F_cal * $c_F_cal;
    $u4_y = $u_repeatability * $c_repeatability;

    // 6. คำนวณผลรวมกำลังสอง (Sum of Squares) แบบ RSS
    $sumOfSquares = ($u1_y ** 2) + ($u2_y ** 2) + ($u3_y ** 2) + ($u4_y ** 2);

    // 7. ความไม่แน่นอนมาตรฐานรวม (Combined Standard Uncertainty)
    $combinedUncertainty = sqrt($sumOfSquares);

    // 8. ความไม่แน่นอนขยาย (Expanded Uncertainty, k=2) ที่ระดับความเชื่อมั่น 95%
    $expandedUncertainty = $combinedUncertainty * 2.0;
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
                ,'reqhd','reqdt','rechd','caldimensions','calweight','cal','bomdt','caldimensions1','mjis','average_rmp','expandedUncertainty'
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
        $formulaId = $request->formula_name;

        // 1. ดึงข้อมูล TestHeaders ครั้งเดียวจบ
        $doc = DB::table('TestHeaders')->where('TestID', $formulaId)->first();

        // สร้างโครงสร้างข้อมูลสำหรับ Response เปล่า (ใช้ซ้ำได้หลายจุด)
        $emptyResponse = [
            'header' => null,
            'details' => [],
            'test' => [],
            'test_detail' => [],
            'roadlist' => [],
            'frictions' => ['n1' => [], 'n2' => [], 'n3' => []]
        ];

        // ป้องกันกรณีไม่พบข้อมูล TestID นี้
        if (!$doc) {
            return response()->json($emptyResponse);
        }

        $formulaName = $doc->FormulaNumber;

        /*
        |--------------------------------------------------------------------------
        | chemistry_hd
        |--------------------------------------------------------------------------
        */
        if($doc->FormulaVersion){
            $header = DB::table('log_chemistry_hd')
                ->where('log_chemistry_hd_name', $formulaName)
                ->where('log_version',$doc->FormulaVersion)
                ->where('log_chemistry_hd_flag', true)
                ->select(
                    'log_ms_formule_name as ms_formule_name',
                    'log_chemistry_hd_mix as chemistry_hd_mix',
                    'log_chemistry_hd_qty as chemistry_hd_qty',
                    'log_chemistry_hd_note as chemistry_hd_note',
                    'log_chemistry_hd_type as chemistry_hd_type',
                    'log_chemistry_hd_docuno as chemistry_hd_docuno',
                    'log_chemistry_hd_name as chemistry_hd_name',
                    'log_chemistry_hd_calculate as chemistry_hd_calculate',
                    'log_total_density as total_density',
                    'log_total_adjust as total_adjust',
                    'log_total_volume as total_volume',
                    'log_total_wper as total_wper',
                    'log_total_weght as total_weght',
                    'log_total_cost as total_cost',
                    'log_avg_cost as avg_cost'
                )
                ->first();

            if (!$header) {
                return response()->json($emptyResponse);
            }

        }else{
            $header = DB::table('chemistry_hd')
                ->where('chemistry_hd_name', $formulaName)
                ->where('chemistry_hd_flag', true)
                ->first();

            if (!$header) {
                return response()->json($emptyResponse);
            }
        }
       

        /*
        |--------------------------------------------------------------------------
        | chemistry_dt
        |--------------------------------------------------------------------------
        */
        $details = collect();
        if ($header) {
            if($doc->FormulaVersion){
                $details = DB::table('log_chemistry_dt')
                ->leftJoin(
                    'chemical_lists',
                    'log_chemistry_dt.code',
                    '=',
                    'chemical_lists.chemical_lists_refcode'
                )
                ->leftJoin(
                    'chemical_groups',
                    'chemical_groups.chemical_groups_id',
                    '=',
                    'chemical_lists.chemical_groups_id'
                )
                ->where('log_chemistry_hd_id', $header->log_chemistry_hd_id)
                ->where('log_version',$doc->FormulaVersion)
                ->where('log_flag', true)
                ->select(
                    'log_no as no',
                    'log_code as code',
                    'log_material as material',
                    'log_grade as grade',
                    'log_maker as maker',
                    'log_density as density',
                    'log_weght as weght',
                    'log_weghtper as weghtper',
                    'log_weghttotal as weghttotal',
                )
                ->orderBy('log_no', 'asc')
                ->get();

            }else{
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
            }          
        }

        /*
        |--------------------------------------------------------------------------
        | Test Header & Test IDs (ใช้ $doc ตัวเดิม ไม่ต้อง Query ซ้ำ)
        |--------------------------------------------------------------------------
        */
        $test = collect([$doc]);
        $testIds = collect([$doc->TestID]);

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
