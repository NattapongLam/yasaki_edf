<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ArRequestorderDt;
use App\Models\ArRequestorderHd;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ArRequestOrderListController extends Controller
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
        $hd = ArRequestorderHd::leftjoin('ar_requestorder_statuses','ar_requestorder_hds.ar_requestorder_statuses_id','=','ar_requestorder_statuses.ar_requestorder_statuses_id')->get();
        return view('sales.form-requestorder-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hd = null;
        return view('sales.form-requestorder-create', compact('hd'));
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
            'ar_requestorder_hds_date' => ['required'],
            'ar_requestorder_hds_docuno' => ['required'],
            'ar_requestorder_hds_customer' => ['required'],
            'ar_requestorder_hds_contact' => ['required'],
            'ar_requestorder_dts_listno' => ['required'],
        ]); 
        $data = [
            'ar_requestorder_hds_date' => $request->ar_requestorder_hds_date,
            'ar_requestorder_hds_docuno' => $request->ar_requestorder_hds_docuno,
            'ar_requestorder_hds_number' => 0,
            'ar_requestorder_statuses_id' => 1,
            'ar_requestorder_hds_customer' => $request->ar_requestorder_hds_customer,
            'ar_requestorder_hds_contact' => $request->ar_requestorder_hds_contact,
            'ar_requestorder_hd_remark' => $request->ar_requestorder_hd_remark,
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        try{
            DB::beginTransaction();
            $insertHD = ArRequestorderHd::create($data);   
            foreach ($request->ar_requestorder_dts_listno as $key => $value) {
                ArRequestorderDt::insert([
                    'ar_requestorder_hds_id' => $insertHD->ar_requestorder_hds_id,
                    'ar_requestorder_dts_listno' => $value,
                    'ar_requestorder_dts_product' => $request->ar_requestorder_dts_product[$key],
                    'ar_requestorder_hds_remark' => $request->ar_requestorder_hds_remark[$key],
                    'ar_requestorder_dts_qty' => $request->ar_requestorder_dts_qty[$key],
                    'ar_requestorder_dts_flag' => true,
                    'person_at' => Auth::user()->name,
                    'created_at'=> Carbon::now(),
                    'updated_at'=> Carbon::now(),
                ]);
            }            
            DB::commit();
            return redirect()->route('requestorders.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $dt = ArRequestorderDt::where('ar_requestorder_hds_id',$id)->where('ar_requestorder_dts_flag',true)->get();
        return view('sales.form-requestorder-edit', compact('hd','dt'));
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
        $data = [
            'ar_requestorder_statuses_id' => 1,
            'ar_requestorder_hds_customer' => $request->ar_requestorder_hds_customer,
            'ar_requestorder_hds_contact' => $request->ar_requestorder_hds_contact,
            'ar_requestorder_hd_remark' => $request->ar_requestorder_hd_remark,
            'person_at' => Auth::user()->name,
            'updated_at' => Carbon::now(),
        ];
        try{
            DB::beginTransaction();
            ArRequestorderHd::where('ar_requestorder_hds_id',$id)->update($data);             
            if(!empty($request->ar_requestorder_dts_listno)){
                $insertHD = ArRequestorderHd::find($id);
                foreach ($request->ar_requestorder_dts_listno as $key => $value) {
                    if(!empty($request->ar_requestorder_dts_id[$key])){
                        ArRequestorderDt::where('ar_requestorder_dts_id',$request->ar_requestorder_dts_id[$key])->update([
                            'ar_requestorder_dts_product' => $request->ar_requestorder_dts_product[$key],
                            'ar_requestorder_hds_remark' => $request->ar_requestorder_hds_remark[$key],
                            'ar_requestorder_dts_qty' => $request->ar_requestorder_dts_qty[$key],
                            'ar_requestorder_dts_flag' => true,
                            'person_at' => Auth::user()->name,
                            'updated_at'=> Carbon::now(),
                        ]);
                    }else{
                        ArRequestorderDt::insert([
                            'ar_requestorder_hds_id' => $insertHD->ar_requestorder_hds_id,
                            'ar_requestorder_dts_listno' => $value,
                            'ar_requestorder_dts_product' => $request->ar_requestorder_dts_product[$key],
                            'ar_requestorder_hds_remark' => $request->ar_requestorder_hds_remark[$key],
                            'ar_requestorder_dts_qty' => $request->ar_requestorder_dts_qty[$key],
                            'ar_requestorder_dts_flag' => true,
                            'person_at' => Auth::user()->name,
                            'created_at'=> Carbon::now(),
                            'updated_at'=> Carbon::now(),
                        ]);
                    }                   
                }      
            }              
            DB::commit();
            return redirect()->route('requestorders.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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

    public function runNo(Request $request)
    {
        $date = $request->date; // YYYY-MM-DD
        $yy = date('y', strtotime($date));
        $mm = date('m', strtotime($date));
        // รูปแบบ prefix เช่น QT-YYMM-
        $prefix = "RQ-{$yy}{$mm}-";
        // หาเลขล่าสุดของเดือนนั้น
        $last = DB::table('ar_requestorder_hds')
            ->whereYear('ar_requestorder_hds_date', date('Y', strtotime($date)))
            ->whereMonth('ar_requestorder_hds_date', date('m', strtotime($date)))
            ->where('ar_requestorder_hds_docuno', 'LIKE', $prefix . '%')
            ->orderBy('ar_requestorder_hds_docuno', 'desc')
            ->first();
        if ($last) {
            // ตัดเลขท้าย
            $running = (int)substr($last->ar_requestorder_hds_docuno, -4) + 1;
        } else {
            $running = 1;
        }
        // เติม 0 หน้า เช่น 0001
        $docno = $prefix . str_pad($running, 4, '0', STR_PAD_LEFT);
        return response()->json([
            'docno' => $docno
        ]);
    }

    public function CancelRequestOrderDoc(Request $request)
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
}
