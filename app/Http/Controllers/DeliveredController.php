<?php

namespace App\Http\Controllers;

use App\Models\ArRequestorderHd;
use App\Models\DeliveredTestHd;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeliveredController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'delivered_test_hds_date' => ['required'],
            'delivered_test_hds_docuno' => ['required'],
            'ar_requestorder_hds_docuno' => ['required'],
            'delivered_test_hds_contact' => ['required'],
            'delivered_test_hds_customer' => ['required'],
            'ar_requestorder_statuses_id' => ['required'],
            'delivered_test_dts_listno' => ['required'],
        ]);
        $sta = DB::table('ar_requestorder_statuses')->where('ar_requestorder_statuses_id',$request->ar_requestorder_statuses_id)->first();
        $data = [
            'delivered_test_hds_date' => $request->delivered_test_hds_date,
            'delivered_test_hds_docuno' => $request->delivered_test_hds_docuno,
            'delivered_test_hds_number' => 0,
            'delivered_test_statuses_id' => 1,
            'delivered_test_hds_customer' => $request->delivered_test_hds_customer,
            'delivered_test_hds_contact' => $request->delivered_test_hds_contact,
            'delivered_test_hds_remark' => $request->delivered_test_hds_remark,
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now(), 
            'ar_requestorder_hds_docuno' => $request->ar_requestorder_hds_docuno,
            'delivered_test_hds_type' => $sta->ar_requestorder_statuses_name
        ]; 
        try {
            DB::beginTransaction();
            $insertHD = DeliveredTestHd::insertGetId($data);  
            if ($request->has('delivered_test_dts_listno') && is_array($request->delivered_test_dts_listno)) {
                foreach ($request->delivered_test_dts_listno as $key => $value) {
                    DB::table('delivered_test_dts')->insert([
                        'delivered_test_hds_id'  => $insertHD, 
                        'delivered_test_dts_listno' => $value,
                        'delivered_test_dts_remark' => $request->delivered_test_dts_remark[$key],
                        'delivered_test_dts_qty' => $request->delivered_test_dts_qty[$key],
                        'delivered_test_dts_flag' => true,
                        'person_at' => Auth::user()->name,
                        'created_at' => Carbon::now(), 
                        'updated_at' => Carbon::now(), 
                    ]);
                }
            }                       
            DB::commit();
            return redirect()->to('/receive-result')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollBack(); 
            Log::error($e->getMessage());           
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
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
        //
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
        // กำหนดรูปแบบPrefix เช่น ตามปีเดือนปัจจุบัน หรือตามประเภท
        $yearMonth = date('Ym'); // หรือใช้ปีพ.ศ. เช่น (date('Y') + 543) . date('m')
        
        // ค้นหาเลขล่าสุดในฐานข้อมูลของเดือนนั้น
        $latestDoc = DeliveredTestHd::where('delivered_test_hds_docuno', 'LIKE', "DL-{$yearMonth}%")
                        ->orderBy('delivered_test_hds_docuno', 'desc')
                        ->first();

        if ($latestDoc) {
            // ตัดเอา 3 ตัวท้ายมาบวกเพิ่ม 1
            $runningNumber = intval(substr($latestDoc->delivered_test_hds_docuno, -3)) + 1;
        } else {
            $runningNumber = 1;
        }

        // จัดรูปแบบให้เป็น 3 หลัก เช่น 001, 002
        $newDocNo = 'DL-' . $yearMonth . '-' . str_pad($runningNumber, 3, '0', STR_PAD_LEFT);
        $dehd = DeliveredTestHd::leftjoin('delivered_test_dts','delivered_test_hds.delivered_test_hds_id','=','delivered_test_dts.delivered_test_hds_id')
        ->where('ar_requestorder_hds_docuno',$hd->ar_requestorder_hds_docuno)
        ->get();
        return view('testsamples.form-deliveredtest-edit', compact('hd','newDocNo','dehd'));
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
        //
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
    public function printDocument($id)
    {
        // ดึงข้อมูลหลักและรายการย่อย (ยึดตาม row ของตาราง)
        $dt = DB::table('delivered_test_dts')
            ->where('delivered_test_hds_id', $id)         
            ->get();

        // ดึงข้อมูลหัวข้อ (Header) ตัวเดี่ยวๆ มาแสดงส่วนหัวเอกสาร (ถ้าต้องการ)
        $header = DB::table('delivered_test_hds')
            ->where('delivered_test_hds_id', $id)
            ->first();

        return view('testsamples.form-deliveredtest-print', compact('dt', 'header'));
    }
}
