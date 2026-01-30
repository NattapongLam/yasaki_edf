<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\WhWarehouse;
use Illuminate\Http\Request;
use App\Models\WhIssuestockDt;
use App\Models\WhIssuestockHd;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class WhIssueStockListController extends Controller
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
        $hd = WhIssuestockHd::leftjoin('wh_issuestock_statuses','wh_issuestock_hds.wh_issuestock_statuses_id','=','wh_issuestock_statuses.wh_issuestock_statuses_id')
        ->leftjoin('wh_warehouses','wh_issuestock_hds.wh_warehouses_id','=','wh_warehouses.wh_warehouses_id')
        ->get();
        return view('warehouses.form-issuestock-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $warehouses = WhWarehouse::where('wh_warehouses_flag',true)->get();
        return view('warehouses.form-issuestock-create', compact('warehouses'));
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
            'wh_issuestock_hds_date' => ['required'],
            'wh_issuestock_hds_docuno' => ['required'],
            'wh_warehouses_id' => ['required'],
            'wh_product_lists_id' => ['required'],
        ]); 
        $data = [
            'wh_issuestock_hds_date' => $request->wh_issuestock_hds_date,
            'wh_issuestock_hds_docuno' => $request->wh_issuestock_hds_docuno,
            'wh_issuestock_hds_number' => 0,
            'wh_issuestock_statuses_id' => 1,
            'wh_warehouses_id' => $request->wh_warehouses_id,
            'wh_issuestock_hds_remark' => $request->wh_issuestock_hds_remark,
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now(), 
        ];
        try{
            DB::beginTransaction();
            $insertHD = WhIssuestockHd::create($data);   
            foreach ($request->wh_issuestock_dts_listno as $key => $value) {
                if (!isset($request->wh_product_lists_id[$key])) {
                    continue; // กัน error
                }

                $pd = DB::table('vw_stockcard')
                ->where('wh_product_lists_id',$request->wh_product_lists_id[$key])
                ->where('wh_warehouses_id',$request->wh_warehouses_id)
                ->first();
                if (!$pd) continue;


                WhIssuestockDt::insert([
                    'wh_issuestock_hds_id' =>  $insertHD->wh_issuestock_hds_id,
                    'wh_issuestock_dts_listno' => $value,
                    'wh_product_lists_id' => $request->wh_product_lists_id[$key],
                    'wh_product_lists_code' => $pd->wh_product_lists_code,
                    'wh_product_lists_name' => $pd->wh_product_lists_name1,
                    'wh_product_lists_unit' => $pd->wh_product_units_name,
                    'wh_issuestock_dts_qty' => $request->wh_issuestock_dts_qty[$key],
                    'wh_issuestock_dts_cost' => $pd->costqty,
                    'stc_stockcard_qty' => $pd->goodqty,
                    'wh_issuestock_dts_flag' => true,
                    'person_at' => Auth::user()->name,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'poststock' => "N",
                    'return_qty' => 0,
                ]);
            }                
            DB::commit();
            return redirect()->route('issuestocks.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $warehouses = WhWarehouse::where('wh_warehouses_flag',true)->get();
        $hd = WhIssuestockHd::find($id);
        $dt = WhIssuestockDt::where('wh_issuestock_hds_id',$id)->where('wh_issuestock_dts_flag',true)->get();
        return view('warehouses.form-issuestock-approved', compact('warehouses','hd','dt'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $warehouses = WhWarehouse::where('wh_warehouses_flag',true)->get();
        $hd = WhIssuestockHd::find($id);
        $dt = WhIssuestockDt::where('wh_issuestock_hds_id',$id)->where('wh_issuestock_dts_flag',true)->get();
        return view('warehouses.form-issuestock-edit', compact('warehouses','hd','dt'));
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
                'wh_issuestock_statuses_id' => 1,
                'wh_warehouses_id' => $request->wh_warehouses_id,
                'wh_issuestock_hds_remark' => $request->wh_issuestock_hds_remark,
                'person_at' => Auth::user()->name,
                'updated_at' => Carbon::now(), 
            ];
             try{
            DB::beginTransaction();
            $insertHD = WhIssuestockHd::where('wh_issuestock_hds_id',$id)->update($data);   
            if($request->wh_issuestock_dts_id){
                foreach ($request->wh_issuestock_dts_id as $key => $value) {
                    WhIssuestockDt::where('wh_issuestock_dts_id',$value)->update([
                        'wh_issuestock_dts_qty' => $request->wh_issuestock_dts_qty[$key],
                        'wh_issuestock_dts_flag' => true,
                        'person_at' => Auth::user()->name,
                        'updated_at' => now(),
                        'poststock' => "N"
                    ]);
                }
            }else{
                foreach ($request->wh_issuestock_dts_listno as $key => $value) {
                if (!isset($request->wh_product_lists_id[$key])) {
                    continue; // กัน error
                }

                $pd = DB::table('vw_stockcard')
                ->where('wh_product_lists_id',$request->wh_product_lists_id[$key])
                ->where('wh_warehouses_id',$request->wh_warehouses_id)
                ->first();
                if (!$pd) continue;


                WhIssuestockDt::insert([
                    'wh_issuestock_hds_id' =>  $insertHD->wh_issuestock_hds_id,
                    'wh_issuestock_dts_listno' => $value,
                    'wh_product_lists_id' => $request->wh_product_lists_id[$key],
                    'wh_product_lists_code' => $pd->wh_product_lists_code,
                    'wh_product_lists_name' => $pd->wh_product_lists_name1,
                    'wh_product_lists_unit' => $pd->wh_product_units_name,
                    'wh_issuestock_dts_qty' => $request->wh_issuestock_dts_qty[$key],
                    'wh_issuestock_dts_cost' => $pd->costqty,
                    'stc_stockcard_qty' => $pd->goodqty,
                    'wh_issuestock_dts_flag' => true,
                    'person_at' => Auth::user()->name,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'poststock' => "N"
                ]);
            }  
            }
                          
            DB::commit();
            return redirect()->route('issuestocks.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        }catch(\Exception $e){
            Log::error($e->getMessage());
            dd($e->getMessage());
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด');
        } 

        }elseif($request->checkdoc == "Approved"){
              try{
                DB::beginTransaction();
                $insertHD = WhIssuestockHd::where('wh_issuestock_hds_id',$id)
                ->update([
                    'approved_date' => Carbon::now(),
                    'approved_by' => Auth::user()->name,
                    'approved_remark' => $request->approved_remark,
                    'wh_issuestock_statuses_id' => 3,
                ]);    
                $hd = WhIssuestockHd::find($id);
                $dt = WhIssuestockDt::where('wh_issuestock_hds_id',$id)
                ->where('wh_issuestock_dts_flag',true)
                ->get();
                foreach ($dt as $value) {
                    DB::table('stc_stockcard')->insert([
                        'stc_stockcard_date' => $hd->wh_issuestock_hds_date,
                        'stc_stockcard_docuno' => $hd->wh_issuestock_hds_docuno,
                        'wh_warehouses_id' => $hd->wh_warehouses_id,
                        'stockflag' => -1,
                        'wh_product_lists_id' => $value->wh_product_lists_id,
                        'wh_product_lists_code' => $value->wh_product_lists_code,
                        'wh_product_lists_unit' => $value->wh_product_lists_unit,
                        'stc_stockcard_qty' => $value->wh_issuestock_dts_qty,
                        'stc_stockcard_cost' => $value->wh_issuestock_dts_cost ?? 0,
                        'create_at' => Carbon::now(),
                        'person_at' => Auth::user()->name,
                    ]);
                    DB::table('wh_issuestock_dts')
                    ->where('wh_issuestock_dts_id',$value->wh_issuestock_dts_id)
                    ->update([
                        'poststock' => "Y"
                    ]);
                }                       
                DB::commit();
                return redirect()->route('issuestocks.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $prefix = "ISS-{$yy}{$mm}-";
        // หาเลขล่าสุดของเดือนนั้น
        $last = DB::table('wh_issuestock_hds')
            ->whereYear('wh_issuestock_hds_date', date('Y', strtotime($date)))
            ->whereMonth('wh_issuestock_hds_date', date('m', strtotime($date)))
            ->where('wh_issuestock_hds_docuno', 'LIKE', $prefix . '%')
            ->orderBy('wh_issuestock_hds_docuno', 'desc')
            ->first();
        if ($last) {
            // ตัดเลขท้าย
            $running = (int)substr($last->wh_issuestock_hds_docuno, -4) + 1;
        } else {
            $running = 1;
        }
        // เติม 0 หน้า เช่น 0001
        $docno = $prefix . str_pad($running, 4, '0', STR_PAD_LEFT);
        return response()->json([
            'docno' => $docno
        ]);
    }

    public function getProductsByWarehouse(Request $request)
    {
        $warehouseId = $request->wh_warehouses_id;

        $products = DB::table('vw_stockcard')
            ->where('wh_warehouses_id', $warehouseId)
            ->get();

        return response()->json($products);
    }

    public function CancelIssueStockDoc(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            WhIssuestockHd::where('wh_issuestock_hds_id',$id)->update([
                'wh_issuestock_statuses_id' => 2,
                'person_at' => Auth::user()->name,
                'updated_at'=> Carbon::now(),
            ]);
            WhIssuestockDt::where('wh_issuestock_hds_id',$id)->update([
                'wh_issuestock_dts_flag' => false,
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

    public function CancelIssueStockList(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            WhIssuestockDt::where('wh_issuestock_dts_id',$id)->update([
                'wh_issuestock_dts_flag' => false,
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
