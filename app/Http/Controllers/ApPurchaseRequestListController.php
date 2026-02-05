<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\WhProductList;
use App\Models\WhProductUnit;
use Illuminate\Support\Facades\DB;
use App\Models\ApPurchaserequestDt;
use App\Models\ApPurchaserequestHd;
use Illuminate\Support\Facades\Auth;

class ApPurchaseRequestListController extends Controller
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
        $hd = ApPurchaserequestHd::leftjoin('ap_purchaserequest_statuses','ap_purchaserequest_hds.ap_purchaserequest_statuses_id','=','ap_purchaserequest_statuses.ap_purchaserequest_statuses_id')
        ->leftjoin('ms_allocate','ap_purchaserequest_hds.ms_allocate_id','=','ms_allocate.ms_allocate_id')
        ->get();
        return view('purchases.form-purchaserequest-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allocates = DB::table('ms_allocate')->get();
        $products = WhProductList::where('wh_product_lists_flag',true)->get();
        return view('purchases.form-purchaserequest-create', compact('allocates','products'));
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
            'ap_purchaserequest_hds_date' => ['required'],
            'ap_purchaserequest_hds_docuno' => ['required'],
            'ms_allocate_id' => ['required'],
            'ap_purchaserequest_dts_listno' => ['required'],
        ]); 
        $data = [
            'ap_purchaserequest_hds_date' => $request->ap_purchaserequest_hds_date,
            'ap_purchaserequest_hds_docuno' => $request->ap_purchaserequest_hds_docuno,
            'ap_purchaserequest_hds_number' => 0,
            'ap_purchaserequest_statuses_id' => 1,
            'ms_allocate_id' => $request->ms_allocate_id,
            'ap_purchaserequest_hds_remark' => $request->ap_purchaserequest_hds_remark,
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        try{
            DB::beginTransaction();
            $insertHD = ApPurchaserequestHd::create($data);   
            foreach ($request->ap_purchaserequest_dts_listno as $key => $value) {
                if (!isset($request->wh_product_lists_id[$key])) {
                    continue; // กัน error
                }

                $pd = WhProductList::find($request->wh_product_lists_id[$key]);
                if (!$pd) continue;

                $unit = WhProductUnit::find($pd->wh_product_units_id);

                ApPurchaserequestDt::insert([
                    'ap_purchaserequest_hds_id' => $insertHD->ap_purchaserequest_hds_id,
                    'ap_purchaserequest_dts_listno' => $value,
                    'wh_product_lists_id' => $request->wh_product_lists_id[$key],
                    'wh_product_lists_code' => $pd->wh_product_lists_code,
                    'wh_product_lists_name' => $pd->wh_product_lists_name1,
                    'wh_product_lists_unit' => optional($unit)->wh_product_units_name,

                    'ap_purchaserequest_dts_qty' => $request->ap_purchaserequest_dts_qty[$key] ?? 0,
                    'ap_purchaserequest_hds_duedate' => $request->ap_purchaserequest_hds_duedate[$key],
                    'ap_purchaserequest_dts_remark' => $request->ap_purchaserequest_dts_remark[$key],

                    'ap_purchaserequest_dts_flag' => true,
                    'person_at' => Auth::user()->name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }                
            DB::commit();
            return redirect()->route('purchaserequests.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $allocates = DB::table('ms_allocate')->get();
        $products = WhProductList::where('wh_product_lists_flag',true)->get();
        $hd = ApPurchaserequestHd::find($id);
        $dt = ApPurchaserequestDt::where('ap_purchaserequest_dts_flag',true)->where('ap_purchaserequest_hds_id',$id)->get();
        return view('purchases.form-purchaserequest-approved', compact('allocates','products','hd','dt'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $allocates = DB::table('ms_allocate')->get();
        $products = WhProductList::where('wh_product_lists_flag',true)->get();
        $hd = ApPurchaserequestHd::find($id);
        $dt = ApPurchaserequestDt::where('ap_purchaserequest_dts_flag',true)->where('ap_purchaserequest_hds_id',$id)->get();
        return view('purchases.form-purchaserequest-edit', compact('allocates','products','hd','dt'));
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
        if($request->checkdoc == "Edit"){
            $data = [
                'ap_purchaserequest_statuses_id' => 1,
                'ms_allocate_id' => $request->ms_allocate_id,
                'ap_purchaserequest_hds_remark' => $request->ap_purchaserequest_hds_remark,
                'person_at' => Auth::user()->name,
                'updated_at' => Carbon::now(),
            ];
            try{
                DB::beginTransaction();
                ApPurchaserequestHd::where('ap_purchaserequest_hds_id',$id)->update($data);  
                if(!empty($request->ap_purchaserequest_dts_listno)){
                    foreach ($request->ap_purchaserequest_dts_listno as $key => $value) {
                        if (!isset($request->wh_product_lists_id[$key])) {
                            continue; // กัน error
                        }
                        $pd = WhProductList::find($request->wh_product_lists_id[$key]);
                        if (!$pd) continue;
                        $unit = WhProductUnit::find($pd->wh_product_units_id);
                        if(!empty($request->ap_purchaserequest_dts_id[$key])){
                            ApPurchaserequestDt::where('ap_purchaserequest_dts_id',$request->ap_purchaserequest_dts_id[$key])->update([
                                'wh_product_lists_id' => $request->wh_product_lists_id[$key],
                                'wh_product_lists_code' => $pd->wh_product_lists_code,
                                'wh_product_lists_name' => $pd->wh_product_lists_name1,
                                'wh_product_lists_unit' => optional($unit)->wh_product_units_name,

                                'ap_purchaserequest_dts_qty' => $request->ap_purchaserequest_dts_qty[$key] ?? 0,
                                'ap_purchaserequest_hds_duedate' => $request->ap_purchaserequest_hds_duedate[$key],
                                'ap_purchaserequest_dts_remark' => $request->ap_purchaserequest_dts_remark[$key],

                                'ap_purchaserequest_dts_flag' => true,
                                'person_at' => Auth::user()->name,
                                'updated_at' => now(),
                            ]);
                        }else{
                            $insertHD = ApPurchaserequestHd::find($id);
                            ApPurchaserequestDt::insert([
                                'ap_purchaserequest_hds_id' => $insertHD->ap_purchaserequest_hds_id,
                                'ap_purchaserequest_dts_listno' => $value,
                                'wh_product_lists_id' => $request->wh_product_lists_id[$key],
                                'wh_product_lists_code' => $pd->wh_product_lists_code,
                                'wh_product_lists_name' => $pd->wh_product_lists_name1,
                                'wh_product_lists_unit' => optional($unit)->wh_product_units_name,

                                'ap_purchaserequest_dts_qty' => $request->ap_purchaserequest_dts_qty[$key] ?? 0,
                                'ap_purchaserequest_hds_duedate' => $request->ap_purchaserequest_hds_duedate[$key],
                                'ap_purchaserequest_dts_remark' => $request->ap_purchaserequest_dts_remark[$key],

                                'ap_purchaserequest_dts_flag' => true,
                                'person_at' => Auth::user()->name,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                       
                    }  
                }                             
                DB::commit();
                return redirect()->route('purchaserequests.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            }catch(\Exception $e){
                Log::error($e->getMessage());
                dd($e->getMessage());
                return redirect()->back()->with('error', 'เกิดข้อผิดพลาด');
            }  

        }elseif($request->checkdoc == "Approved"){
             try{
                DB::beginTransaction();
                $insertHD = ApPurchaserequestHd::where('ap_purchaserequest_hds_id',$id)
                ->update([
                    'approved_date' => Carbon::now(),
                    'approved_by' => Auth::user()->name,
                    'approved_remark' => $request->approved_remark,
                    'ap_purchaserequest_statuses_id' => 3,
                ]);                              
                DB::commit();
                return redirect()->route('purchaserequests.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            }catch(\Exception $e){
                Log::error($e->getMessage());
                dd($e->getMessage());
                return redirect()->back()->with('error', 'เกิดข้อผิดพลาด');
            } 
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
        $prefix = "PR-{$yy}{$mm}-";
        // หาเลขล่าสุดของเดือนนั้น
        $last = DB::table('ap_purchaserequest_hds')
            ->whereYear('ap_purchaserequest_hds_date', date('Y', strtotime($date)))
            ->whereMonth('ap_purchaserequest_hds_date', date('m', strtotime($date)))
            ->where('ap_purchaserequest_hds_docuno', 'LIKE', $prefix . '%')
            ->orderBy('ap_purchaserequest_hds_docuno', 'desc')
            ->first();
        if ($last) {
            // ตัดเลขท้าย
            $running = (int)substr($last->ap_purchaserequest_hds_docuno, -4) + 1;
        } else {
            $running = 1;
        }
        // เติม 0 หน้า เช่น 0001
        $docno = $prefix . str_pad($running, 4, '0', STR_PAD_LEFT);
        return response()->json([
            'docno' => $docno
        ]);
    }

    public function CancelPurchaseRequestDoc(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            ApPurchaserequestHd::where('ap_purchaserequest_hds_id',$id)->update([
                'ap_purchaserequest_statuses_id' => 2,
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

    public function CancelPurchaseRequestList(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            ApPurchaserequestDt::where('ap_purchaserequest_dts_id',$id)->update([
                'ap_purchaserequest_dts_flag' => false,
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
