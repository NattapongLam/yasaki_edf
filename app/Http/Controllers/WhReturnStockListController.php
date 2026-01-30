<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\WhWarehouse;
use Illuminate\Http\Request;
use App\Models\WhIssuestockDt;
use App\Models\WhIssuestockHd;
use App\Models\WhReturnstockDt;
use App\Models\WhReturnstockHd;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class WhReturnStockListController extends Controller
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
        $hd = WhReturnstockHd::leftjoin('wh_returnstock_statuses','wh_returnstock_hds.wh_returnstock_statuses_id','=','wh_returnstock_statuses.wh_returnstock_statuses_id')
        ->leftjoin('wh_warehouses','wh_returnstock_hds.wh_warehouses_id','=','wh_warehouses.wh_warehouses_id')
        ->leftjoin('wh_issuestock_hds','wh_returnstock_hds.wh_issuestock_hds_id','=','wh_issuestock_hds.wh_issuestock_hds_id')
        ->get();
        return view('warehouses.form-returnstock-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $issuestocks = WhIssuestockHd::whereIn('wh_issuestock_statuses_id',[3,5])->get();
        $warehouses = WhWarehouse::where('wh_warehouses_flag',true)->get();
        return view('warehouses.form-returnstock-create', compact('warehouses','issuestocks'));
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
            'wh_returnstock_hds_date' => ['required'],
            'wh_returnstock_hds_docuno' => ['required'],
            'wh_issuestock_hds_id' => ['required'],
            'wh_warehouses_id' => ['required'],
            'wh_issuestock_dts_id' => ['required'],
        ]); 
        $data = [
            'wh_returnstock_hds_date' => $request->wh_returnstock_hds_date,
            'wh_returnstock_hds_docuno' => $request->wh_returnstock_hds_docuno,
            'wh_returnstock_hds_number' => 0,
            'wh_returnstock_statuses_id' => 1,
            'wh_issuestock_hds_id' => $request->wh_issuestock_hds_id,
            'wh_warehouses_id' => $request->wh_warehouses_id,
            'wh_returnstock_hds_remark' => $request->wh_returnstock_hds_remark,
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now(), 
        ];
         try{
            DB::beginTransaction();
            $insertHD = WhReturnstockHd::create($data);   
            foreach ($request->wh_issuestock_dts_id as $key => $value) {
                WhReturnstockDt::insert([
                    'wh_returnstock_hds_id' => $insertHD->wh_returnstock_hds_id,
                    'wh_returnstock_dts_listno' => $request->wh_returnstock_dts_listno[$key],
                    'wh_product_lists_id' => $request->wh_product_lists_id[$key],
                    'wh_product_lists_code' =>  $request->wh_product_lists_code[$key],
                    'wh_product_lists_name'  => $request->wh_product_lists_name[$key],
                    'wh_product_lists_unit' => $request->wh_product_lists_unit[$key],
                    'wh_returnstock_dts_qty' => $request->wh_returnstock_dts_qty[$key],
                    'wh_returnstock_dts_cost' => $request->wh_returnstock_dts_cost[$key],
                    'wh_issuestock_dts_id' => $value,
                    'wh_issuestock_dts_qty' => $request->wh_issuestock_dts_qty[$key],
                    'wh_returnstock_dts_flag' => true,
                    'person_at' => Auth::user()->name,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'poststock' => "N"
                ]);
                DB::table('stc_stockcard')->insert([
                        'stc_stockcard_date' => $insertHD->wh_returnstock_hds_date,
                        'stc_stockcard_docuno' => $insertHD->wh_returnstock_hds_docuno,
                        'wh_warehouses_id' => $request->wh_warehouses_id,
                        'stockflag' => 1,
                        'wh_product_lists_id' =>$request->wh_product_lists_id[$key],
                        'wh_product_lists_code' => $request->wh_product_lists_code[$key],
                        'wh_product_lists_unit' =>$request->wh_product_lists_unit[$key],
                        'stc_stockcard_qty' => $request->wh_returnstock_dts_qty[$key],
                        'stc_stockcard_cost' =>$request->wh_returnstock_dts_cost[$key] ?? 0,
                        'create_at' => Carbon::now(),
                        'person_at' => Auth::user()->name,
                ]);
                WhIssuestockDt::where('wh_issuestock_dts_id',$value)
                ->update([
                    'return_qty' => $request->wh_returnstock_dts_qty[$key]
                ]);
            }                
            DB::commit();
            return redirect()->route('returnstocks.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        //
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

    public function runNo(Request $request)
    {
        $date = $request->date; // YYYY-MM-DD
        $yy = date('y', strtotime($date));
        $mm = date('m', strtotime($date));
        // รูปแบบ prefix เช่น QT-YYMM-
        $prefix = "RTS-{$yy}{$mm}-";
        // หาเลขล่าสุดของเดือนนั้น
        $last = DB::table('wh_returnstock_hds')
            ->whereYear('wh_returnstock_hds_date', date('Y', strtotime($date)))
            ->whereMonth('wh_returnstock_hds_date', date('m', strtotime($date)))
            ->where('wh_returnstock_hds_docuno', 'LIKE', $prefix . '%')
            ->orderBy('wh_returnstock_hds_docuno', 'desc')
            ->first();
        if ($last) {
            // ตัดเลขท้าย
            $running = (int)substr($last->wh_returnstock_hds_docuno, -4) + 1;
        } else {
            $running = 1;
        }
        // เติม 0 หน้า เช่น 0001
        $docno = $prefix . str_pad($running, 4, '0', STR_PAD_LEFT);
        return response()->json([
            'docno' => $docno
        ]);
    }
    
    public function getItems(Request $request)
    {
        $items = WhIssuestockDt::where('wh_issuestock_dts_flag',true)
                ->where('wh_issuestock_hds_id',$request->id)
                ->get();
        return response()->json($items);
    }

    public function CancelReturnStockDoc(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            WhReturnstockHd::where('wh_returnstock_hds_id',$id)->update([
                'wh_returnstock_statuses_id' => 2,
                'person_at' => Auth::user()->name,
                'updated_at'=> Carbon::now(),
            ]);
            WhReturnstockDt::where('wh_returnstock_hds_id',$id)->update([
                'wh_returnstock_dts_flag' => false,
                'person_at' => Auth::user()->name,
                'updated_at'=> Carbon::now(),
            ]);
            $hd = WhReturnstockHd::find($id);
            $dt = WhReturnstockDt::where('wh_returnstock_hds_id',$id)->where('wh_returnstock_dts_flag',true)->get();
            foreach ($dt as $value) {
                DB::table('stc_stockcard')->insert([
                    'stc_stockcard_date' => $hd->wh_returnstock_hds_date,
                    'stc_stockcard_docuno' => 'CC-' . $hd->wh_returnstock_hds_docuno,
                    'wh_warehouses_id' => $hd->wh_warehouses_id,
                    'stockflag' => 1,
                    'wh_product_lists_id' => $value->wh_product_lists_id,
                    'wh_product_lists_code' => $value->wh_product_lists_code,
                    'wh_product_lists_unit' => $value->wh_product_lists_unit,
                    'stc_stockcard_qty' => $value->wh_returnstock_dts_qty,
                    'stc_stockcard_cost' => $value->wh_returnstock_dts_cost ?? 0,
                    'create_at' => Carbon::now(),
                    'person_at' => Auth::user()->name,
                ]);
            }
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
