<?php

namespace App\Http\Controllers;

use App\Models\ArCustomerList;
use App\Models\ArRequestorderDt;
use App\Models\ArRequestorderHd;
use App\Models\CalibrationList;
use App\Models\OtherDistrict;
use App\Models\OtherProvince;
use App\Models\OtherSubDistrict;
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
        $hd = ArRequestorderHd::leftjoin('ar_requestorder_statuses','ar_requestorder_hds.ar_requestorder_statuses_id','=','ar_requestorder_statuses.ar_requestorder_statuses_id')
        ->leftjoin('receive_test_lists','ar_requestorder_hds.ar_requestorder_hds_id','=','receive_test_lists.ar_requestorder_hds_id')
        ->leftjoin('chemistry_hd','chemistry_hd.chemistry_hd_id','=','receive_test_lists.chemistry_hd_id')
        ->leftjoin('TestHeaders','ar_requestorder_hds.ar_requestorder_hds_docuno','=','TestHeaders.Lot')
        ->where('ar_requestorder_hds.ar_requestorder_statuses_id',7)
        ->get();
        return view('testsamples.form-testsamples-result', compact('hd'));
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
        $ck = ArRequestorderHd::where('ar_requestorder_hds_docuno', $testId)->first();
        if (!$ck) {
            return redirect()->back()->with('error', 'ไม่พบข้อมูลเอกสารการทดสอบนี้');
        }

        $class = ArRequestorderDt::where('ar_requestorder_hds_id', $ck->ar_requestorder_hds_id)->first();
        if (!$class) {
            return redirect()->back()->with('error', 'ไม่พบข้อมูลรายละเอียด JIS Class ของการทดสอบนี้');
        }

        // 1. ดึงข้อมูลส่วนหัวของรายงานปัจจุบัน
        $header = DB::table('TestHeaders')
            ->where('Lot', $testId)
            ->first();

        if (!$header) {
            return redirect()->back()->with('error', 'ไม่พบข้อมูลรายงานการทดสอบนี้');
        }

        // ดึง 10 TestID ล่าสุดของ FormulaNumber นี้
        $recentHeaders = DB::table('TestHeaders')
            ->where('FormulaNumber', $header->FormulaNumber)
            ->orderBy('TestID', 'desc')
            ->limit(10)
            ->get()
            ->reverse()
            ->values();

        // 3. รับค่าอุณหภูมิที่เลือก (ค่าเริ่มต้น 100)
        $targetTemp = $request->get('temperature', 100);

        // 4. วนลูปดึงข้อมูลดิบของแต่ละ TestID มาทำเป็น Subgroups (นำ T_Inc และ T_Dec มาเฉลี่ยกัน)
        $subgroups = [];
        $allValuesForSD = [];

        foreach ($recentHeaders as $index => $hItem) {
            // ดึงข้อมูลและคำนวณค่า: ถ้า T_Dec เป็น 0 ให้ใช้ T_Inc ตัวเดียว ไม่งั้นให้นำมาเฉลี่ยกัน
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

                $subgroups[] = [
                    'set_no' => 'Set ' . ($index + 1),
                    'lot'    => $hItem->Lot,
                    'date'   => $hItem->TestDate ?? '-',
                    'values' => $chunk,
                    'x_bar'  => round($xBar, 4),
                    'r'      => round($rVal, 4),
                ];

                $allValuesForSD = array_merge($allValuesForSD, $chunk);
            }
        }

        $m = count($subgroups);
        $targetMu = 0.45;
        $jisMinVal = 0.25;
        $jisMaxVal = 0.70;
        $tolerance = 0.10;

        // ----------------------------------------------------
        // 5. แยกเงื่อนไขตาม JIS Class (Class 4 vs Class 3)
        // ----------------------------------------------------
        if ($class->ar_requestorder_dts_jis_class == "CLASS_4") {
            if ($m === 0) {
                return redirect()->back()->with('error', 'ไม่มีข้อมูลดิบเพียงพอสำหรับการสร้างกราฟ Class 4');
            }

            // กำหนดค่า Tolerance ตามอุณหภูมิของ Class 4
            switch ((int)$targetTemp) {
                case 100: $jisMinVal = 0.25; $jisMaxVal = 0.65; $tolerance = 0.08; break;
                case 150: $jisMinVal = 0.25; $jisMaxVal = 0.70; $tolerance = 0.10; break;
                case 200:
                case 250: $jisMinVal = 0.25; $jisMaxVal = 0.70; $tolerance = 0.12; break;
                case 300: $jisMinVal = 0.25; $jisMaxVal = 0.70; $tolerance = 0.14; break;
                case 350: $jisMinVal = 0.20; $jisMaxVal = 0.70; $tolerance = 0.14; break;
            }

        } elseif ($class->ar_requestorder_dts_jis_class == "CLASS_3") {
            if ($m === 0) {
                return redirect()->back()->with('error', 'ไม่มีข้อมูลดิบเพียงพอสำหรับการสร้างกราฟ Class 3');
            }

            // กำหนดเกณฑ์ของ Class 3 ตามอุณหภูมิจริง
            switch ((int)$targetTemp) {
                case 100:
                    $jisMinVal = 0.25;
                    $jisMaxVal = 0.65;
                    $tolerance = 0.08;
                    break;
                case 150:
                    $jisMinVal = 0.25;
                    $jisMaxVal = 0.70;
                    $tolerance = 0.10;
                    break;
                case 200:
                    $jisMinVal = 0.25;
                    $jisMaxVal = 0.70;
                    $tolerance = 0.12;
                    break;
                case 250:
                    $jisMinVal = 0.20; // ต่ำลงมาอยู่ที่ 0.20 ตามเกณฑ์ Class 3
                    $jisMaxVal = 0.70;
                    $tolerance = 0.12;
                    break;
                case 300:
                    $jisMinVal = 0.15; // ต่ำลงมาถึง 0.15 ตามเกณฑ์ Class 3
                    $jisMaxVal = 0.70;
                    $tolerance = 0.14;
                    break;
                case 350:
                    // มาตรฐาน Class 3 ไม่มีข้อมูลทดสอบที่ 350°C
                    $jisMinVal = null;
                    $jisMaxVal = null;
                    $tolerance = null;
                    break;
                default:
                    $jisMinVal = 0.25;
                    $jisMaxVal = 0.70;
                    $tolerance = 0.10;
            }
        }

        // 6. คำนวณค่าทางสถิติ Control Chart (n = 3)
        $A2 = 1.023;
        $D3 = 0.0;
        $D4 = 2.574;
        $d2 = 1.693;

        $grandXBar = ($m > 0) ? array_sum(array_column($subgroups, 'x_bar')) / $m : 0;
        $averageR  = ($m > 0) ? array_sum(array_column($subgroups, 'r')) / $m : 0;

        $uclX = $grandXBar + ($A2 * $averageR);
        $lclX = $grandXBar - ($A2 * $averageR);
        $uclR = $D4 * $averageR;
        $lclR = $D3 * $averageR;
        $sigma_R = ($d2 > 0) ? $averageR / $d2 : 0;

        $nTotal = count($allValuesForSD);
        $overallMean = ($nTotal > 0) ? array_sum($allValuesForSD) / $nTotal : 0;
        $varianceSum = 0;
        foreach ($allValuesForSD as $val) {
            $varianceSum += pow($val - $overallMean, 2);
        }
        $overallSD = ($nTotal > 1) ? sqrt($varianceSum / ($nTotal - 1)) : 0;

        // ตรวจสอบค่า USL/LSL กรณีเป็นค่า Null (เช่น อุณหภูมิ 350°C ของ Class 3)
        $USL = $jisMaxVal;
        $LSL = $jisMinVal;

        $cp  = ($USL !== null && $sigma_R > 0) ? ($USL - $LSL) / (6 * $sigma_R) : 0;
        $cpu = ($USL !== null && $sigma_R > 0) ? ($USL - $grandXBar) / (3 * $sigma_R) : 0;
        $cpl = ($LSL !== null && $sigma_R > 0) ? ($grandXBar - $LSL) / (3 * $sigma_R) : 0;
        $cpk = ($USL !== null && $LSL !== null) ? min($cpu, $cpl) : 0;

        $pp  = ($USL !== null && $overallSD > 0) ? ($USL - $LSL) / (6 * $overallSD) : 0;
        $ppu = ($USL !== null && $overallSD > 0) ? ($USL - $grandXBar) / (3 * $overallSD) : 0;
        $ppl = ($LSL !== null && $overallSD > 0) ? ($grandXBar - $LSL) / (3 * $overallSD) : 0;
        $ppk = ($USL !== null && $LSL !== null) ? min($ppu, $ppl) : 0;

        $spcData = [
            'subgroups'   => $subgroups,
            'grand_x_bar' => round($grandXBar, 4),
            'average_r'   => round($averageR, 4),
            'ucl_x'       => round($uclX, 4),
            'lcl_x'       => round($lclX, 4),
            'ucl_r'       => round($uclR, 4),
            'lcl_r'       => round($lclR, 4),
            'sigma_r'     => round($sigma_R, 4),
            'overall_sd'  => round($overallSD, 4),
            'cp'          => round($cp, 2),
            'cpk'         => round($cpk, 2),
            'pp'          => round($pp, 2),
            'ppk'         => round($ppk, 2),
            'usl'         => $USL ?? '-',
            'lsl'         => $LSL ?? '-',
            'tolerance'   => $tolerance ?? '-',
            'target_temp' => $targetTemp,
            'target_mu'   => $targetMu,
            'jis_class'   => $class->ar_requestorder_dts_jis_class
        ];

        return view('report.report-xbar-r-chart', compact('header', 'spcData', 'testId'));
    }

    /**
     * ฟังก์ชันกำหนดค่า USL, LSL และ Tolerance ตามมาตรฐาน JIS D 4411 Class 4 แยกตามช่วงอุณหภูมิ
     */
    private function getJisSpecByTemperature(float $temp)
    {
        if ($temp <= 100) {
            return ['usl' => 0.65, 'lsl' => 0.25, 'tolerance' => 0.08];
        } elseif ($temp > 100 && $temp <= 300) {
            // อุณหภูมิสูงขึ้น ช่วงเกณฑ์ขยายเป็น 0.25 - 0.70 และ Tolerance ขยับตามความเสถียร
            return ['usl' => 0.70, 'lsl' => 0.25, 'tolerance' => 0.11];
        } else {
            // อุณหภูมิสูงมาก (เช่น 350°C ขึ้นไป) ปรับเกณฑ์ยอมรับตามความเหมาะสม
            return ['usl' => 0.70, 'lsl' => 0.20, 'tolerance' => 0.14];
        }
    }
}
