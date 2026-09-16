<?php

namespace App\Http\Controllers;

use App\Models\ArCustomerList;
use App\Models\ArRequestorderDt;
use App\Models\ArRequestorderHd;
use App\Models\CalibrationList;
use App\Models\CheckFormDt;
use App\Models\CheckFormHd;
use App\Models\IntermediateCheckDt;
use App\Models\IntermediateCheckHd;
use App\Models\OtherDistrict;
use App\Models\OtherProvince;
use App\Models\OtherSubDistrict;
use App\Models\ProficiencyTestResult;
use App\Models\ReceiveTestList;
use App\Models\ReceiveTestSub;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ReceiveTestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hd = ArRequestorderHd::leftjoin('ar_requestorder_statuses','ar_requestorder_hds.ar_requestorder_statuses_id','=','ar_requestorder_statuses.ar_requestorder_statuses_id')
        ->where('ar_requestorder_hds.ar_requestorder_statuses_id',2)
        ->get();
        return view('testsamples.form-receivetest-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hd = ArRequestorderHd::leftjoin('ar_requestorder_statuses','ar_requestorder_hds.ar_requestorder_statuses_id','=','ar_requestorder_statuses.ar_requestorder_statuses_id')
        ->leftjoin('receive_test_lists','ar_requestorder_hds.ar_requestorder_hds_id','=','receive_test_lists.ar_requestorder_hds_id')
        ->leftjoin('ar_requestorder_dts','ar_requestorder_hds.ar_requestorder_hds_id','=','ar_requestorder_dts.ar_requestorder_hds_id')
        ->where('ar_requestorder_hds.ar_requestorder_statuses_id',6)
        ->get();
        return view('testsamples.form-testsamples-list', compact('hd'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'ar_requestorder_hds_id' => ['required'],
            'receive_test_lists_date' => ['required'],
            'receive_test_lists_dimensions' => ['required'],
            'dimensions_id' => ['required'],
            'receive_test_lists_weight' => ['required'],
            'weight_id' => ['required'],
            'chemistry_hd_id' => ['required'],
            'dimensions_id1' => ['required'],
        ]);
        $data = [
            'ar_requestorder_hds_id' => $request->ar_requestorder_hds_id,
            'receive_test_lists_date' => $request->receive_test_lists_date,
            'receive_test_lists_dimensions' => $request->receive_test_lists_dimensions,
            'dimensions_id' => $request->dimensions_id,
            'receive_test_lists_weight' => $request->receive_test_lists_weight,
            'weight_id' => $request->weight_id,
            'chemistry_hd_id' => $request->chemistry_hd_id,
            'receive_test_lists_note' => $request->receive_test_lists_note,
            'person_at' => Auth::user()->name,
            'receive_test_lists_flag' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'dimensions_id1' => $request->dimensions_id1,
            'receive_n1_width1' => $request->receive_n1_width1,
            'receive_n1_width2' => $request->receive_n1_width2,
            'receive_n1_length1' => $request->receive_n1_length1,
            'receive_n1_length2' => $request->receive_n1_length2,
            'receive_n1_height1' => $request->receive_n1_height1,
            'receive_n1_height2' => $request->receive_n1_height2,
            'receive_n2_width1' => $request->receive_n2_width1,
            'receive_n2_width2' => $request->receive_n2_width2,
            'receive_n2_length1' => $request->receive_n2_length1,
            'receive_n2_length2' => $request->receive_n2_length2,
            'receive_n2_height1' => $request->receive_n2_height1,
            'receive_n2_height2' => $request->receive_n2_height2,
            'receive_n3_width1' => $request->receive_n3_width1,
            'receive_n3_width2' => $request->receive_n3_width2,
            'receive_n3_length1' => $request->receive_n3_length1,
            'receive_n3_length2' => $request->receive_n3_length2,
            'receive_n3_height1' => $request->receive_n3_height1,
            'receive_n3_height2' => $request->receive_n3_height2,
            'receive_n1_weight1' => $request->receive_n1_weight1,
            'receive_n1_weight2' => $request->receive_n1_weight2,
            'receive_n2_weight1' => $request->receive_n2_weight1,
            'receive_n2_weight2' => $request->receive_n2_weight2,
            'receive_n3_weight1' => $request->receive_n3_weight1,
            'receive_n3_weight2' => $request->receive_n3_weight2
        ];
        if ($request->hasFile('receive_test_lists_file1')) {
            $data['receive_test_lists_file1'] = $request->file('receive_test_lists_file1')->storeAs('images/Receivetest_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('receive_test_lists_file1')->extension());
        }
        if ($request->hasFile('receive_test_lists_file2')) {
            $data['receive_test_lists_file2'] = $request->file('receive_test_lists_file2')->storeAs('images/Receivetest_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('receive_test_lists_file2')->extension());
        }
        if ($request->hasFile('receive_test_lists_file3')) {
            $data['receive_test_lists_file3'] = $request->file('receive_test_lists_file3')->storeAs('images/Receivetest_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('receive_test_lists_file3')->extension());
        }
        try{
            DB::beginTransaction();
            $insertHD = ReceiveTestList::create($data);     
            ArRequestorderHd::where('ar_requestorder_hds_id',$request->ar_requestorder_hds_id)->update([
                'ar_requestorder_statuses_id' => 6
            ]);   
            DB::commit();
            return redirect()->route('receive-test.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        }catch(\Exception $e){
            Log::error($e->getMessage());
            dd($e->getMessage());
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด');
        }       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hd = ArRequestorderHd::find($id);
        $dt = ArRequestorderDt::where('ar_requestorder_hds_id',$id)->where('ar_requestorder_dts_flag',true)->get();
        $bom = DB::table('chemistry_hd')->where('chemistry_hd_flag',true)->get();
        $cal = CalibrationList::get();
        $pd = ReceiveTestList::where('ar_requestorder_hds_id',$id)->first();
        $test = DB::table('TestHeaders')->where('Lot',$hd->ar_requestorder_hds_docuno)->first();
        $cust = ArCustomerList::where('ar_customer_lists_name1',$hd->ar_requestorder_hds_customer)->first();
        $prov = OtherProvince::find($cust->other_provinces_id);
        $dist = OtherDistrict::find($cust->other_districts_id);
        $subd = OtherSubDistrict::find($cust->other_sub_districts_id);    
        return view('testsamples.form-testsamples-edit', compact('hd','dt','bom','cal','pd','test','cust','prov','dist','subd'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hd = ArRequestorderHd::find($id);
        $dt = ArRequestorderDt::where('ar_requestorder_hds_id',$id)->where('ar_requestorder_dts_flag',true)->get();
        $bom = DB::table('chemistry_hd')->where('chemistry_hd_flag',true)->get();
        $cal = CalibrationList::get();  
        $cust = ArCustomerList::where('ar_customer_lists_name1',$hd->ar_requestorder_hds_customer)->first();
        $prov = OtherProvince::find($cust->other_provinces_id);
        $dist = OtherDistrict::find($cust->other_districts_id);
        $subd = OtherSubDistrict::find($cust->other_sub_districts_id);    
        return view('testsamples.form-receivetest-edit', compact('hd','dt','bom','cal','cust','prov','dist','subd'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'result_test_lists_date' => ['required'],
            'result_test_lists_dimensions' => ['required'],
            'result_dimensions_id' => ['required'],
            'result_test_lists_weight' => ['required'],
            'result_weight_id' => ['required'],
            'receive_test_subs_listno' => ['required'],
            'result_dimensions_id1' => ['required'],
        ]);
        $data = [
            'result_test_lists_date' => $request->result_test_lists_date,
            'result_test_lists_dimensions' => $request->result_test_lists_dimensions,
            'result_dimensions_id' => $request->result_dimensions_id,
            'result_test_lists_weight' => $request->result_test_lists_weight,
            'result_weight_id' => $request->result_weight_id,
            'result_test_lists_note' => $request->receive_test_lists_note,
            'result_person_at' => Auth::user()->name,
            'updated_at' => Carbon::now(),
            'result_test_lists_temp' => $request->result_test_lists_temp,
            'result_test_lists_moisture' => $request->result_test_lists_moisture,
            'result_test_lists_plate' => $request->result_test_lists_plate,
            'result_test_lists_test' => $request->result_test_lists_test,
            'result_dimensions_id1' => $request->result_dimensions_id1,
            'result_test_lists_remark' => $request->result_test_lists_remark,
            'result_n1_width1' => $request->result_n1_width1,
            'result_n1_width2' => $request->result_n1_width2,
            'result_n1_length1' => $request->result_n1_length1,
            'result_n1_length2' => $request->result_n1_length2,
            'result_n1_height1' => $request->result_n1_height1,
            'result_n1_height2' => $request->result_n1_height2,
            'result_n2_width1' => $request->result_n2_width1,
            'result_n2_width2' => $request->result_n2_width2,
            'result_n2_length1' => $request->result_n2_length1,
            'result_n2_length2' => $request->result_n2_length2,
            'result_n2_height1' => $request->result_n2_height1,
            'result_n2_height2' => $request->result_n2_height2,
            'result_n3_width1' => $request->result_n3_width1,
            'result_n3_width2' => $request->result_n3_width2,
            'result_n3_length1' => $request->result_n3_length1,
            'result_n3_length2' => $request->result_n3_length2,
            'result_n3_height1' => $request->result_n3_height1,
            'result_n3_height2' => $request->result_n3_height2,
            'result_n1_weight1' => $request->result_n1_weight1,
            'result_n1_weight2' => $request->result_n1_weight2,
            'result_n2_weight1' => $request->result_n2_weight1,
            'result_n2_weight2' => $request->result_n2_weight2,
            'result_n3_weight1' => $request->result_n3_weight1,
            'result_n3_weight2' => $request->result_n3_weight2,
            'result100_n1temp' => $request->result100_n1temp,
            'result100_n1moisture' => $request->result100_n1moisture,
            'result100_n2temp' => $request->result100_n2temp,
            'result100_n2moisture' => $request->result100_n2moisture,
            'result100_n3temp' => $request->result100_n3temp,
            'result100_n3moisture' => $request->result100_n3moisture,
            'result150_n1temp' => $request->result150_n1temp,
            'result150_n1moisture' => $request->result150_n1moisture,
            'result150_n2temp' => $request->result150_n2temp,
            'result150_n2moisture' => $request->result150_n2moisture,
            'result150_n3temp' => $request->result150_n3temp,
            'result150_n3moisture' => $request->result150_n3moisture,
            'result200_n1temp' => $request->result200_n1temp,
            'result200_n1moisture' => $request->result200_n1moisture,
            'result200_n2temp' => $request->result200_n2temp,
            'result200_n2moisture' => $request->result200_n2moisture,
            'result200_n3temp' => $request->result200_n3temp,
            'result200_n3moisture' => $request->result200_n3moisture,
            'result250_n1temp' => $request->result250_n1temp,
            'result250_n1moisture' => $request->result250_n1moisture,
            'result250_n2temp' => $request->result250_n2temp,
            'result250_n2moisture' => $request->result250_n2moisture,
            'result250_n3temp' => $request->result250_n3temp,
            'result250_n3moisture' => $request->result250_n3moisture,
            'result300_n1temp' => $request->result300_n1temp,
            'result300_n1moisture' => $request->result300_n1moisture,
            'result300_n2temp' => $request->result300_n2temp,
            'result300_n2moisture' => $request->result300_n2moisture,
            'result300_n3temp' => $request->result300_n3temp,
            'result300_n3moisture' => $request->result300_n3moisture,
            'result350_n1temp' => $request->result350_n1temp,
            'result350_n1moisture' => $request->result350_n1moisture,
            'result350_n2temp' => $request->result350_n2temp,
            'result350_n2moisture' => $request->result350_n2moisture,
            'result350_n3temp' => $request->result350_n3temp,
            'result350_n3moisture' => $request->result350_n3moisture,
            'result_n1_rpm' => $request->result_n1_rpm,
            'result_n2_rpm' => $request->result_n2_rpm,
            'result_n3_rpm' => $request->result_n3_rpm,
        ];
        if ($request->hasFile('result_test_lists_file1')) {
            $data['result_test_lists_file1'] = $request->file('result_test_lists_file1')->storeAs('images/Receivetest_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('result_test_lists_file1')->extension());
        }
        if ($request->hasFile('result_test_lists_file2')) {
            $data['result_test_lists_file2'] = $request->file('result_test_lists_file2')->storeAs('images/Receivetest_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('result_test_lists_file2')->extension());
        }
        if ($request->hasFile('result_test_lists_file3')) {
            $data['result_test_lists_file3'] = $request->file('result_test_lists_file3')->storeAs('images/Receivetest_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('result_test_lists_file3')->extension());
        }
        try{
            DB::beginTransaction();
            $insertHD = ReceiveTestList::where('receive_test_lists_id',$id)->update($data);     
            ArRequestorderHd::where('ar_requestorder_hds_id',$request->ar_requestorder_hds_id)->update([
                'ar_requestorder_statuses_id' => 7
            ]);   
            foreach ($request->receive_test_subs_listno as $key => $value) {
                $dtData = [
                    'receive_test_lists_id' => $id,
                    'receive_test_subs_listno' => $value, 
                    'calibration_lists_id' => $request->calibration_lists_id[$key],
                    'receive_test_subs_note' => $request->receive_test_subs_note[$key],
                    'person_at' => Auth::user()->name,
                    'receive_test_lists_flag' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'receive_test_subs_time' => $request->receive_test_subs_time[$key],
                    'before_testing' => $request->before_testing[$key],
                    'after_testing' => $request->after_testing[$key],
                    'total_testing' => $request->total_testing[$key]
                ];
                ReceiveTestSub::insert($dtData);
            }
            DB::commit();
            return redirect()->route('receive-test.create')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        }catch(\Exception $e){
            Log::error($e->getMessage());
            dd($e->getMessage());
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด');
        }      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ReceiveResult(Request $request)
    {
        // กำหนดค่าเริ่มต้นเป็น วันแรก และ วันสุดท้าย ของเดือนปัจจุบัน
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        $query = ArRequestorderHd::leftjoin('ar_requestorder_statuses','ar_requestorder_hds.ar_requestorder_statuses_id','=','ar_requestorder_statuses.ar_requestorder_statuses_id')
            ->leftjoin('receive_test_lists','ar_requestorder_hds.ar_requestorder_hds_id','=','receive_test_lists.ar_requestorder_hds_id')
            ->leftjoin('chemistry_hd','chemistry_hd.chemistry_hd_id','=','receive_test_lists.chemistry_hd_id')
            ->leftjoin('TestHeaders','ar_requestorder_hds.ar_requestorder_hds_docuno','=','TestHeaders.Lot')
            ->where('ar_requestorder_hds.ar_requestorder_statuses_id', 7);

        // กรองตามช่วงวันที่ 
        // หมายเหตุ: กรุณาเปลี่ยน 'ar_requestorder_hds.created_at' ให้ตรงกับชื่อฟิลด์วันที่จริงในตาราง ar_requestorder_hds ของคุณ (เช่น created_at, date, หรือชื่ออื่นๆ)
        $query->whereBetween('ar_requestorder_hds.ar_requestorder_hds_date', [$startDate,$endDate]);

        $hd = $query->get();

        // ส่งตัวแปร $startDate และ $endDate กลับไปแสดงที่หน้า Blade ด้วย
        return view('testsamples.form-testsamples-result', compact('hd', 'startDate', 'endDate'));
    }

    public function confirmDelReceiveTest(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            ArRequestorderHd::where('ar_requestorder_hds_id',$id)->update([
                'ar_requestorder_statuses_id' => 3,
                'person_at' => Auth::user()->name,
                'updated_at'=> Carbon::now(),
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'ยกเลิกรายการเรียบร้อยแล้ว'
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function editDetail($id)
    {
        $hd = ArRequestorderHd::find($id);
        $dt = ArRequestorderDt::where('ar_requestorder_hds_id',$id)->where('ar_requestorder_dts_flag',true)->get();
        $bom = DB::table('chemistry_hd')->where('chemistry_hd_flag',true)->get();
        $cal = CalibrationList::get();
        $pd = ReceiveTestList::where('ar_requestorder_hds_id',$id)->first();
        $test = DB::table('TestHeaders')->where('Lot',$hd->ar_requestorder_hds_docuno)->first();
        $sub = ReceiveTestSub::leftjoin('calibration_lists','receive_test_subs.calibration_lists_id','=','calibration_lists.calibration_lists_id')
        ->where('receive_test_subs.receive_test_lists_id',$pd->receive_test_lists_id)->get();
        $cust = ArCustomerList::where('ar_customer_lists_name1',$hd->ar_requestorder_hds_customer)->first();
        $prov = OtherProvince::find($cust->other_provinces_id);
        $dist = OtherDistrict::find($cust->other_districts_id);
        $subd = OtherSubDistrict::find($cust->other_sub_districts_id);    
        return view('testsamples.form-testsamples-update', compact('hd','dt','bom','cal','pd','test','sub','cust','prov','dist','subd'));
    }
    public function updateReceiveTest(Request $request, $id)
    {
        // 1. ค้นหาข้อมูลหลัก (ตาม $id ของ receive_test_lists_id)
        $pd = ReceiveTestList::findOrFail($id); // เปลี่ยน Model ให้ตรงกับฐานข้อมูลของคุณ

        // 2. บันทึกข้อมูลอัปเดตจากฟอร์มชิ้นงานหลังทดสอบ
        $pd->update([
            'result_test_lists_date'     => $request->result_test_lists_date,
            'result_test_lists_dimensions' => $request->result_test_lists_dimensions,
            'result_dimensions_id'       => $request->result_dimensions_id,
            'result_dimensions_id1'      => $request->result_dimensions_id1,
            'result_test_lists_plate'    => $request->result_test_lists_plate,
            'result_test_lists_weight'   => $request->result_test_lists_weight,
            'result_weight_id'           => $request->result_weight_id,
            'result_test_lists_temp'     => $request->result_test_lists_temp,
            'result_test_lists_moisture' => $request->result_test_lists_moisture,
            'result_test_lists_test'     => $request->result_test_lists_test,
            'result_test_lists_remark'   => $request->result_test_lists_remark,
            'result_test_lists_note'     => $request->result_test_lists_note,

            // บันทึกข้อมูล N1, N2, N3
            'result_n1_width1' => $request->result_n1_width1,
            'result_n1_width2' => $request->result_n1_width2,
            'result_n1_length1' => $request->result_n1_length1,
            'result_n1_length2' => $request->result_n1_length2,
            'result_n1_height1' => $request->result_n1_height1,
            'result_n1_height2' => $request->result_n1_height2,
            'result_n1_weight1' => $request->result_n1_weight1,
            'result_n1_weight2' => $request->result_n1_weight2,

            'result_n2_width1' => $request->result_n2_width1,
            'result_n2_width2' => $request->result_n2_width2,
            'result_n2_length1' => $request->result_n2_length1,
            'result_n2_length2' => $request->result_n2_length2,
            'result_n2_height1' => $request->result_n2_height1,
            'result_n2_height2' => $request->result_n2_height2,
            'result_n2_weight1' => $request->result_n2_weight1,
            'result_n2_weight2' => $request->result_n2_weight2,

            'result_n3_width1' => $request->result_n3_width1,
            'result_n3_width2' => $request->result_n3_width2,
            'result_n3_length1' => $request->result_n3_length1,
            'result_n3_length2' => $request->result_n3_length2,
            'result_n3_height1' => $request->result_n3_height1,
            'result_n3_height2' => $request->result_n3_height2,
            'result_n3_weight1' => $request->result_n3_weight1,
            'result_n3_weight2' => $request->result_n3_weight2,

            // ข้อมูลตารางอุณหภูมิและความชื้น 100-350 องศา
            'result100_n1temp' => $request->result100_n1temp, 'result100_n1moisture' => $request->result100_n1moisture,
            'result100_n2temp' => $request->result100_n2temp, 'result100_n2moisture' => $request->result100_n2moisture,
            'result100_n3temp' => $request->result100_n3temp, 'result100_n3moisture' => $request->result100_n3moisture,
            
            'result150_n1temp' => $request->result150_n1temp, 'result150_n1moisture' => $request->result150_n1moisture,
            'result150_n2temp' => $request->result150_n2temp, 'result150_n2moisture' => $request->result150_n2moisture,
            'result150_n3temp' => $request->result150_n3temp, 'result150_n3moisture' => $request->result150_n3moisture,

            'result200_n1temp' => $request->result200_n1temp, 'result200_n1moisture' => $request->result200_n1moisture,
            'result200_n2temp' => $request->result200_n2temp, 'result200_n2moisture' => $request->result200_n2moisture,
            'result200_n3temp' => $request->result200_n3temp, 'result200_n3moisture' => $request->result200_n3moisture,

            'result250_n1temp' => $request->result250_n1temp, 'result250_n1moisture' => $request->result250_n1moisture,
            'result250_n2temp' => $request->result250_n2temp, 'result250_n2moisture' => $request->result250_n2moisture,
            'result250_n3temp' => $request->result250_n3temp, 'result250_n3moisture' => $request->result250_n3moisture,

            'result300_n1temp' => $request->result300_n1temp, 'result300_n1moisture' => $request->result300_n1moisture,
            'result300_n2temp' => $request->result300_n2temp, 'result300_n2moisture' => $request->result300_n2moisture,
            'result300_n3temp' => $request->result300_n3temp, 'result300_n3moisture' => $request->result300_n3moisture,

            'result350_n1temp' => $request->result350_n1temp, 'result350_n1moisture' => $request->result350_n1moisture,
            'result350_n2temp' => $request->result350_n2temp, 'result350_n2moisture' => $request->result350_n2moisture,
            'result350_n3temp' => $request->result350_n3temp, 'result350_n3moisture' => $request->result350_n3moisture,

            'result_n1_rpm' => $request->result_n1_rpm,
            'result_n2_rpm' => $request->result_n2_rpm,
            'result_n3_rpm' => $request->result_n3_rpm,
        ]);

        // 3. วนลูปอัปเดตข้อมูลตารางย่อย (receive_test_subs)
        if ($request->has('receive_test_subs_id')) {
            foreach ($request->receive_test_subs_id as $index => $subId) {
                $sub = ReceiveTestSub::find($subId); // เปลี่ยน Model ตามที่คุณใช้งาน
                if ($sub) {
                    $sub->update([
                        'receive_test_subs_note' => $request->receive_test_subs_note[$index] ?? null,
                        'receive_test_subs_time' => $request->receive_test_subs_time[$index] ?? null,
                        'before_testing'         => $request->before_testing[$index] ?? null,
                        'after_testing'          => $request->after_testing[$index] ?? null,
                        'total_testing'          => $request->total_testing[$index] ?? null,
                    ]);
                }
            }
        }

        // 4. พาผู้ใช้กลับหน้าเดิมพร้อมแจ้งเตือน
        return redirect()->back()->with('success', 'อัปเดตผลการทดสอบสำเร็จเรียบร้อยแล้ว');
    }

    public function showChart($testId, Request $request)
    {
        // 1. ตรวจสอบข้อมูลส่วนหัวของคำขอ (Request Order)
        $ck = ArRequestorderHd::where('ar_requestorder_hds_docuno', $testId)->first();
        if (!$ck) {
            return redirect()->back()->with('error', 'ไม่พบข้อมูลเอกสารการทดสอบนี้');
        }

        $classRecord = ArRequestorderDt::where('ar_requestorder_hds_id', $ck->ar_requestorder_hds_id)->first();
        if (!$classRecord) {
            return redirect()->back()->with('error', 'ไม่พบข้อมูลรายละเอียด JIS Class ของการทดสอบนี้');
        }

        // 2. ดึงข้อมูลส่วนหัวของรายงานปัจจุบันจาก TestHeaders
        $header = DB::table('TestHeaders')
            ->where('Lot', $testId)
            ->first();

        if (!$header) {
            return redirect()->back()->with('error', 'ไม่พบข้อมูลรายงานการทดสอบนี้');
        }

        // ดึง 10 TestID ล่าสุดของ FormulaNumber นี้ (เรียงจากเก่าไปใหม่สำหรับแสดง Control Chart)
        $recentHeaders = DB::table('TestHeaders')
            ->where('FormulaNumber', $header->FormulaNumber)
            ->orderBy('TestID', 'desc')
            ->get()
            ->reverse()
            ->values();

        // 3. รับค่าอุณหภูมิที่เลือก (ค่าเริ่มต้น 100)
        $targetTemp = (int)$request->get('temperature', 100);
        $class = $classRecord->ar_requestorder_dts_jis_class;

        // ดึงค่า Master Control Limits จาก ms_xandrchart ตาม Class และ Temperature
        $masterLimit = DB::table('ms_xandrchart')
            ->where('ms_xandrchart_class', $class)
            ->where('ms_xandrchart_temp', (string)$targetTemp)
            ->first();

        if (!$masterLimit) {
            return redirect()->back()->with('error', 'ไม่พบข้อมูล Master Control Limits (ms_xandrchart) สำหรับอุณหภูมินี้');
        }

        // 4. วนลูปดึงข้อมูลดิบของแต่ละ TestID มาทำเป็น Subgroups (เฉลี่ย T_Inc และ T_Dec)
        $subgroups = [];
        $allValuesForSD = [];
        $sumXBar = 0;
        $sumR = 0;

        foreach ($recentHeaders as $index => $hItem) {
            $dt = DB::table('TestDetails')
                ->where('TestID', $hItem->TestID)
                ->where('Temperature', (string)$targetTemp)
                ->selectRaw('CASE WHEN [T_Dec] = 0 OR [T_Dec] IS NULL THEN [T_Inc] ELSE ([T_Inc] + [T_Dec]) / 2.0 END AS avg_val')
                ->pluck('avg_val')
                ->map(fn($v) => (float)$v)
                ->toArray();

            if (count($dt) >= 3) {
                $chunk = array_slice($dt, 0, 3);
                $xBar = array_sum($chunk) / count($chunk);
                $rVal = max($chunk) - min($chunk);

                $sumXBar += $xBar;
                $sumR += $rVal;

                $subgroups[] = [
                    'set_no'    => 'Set ' . ($index + 1),
                    'lot'       => $hItem->Lot,
                    'date'      => $hItem->TestDate ?? '-',
                    'values'    => $chunk,
                    'n1'        => $chunk[0],
                    'n2'        => $chunk[1],
                    'n3'        => $chunk[2],
                    'x_bar'     => round($xBar, 4),
                    'r'         => round($rVal, 4),
                    'ucl_x'     => (float)$masterLimit->ucl_x,
                    'lcl_x'     => (float)$masterLimit->lcl_x,
                    'ucl_r'     => (float)$masterLimit->ucl_r,
                    'lcl_r'     => (float)$masterLimit->lcl_r,
                    'is_out_x'  => ($xBar > $masterLimit->ucl_x || $xBar < $masterLimit->lcl_x),
                    'is_out_r'  => ($rVal > $masterLimit->ucl_r || $rVal < $masterLimit->lcl_r),
                ];

                $allValuesForSD = array_merge($allValuesForSD, $chunk);
            }
        }

        $m = count($subgroups);
        if ($m === 0) {
            return redirect()->back()->with('error', 'ไม่มีข้อมูลดิบเพียงพอสำหรับการสร้างกราฟ SPC (ต้องการอย่างน้อย 3 ค่าต่อ TestID)');
        }

        // 5. กำหนดค่าเกณฑ์มาตรฐาน (JIS D 4411) ตาม Class และ Temperature
        $jisMinVal = 0.25;
        $jisMaxVal = 0.70;
        $tolerance = 0.10;
        $maxWearRate = '0.5 หรือน้อยกว่า';

        if ($class === "CLASS_3") {
            switch ($targetTemp) {
                case 100:
                    $jisMinVal = 0.25; $jisMaxVal = 0.65; $tolerance = 0.08; $maxWearRate = '0.5 หรือน้อยกว่า';
                    break;
                case 150:
                    $jisMinVal = 0.25; $jisMaxVal = 0.70; $tolerance = 0.10; $maxWearRate = '0.7 หรือน้อยกว่า';
                    break;
                case 200:
                    $jisMinVal = 0.25; $jisMaxVal = 0.70; $tolerance = 0.12; $maxWearRate = '1.0 หรือน้อยกว่า';
                    break;
                case 250:
                    $jisMinVal = 0.20; $jisMaxVal = 0.70; $tolerance = 0.12; $maxWearRate = '1.5 หรือน้อยกว่า';
                    break;
                case 300:
                    $jisMinVal = 0.15; $jisMaxVal = 0.70; $tolerance = 0.14; $maxWearRate = '3.0 หรือน้อยกว่า';
                    break;
                case 350:
                    $jisMinVal = null; $jisMaxVal = null; $tolerance = null; $maxWearRate = 'ไม่มีการทดสอบ';
                    break;
            }
        } elseif ($class === "CLASS_4") {
            switch ($targetTemp) {
                case 100:
                    $jisMinVal = 0.25; $jisMaxVal = 0.65; $tolerance = 0.08; $maxWearRate = '0.5 หรือน้อยกว่า';
                    break;
                case 150:
                    $jisMinVal = 0.25; $jisMaxVal = 0.70; $tolerance = 0.10; $maxWearRate = '0.7 หรือน้อยกว่า';
                    break;
                case 200:
                    $jisMinVal = 0.25; $jisMaxVal = 0.70; $tolerance = 0.12; $maxWearRate = '1.0 หรือน้อยกว่า';
                    break;
                case 250:
                    $jisMinVal = 0.25; $jisMaxVal = 0.70; $tolerance = 0.12; $maxWearRate = '1.5 หรือน้อยกว่า';
                    break;
                case 300:
                    $jisMinVal = 0.25; $jisMaxVal = 0.70; $tolerance = 0.14; $maxWearRate = '2.5 หรือน้อยกว่า';
                    break;
                case 350:
                    $jisMinVal = 0.20; $jisMaxVal = 0.70; $tolerance = 0.14; $maxWearRate = '3.5 หรือน้อยกว่า';
                    break;
            }
        }

        // 6. คำนวณค่าสถิติ Control Chart และ Process Performance ตามมาตรฐาน YSK5-FM-LAB-13
        $grandXBar = $sumXBar / $m;
        $averageR  = $sumR / $m;
        
        $d2 = 1.693; // Constant for subgroup n = 3
        $sdRBar = ($d2 > 0) ? $averageR / $d2 : 0; // Short-term variation (R-bar / d2)

        // คำนวณ Sample Standard Deviation (Overall SD)
        $nTotal = count($allValuesForSD);
        $overallMean = ($nTotal > 0) ? array_sum($allValuesForSD) / $nTotal : 0;
        $varianceSum = 0;
        foreach ($allValuesForSD as $val) {
            $varianceSum += pow($val - $overallMean, 2);
        }
        $overallSD = ($nTotal > 1) ? sqrt($varianceSum / ($nTotal - 1)) : 0;

        $USL = $jisMaxVal;
        $LSL = $jisMinVal;

        // คำนวณ Cp, Cpk (Short-term)
        $cp  = ($USL !== null && $LSL !== null && $sdRBar > 0) ? ($USL - $LSL) / (6 * $sdRBar) : 0;
        $cpu = ($USL !== null && $sdRBar > 0) ? ($USL - $grandXBar) / (3 * $sdRBar) : 0;
        $cpl = ($LSL !== null && $sdRBar > 0) ? ($grandXBar - $LSL) / (3 * $sdRBar) : 0;
        $cpk = ($USL !== null && $LSL !== null) ? min($cpu, $cpl) : 0;

        // คำนวณ Pp, Ppk (Overall Performance)
        $pp  = ($USL !== null && $LSL !== null && $overallSD > 0) ? ($USL - $LSL) / (6 * $overallSD) : 0;
        $ppu = ($USL !== null && $overallSD > 0) ? ($USL - $grandXBar) / (3 * $overallSD) : 0;
        $ppl = ($LSL !== null && $overallSD > 0) ? ($grandXBar - $LSL) / (3 * $overallSD) : 0;
        $ppk = ($USL !== null && $LSL !== null) ? min($ppu, $ppl) : 0;

        // รวบรวมข้อมูลทั้งหมดส่งเข้า View
        $spcData = [
            'form_no'       => 'YSK5-FM-LAB-13',
            'subgroups'     => $subgroups,
            'grand_x_bar'   => round($grandXBar, 4),
            'average_r'     => round($averageR, 4),
            'ucl_x'         => round((float)$masterLimit->ucl_x, 4),
            'lcl_x'         => round((float)$masterLimit->lcl_x, 4),
            'ucl_r'         => round((float)$masterLimit->ucl_r, 4),
            'lcl_r'         => round((float)$masterLimit->lcl_r, 4),
            'sigma_r'       => round($sdRBar, 4),
            'overall_sd'    => round($overallSD, 4),
            'cp'            => round($cp, 2),
            'cpk'           => round($cpk, 2),  // <-- แก้ตรงนี้จาก `cpk` เป็น 'cpk'
            'pp'            => round($pp, 2),
            'ppk'           => round($ppk, 2),
            'usl'           => $USL ?? '-',
            'lsl'           => $LSL ?? '-',
            'tolerance'     => $tolerance ?? '-',
            'wear_rate'     => $maxWearRate,
            'target_temp'   => $targetTemp,
            'target_mu'     => 0.45,
            'jis_class'     => $class,
            'master_limits' => $masterLimit
        ];

        return view('report.report-xbar-r-chart', compact('header', 'spcData', 'testId'));
    }
    /**
     * ฟังก์ชันกำหนดค่า USL, LSL และ Tolerance ตามมาตรฐาน JIS D 4411 Class 4 แยกตามช่วงอุณหภูมิ
     */
    private function getJisSpecByTemperature(float $temp)
    {
        if ($temp <= 100) {
            return [
                'usl'       => 0.65, 
                'lsl'       => 0.25, 
                'tolerance' => 0.08,
                'wear_rate' => 2.5  // เพิ่มค่า Max Wear Rate ตามมาตรฐาน (ตัวเลขสามารถปรับเปลี่ยนได้ตามจริงของคุณ)
            ];
        } elseif ($temp > 100 && $temp <= 300) {
            return [
                'usl'       => 0.70, 
                'lsl'       => 0.25, 
                'tolerance' => 0.11,
                'wear_rate' => 3.5  // เพิ่มค่า Max Wear Rate
            ];
        } else {
            return [
                'usl'       => 0.70, 
                'lsl'       => 0.20, 
                'tolerance' => 0.14,
                'wear_rate' => 5.0  // เพิ่มค่า Max Wear Rate
            ];
        }
    }
    public function showPtTest($testId, Request $request)
    {
        $header = ReceiveTestList::find($testId);
        $bom = DB::table('chemistry_hd')->where('chemistry_hd_id',$header->chemistry_hd_id)->first();
        $hd = ProficiencyTestResult::where('receive_test_lists_id',$testId)->first();
        $dt = ProficiencyTestResult::where('receive_test_lists_id',$testId)->get();
        if (!$header) {
            return redirect()->back()->with('error', 'ไม่พบข้อมูลรายงานการทดสอบนี้');
        }
       return view('report.report-pt-test', compact('header', 'testId','bom','hd','dt'));              
    }

    public function storePtTest(Request $request, $testId)
    {
        // ตัวอย่างการใช้ Database Transaction เพื่อความปลอดภัยของข้อมูล
        DB::beginTransaction();
        try {
            // วนลูปบันทึกข้อมูลทั้ง 6 แถว
            for ($i = 1; $i <= 6; $i++) {
                // ตรวจสอบว่ามีข้อมูลแถวนี้ส่งมาหรือไม่ (ป้องกันกรณีแถวว่าง)
                if ($request->has("ref_rep.$i")) {
                    ProficiencyTestResult::updateOrCreate(
                        [
                            'receive_test_lists_id' => $testId,
                            'proficiency_test_results_no' => $i,
                        ],
                        [
                            'measuring_instrument' => $request->input("measuring_instrument"),
                            'reportsize' => $request->input("ref_rep.$i"),
                            'sizeuncertainty' => $request->input("ref_unc.$i"),
                            'refvalue' => $request->input("ref_val.$i"),
                            'sizecurve1' => $request->input("lab_c1.$i"),
                            'sizecurve2' => $request->input("lab_c2.$i"),
                            'sizecurve3' => $request->input("lab_c3.$i"),
                            'sizecurve4' => $request->input("lab_c4.$i"),
                            'labuncertainty' => $request->input("lab_u.$i"),
                            'sizename' => $request->input("sum_name.$i"), // หรือชื่อสูตรที่ต้องการ
                            'ratiocurve1' => $request->input("sum_en1.$i"),
                            'ratiocurve2' => $request->input("sum_en2.$i"),
                            'ratiocurve3' => $request->input("sum_en3.$i"),
                            'ratiocurve4' => $request->input("sum_en4.$i"),
                            'evaluation' => $request->input("sum_eval.$i"), // Pass / Fail
                            'proficiency_test_results_date' => $request->input("results_date"),
                            'person_at' => $request->input("person_at"),
                            'approved_date' => $request->input("approved_date"),
                            'approved_at' => $request->input("approved_at"),
                            'proficiency_test_results_flag' => true,
                            
                        ]
                    );
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'บันทึกผลการทดสอบสำเร็จ');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
        }
    }

    public function showCheckForm($testId, Request $request)
    {
        $header = ReceiveTestList::find($testId);
        $cal = DB::table('calibration_lists')->where('calibration_lists_code','4411-001')->first();
        $bom = DB::table('chemistry_hd')->where('chemistry_hd_id',$header->chemistry_hd_id)->first();
        $reqdoc = ArRequestorderHd::where('ar_requestorder_hds_id',$header->ar_requestorder_hds_id)->first();
        if (!$header) {
            return redirect()->back()->with('error', 'ไม่พบข้อมูลรายงานการทดสอบนี้');
        }
        $hd = CheckFormHd::where('receive_test_lists_id',$testId)->first();
        if($hd){
            $dt = CheckFormDt::where('check_form_hds_id', $hd->check_form_hds_id)->get();             
        }else{
            $dt = null;
        }
        return view('report.report-check-form', compact('header', 'testId','cal','bom','reqdoc','hd','dt'));              
    }

    public function CheckFormstore(Request $request, $id = null)
    {
        // ตรวจสอบความถูกต้องของข้อมูลเบื้องต้น
        $request->validate([
            'instrument_name' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255',
            'cal_date' => 'required|date',
            'certificate_no' => 'required|string|max:255',
            'refer_doc' => 'required|string|max:255',
            'test_range_voltage' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            // บันทึกหรืออัปเดตข้อมูลส่วนหัว (Header: check_form_hds)
            // หากส่ง $id มา (Update) จะทำการค้นหาแล้วอัปเดต ถ้าไม่มีจะสร้างใหม่ (Insert)
            $header = CheckFormHd::updateOrCreate(
                ['receive_test_lists_id' => $id], // เงื่อนไขสำหรับเช็คว่ามีอยู่แล้วหรือไม่
                [
                    'instrument_name'    => $request->instrument_name,
                    'specification'      => $request->specification,
                    'model'              => $request->model,
                    'serial_number'      => $request->serial_number,
                    'cal_date'           => $request->cal_date,
                    'certificate_no'     => $request->certificate_no,
                    'refer_doc'          => $request->refer_doc,
                    'test_range_voltage' => $request->test_range_voltage,
                    'check_form_hds_flag' => true,
                    'person_at'          => Auth::user()->name ?? 'System',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );

            // หากเป็นการอัปเดต (Update) สามารถเคลียร์รายการย่อยเก่าทิ้งแล้วบันทึกใหม่ หรือใช้วิธี updateOrCreate ทีละแถว
            // ในที่นี้เลือกใช้แบบลบของเก่าแล้ว Insert ใหม่สำหรับรายการย่อย เพื่อความสะดวกและแม่นยำตามจำนวนแถวที่ส่งมา
            CheckFormDt::where('check_form_hds_id', $header->check_form_hds_id)->delete();

            // บันทึกข้อมูลตารางรายการย่อย (Details: check_form_dts)
            if ($request->has('x1') && is_array($request->x1)) {
                foreach ($request->x1 as $i => $val) {
                    // ตรวจสอบว่ามีข้อมูลส่งมา หรือบันทึกตามจำนวนรอบลูป
                    CheckFormDt::create([
                        'check_form_hds_id'   => $header->check_form_hds_id,
                        'check_date'          => $request->check_date[$i] ?? date('Y-m-d'),
                        'check_form_dts_no'   => $i,
                        'x1'                  => $request->x1[$i] ?? null,
                        'x2'                  => $request->x2[$i] ?? null,
                        'x3'                  => $request->x3[$i] ?? null,
                        'x_bar'               => $request->x_bar[$i] ?? null,
                        'min_spec'            => $request->min_spec[$i] ?? null,
                        'max_spec'            => $request->max_spec[$i] ?? null,
                        'pass_fail'           => $request->pass_fail[$i] ?? null,
                        'checker'             => $request->checker[$i] ?? null,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'บันทึกข้อมูลสำเร็จเรียบร้อยแล้ว');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' . $e->getMessage());
        }
    }

    public function showIntermediateCheck($testId, Request $request)
    {
        $header = ReceiveTestList::find($testId);
        $previousHeader = ReceiveTestList::where('receive_test_lists_id', '<', $testId)
                                    ->orderBy('receive_test_lists_id', 'desc')
                                    ->first();
        $cal = DB::table('calibration_lists')->where('calibration_lists_code','4318-001')->first();
        $bom = DB::table('chemistry_hd')->where('chemistry_hd_id',$header->chemistry_hd_id)->first();
        $reqdoc = ArRequestorderHd::where('ar_requestorder_hds_id',$header->ar_requestorder_hds_id)->first();
        $hd = IntermediateCheckHd::where('receive_test_lists_id',$testId)->first();
        if($hd){
            $dt = IntermediateCheckDt::where('intermediate_check_hds_id', $hd->intermediate_check_hds_id)->get();
        }else{
            $dt = null;
        }      
        return view('report.report-intermediate-check', compact('header','cal','bom','reqdoc','previousHeader','hd','dt'));     
    }

    public function IntermediateCheckstore(Request $request, $testId)
    {
        // ใช้ Transaction เพื่อให้มั่นใจว่าข้อมูล Header และ Detail จะบันทึกหรืออัปเดตสำเร็จพร้อมกัน
        DB::beginTransaction();
        try {
            // 1. บันทึกหรืออัปเดตข้อมูลส่วนหัว (Header) 
            // โดยใช้ receive_test_lists_id เป็นเงื่อนไขในการเช็คซ้ำ
            $header = IntermediateCheckHd::updateOrCreate(
                [
                    'receive_test_lists_id' => $request->receive_test_lists_id
                ],
                [
                    'instrument_name'    => $request->instrument_name,
                    'specification'      => $request->specification,
                    'model'              => $request->model,
                    'serial_number'      => $request->serial_number,
                    'cal_date'           => $request->cal_date,
                    'certificate_no'     => $request->certificate_no,
                    'refer_doc'          => $request->refer_doc,
                    'test_range_voltage' => $request->test_range_voltage ?? '-',
                    'creator'            => $request->creator,
                    'created_date'       => $request->created_date,
                    
                    // ข้อมูลสถิติ Temperature (°C)
                    'stat_c_test1_mean'  => $request->stat_c_test1_mean ?? '0.0000',
                    'stat_c_test2_mean'  => $request->stat_c_test2_mean ?? '0.0000',
                    'stat_c_test1_var'   => $request->stat_c_test1_var ?? '0.0000',
                    'stat_c_test2_var'   => $request->stat_c_test2_var ?? '0.0000',
                    'stat_c_test1_obs'   => $request->stat_c_test1_obs ?? '0',
                    'stat_c_test2_obs'   => $request->stat_c_test2_obs ?? '0',

                    // ข้อมูลสถิติ Relative Humidity (%RH)
                    'stat_rh_test1_mean' => $request->stat_rh_test1_mean ?? '0.0000',
                    'stat_rh_test2_mean' => $request->stat_rh_test2_mean ?? '0.0000',
                    'stat_rh_test1_var'  => $request->stat_rh_test1_var ?? '0.0000',
                    'stat_rh_test2_var'  => $request->stat_rh_test2_var ?? '0.0000',
                    'stat_rh_test1_obs'  => $request->stat_rh_test1_obs ?? '0',
                    'stat_rh_test2_obs'  => $request->stat_rh_test2_obs ?? '0',

                    'summary_result'     => $request->summary_result,
                    'approver'           => $request->approver,
                    'approved_date'      => $request->approved_date,
                    'test_status'       => $request->test_status,
                    'incident_point'    => $request->incident_point,
                    'problem_category'  => $request->problem_category,
                    'data_validity'     => $request->data_validity,
                    'result_doc'        => $request->result_doc,
                    'problem_description' => $request->problem_description,
                    'action_taken' => $request->action_taken
                ]
            );

            // 2. บันทึกหรืออัปเดตข้อมูลตารางย่อย (Detail) วนลูปตาม Point (100, 150, 200, 250, 300, 350)
            if ($request->has('point')) {
                foreach ($request->point as $index => $pointValue) {
                    IntermediateCheckDt::updateOrCreate(
                        [
                            'intermediate_check_hds_id' => $header->intermediate_check_hds_id,
                            'point'                     => $pointValue
                        ],
                        [
                            // Before Cal Test Date (Test 1)
                            'bc_n1_c'  => $request->bc_n1_c[$index] ?? null,
                            'bc_n1_rh' => $request->bc_n1_rh[$index] ?? null,
                            'bc_n2_c'  => $request->bc_n2_c[$index] ?? null,
                            'bc_n2_rh' => $request->bc_n2_rh[$index] ?? null,
                            'bc_n3_c'  => $request->bc_n3_c[$index] ?? null,
                            'bc_n3_rh' => $request->bc_n3_rh[$index] ?? null,

                            // 1st Test Date (Test 2)
                            't1_n1_c'  => $request->t1_n1_c[$index] ?? null,
                            't1_n1_rh' => $request->t1_n1_rh[$index] ?? null,
                            't1_n2_c'  => $request->t1_n2_c[$index] ?? null,
                            't1_n2_rh' => $request->t1_n2_rh[$index] ?? null,
                            't1_n3_c'  => $request->t1_n3_c[$index] ?? null,
                            't1_n3_rh' => $request->t1_n3_rh[$index] ?? null,
                        ]
                    );
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'บันทึกหรืออัปเดตข้อมูลสำเร็จเรียบร้อยแล้ว');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' . $e->getMessage());
        }
    }

}
