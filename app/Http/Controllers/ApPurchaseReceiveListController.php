<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\AccTypevat;
use App\Models\AccCurrency;
use App\Models\WhWarehouse;
use App\Models\ApVendorList;
use Illuminate\Http\Request;
use App\Models\ApPurchaseorderDt;
use App\Models\ApPurchaseorderHd;
use Illuminate\Support\Facades\DB;
use App\Models\ApPurchaseReceiveDt;
use App\Models\ApPurchaseReceiveHd;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ApPurchaseReceiveListController extends Controller
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
        $hd = ApPurchaseReceiveHd::leftjoin('ap_purchase_receive_statuses','ap_purchase_receive_hds.ap_purchase_receive_statuses_id','=','ap_purchase_receive_statuses.ap_purchase_receive_statuses_id')
        ->leftjoin('wh_warehouses','ap_purchase_receive_hds.wh_warehouses_id','=','wh_warehouses.wh_warehouses_id')
        ->get();
        return view('purchases.form-purchasereceive-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $purchaseorders = ApPurchaseorderHd::whereIn('ap_purchaseorder_statuses_id',[3,5])->get();
        $warehouses = WhWarehouse::where('wh_warehouses_flag',true)->get();
        return view('purchases.form-purchasereceive-create', compact('purchaseorders','warehouses'));
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
            'ap_purchase_receive_hds_date' => ['required'],
            'ap_purchase_receive_hds_docuno' => ['required'],
            'wh_warehouses_id' => ['required'],
            'ap_purchaseorder_hds_id' => ['required'],
        ]); 
        $po = ApPurchaseorderHd::find($request->ap_purchaseorder_hds_id);
        $data = [
            'ap_purchase_receive_hds_date' => $request->ap_purchase_receive_hds_date,
            'ap_purchase_receive_hds_docuno' => $request->ap_purchase_receive_hds_docuno,
            'ap_purchase_receive_hds_number' => 0,
            'ap_purchase_receive_statuses_id' => 1,
            'ap_vendor_lists_id' => $po->ap_vendor_lists_id,
            'ap_vendor_lists_code' => $po->ap_vendor_lists_code,
            'ap_vendor_lists_name' => $po->ap_vendor_lists_name,
            'ap_vendor_lists_address' => $po->ap_vendor_lists_address,
            'ap_vendor_lists_taxid' => $po->ap_vendor_lists_taxid,
            'ap_vendor_lists_credit' => $po->ap_vendor_lists_credit,
            'acc_typevats_id' => $po->acc_typevats_id,
            'acc_currencies_id' => $po->acc_currencies_id,
            'acc_discount_id' => $po->acc_discount_id,
            'acc_discount_qty' => $po->acc_discount_qty,
            'ap_purchase_receive_hds_remark' => $request->ap_purchase_receive_hds_remark,
            'ap_purchase_receive_hds_base' => $request->ap_purchase_receive_hds_base,
            'ap_purchase_receive_hds_vat' => $request->ap_purchase_receive_hds_vat,
            'ap_purchase_receive_hds_net' => $request->ap_purchase_receive_hds_net,
            'ap_purchase_receive_hds_dis' => $request->ap_purchase_receive_hds_dis,
            'ap_purchase_receive_hds_amount' => $request->ap_purchase_receive_hds_net,
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'wh_warehouses_id' => $request->wh_warehouses_id,
            'ap_purchaseorder_hds_id' => $request->ap_purchaseorder_hds_id,
        ];
        try{
            DB::beginTransaction();
            $insertHD = ApPurchaseReceiveHd::create($data);   
            foreach ($request->ap_purchaseorder_dts_id as $key => $value) {
                ApPurchaseReceiveDt::insert([
                    'ap_purchase_receive_hds_id' =>  $insertHD->ap_purchase_receive_hds_id,
                    'ap_purchase_receive_dts_listno' => $request->ap_purchase_receive_dts_listno[$key],
                    'ap_purchaseorder_dts_id' => $value,
                    'wh_product_lists_id' => $request->wh_product_lists_id[$key],
                    'wh_product_lists_code' => $request->wh_product_lists_code[$key],
                    'wh_product_lists_name' => $request->wh_product_lists_name[$key],
                    'wh_product_lists_unit' => $request->wh_product_lists_unit[$key],
                    'acc_discount_qty' => $request->acc_discount_qty[$key],
                    'ap_purchase_receive_dts_qty' => $request->ap_purchase_receive_dts_qty[$key],
                    'ap_purchase_receive_dts_price' => $request->ap_purchase_receive_dts_price[$key],
                    'ap_purchase_receive_dts_base' => $request->ap_purchase_receive_dts_base[$key],
                    'ap_purchase_receive_dts_vat' => $request->ap_purchase_receive_dts_vat[$key],
                    'ap_purchase_receive_dts_net' => $request->ap_purchase_receive_dts_net[$key],
                    'ap_purchase_receive_dts_dis' => $request->ap_purchase_receive_dts_dis[$key],
                    'ap_purchase_receive_dts_amount' => $request->ap_purchase_receive_dts_net[$key],
                    'ap_purchase_receive_dts_remark' => $request->ap_purchase_receive_dts_remark[$key],
                    'ms_allocate_id' => $request->ms_allocate_id[$key],
                    'ap_purchaseorder_hds_docuno' => $request->ap_purchaseorder_hds_docuno[$key],
                    'ap_purchaseorder_dts_qty' => $request->ap_purchaseorder_dts_qty[$key],
                    'ap_purchase_receive_dts_flag' => true,
                    'person_at' => Auth::user()->name,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                DB::table('stc_stockcard')->insert([
                    'stc_stockcard_date' => $request->ap_purchase_receive_hds_date,
                    'stc_stockcard_docuno' => $request->ap_purchase_receive_hds_docuno,
                    'wh_warehouses_id' => $request->wh_warehouses_id,
                    'stockflag' => 1,
                    'wh_product_lists_id' => $request->wh_product_lists_id[$key],
                    'wh_product_lists_code' => $request->wh_product_lists_code[$key],
                    'wh_product_lists_unit' => $request->wh_product_lists_unit[$key],
                    'stc_stockcard_qty' => $request->ap_purchase_receive_dts_qty[$key],
                    'stc_stockcard_cost' => ($request->ap_purchase_receive_dts_price[$key] ?? 0)- ($request->acc_discount_qty[$key] ?? 0),
                    'create_at' => Carbon::now(),
                    'person_at' => Auth::user()->name,
                ]);
            }           
            DB::commit();
            $ckqty = DB::table('vw_purchaseorder')
            ->where('ap_purchaseorder_hds_id',$po->ap_purchaseorder_hds_id)
            ->where('po_total','>',0) 
            ->first(); 
            if($ckqty){
                ApPurchaseorderHd::where('ap_purchaseorder_hds_id',$po->ap_purchaseorder_hds_id)
                ->update([
                    'ap_purchaseorder_statuses_id' => 5
                ]);
            }else{
                ApPurchaseorderHd::where('ap_purchaseorder_hds_id',$po->ap_purchaseorder_hds_id)
                ->update([
                    'ap_purchaseorder_statuses_id' => 4
                ]);
            }   
            DB::commit();       
            return redirect()->route('purchasereceives.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $prefix = "GR-{$yy}{$mm}-";
        // หาเลขล่าสุดของเดือนนั้น
        $last = DB::table('ap_purchase_receive_hds')
            ->whereYear('ap_purchase_receive_hds_date', date('Y', strtotime($date)))
            ->whereMonth('ap_purchase_receive_hds_date', date('m', strtotime($date)))
            ->where('ap_purchase_receive_hds_docuno', 'LIKE', $prefix . '%')
            ->orderBy('ap_purchase_receive_hds_docuno', 'desc')
            ->first();
        if ($last) {
            // ตัดเลขท้าย
            $running = (int)substr($last->ap_purchase_receive_hds_docuno, -4) + 1;
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
        $items = DB::table('vw_purchaseorder')
                ->where('ap_purchaseorder_hds_id',$request->id)
                ->get();
        return response()->json($items);
    }

    public function CancelPurchaseReceiveDoc(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            ApPurchaseReceiveHd::where('ap_purchase_receive_hds_id',$id)->update([
                'ap_purchase_receive_statuses_id' => 2,
                'person_at' => Auth::user()->name,
                'updated_at'=> Carbon::now(),
            ]);
            ApPurchaseReceiveDt::where('ap_purchase_receive_hds_id',$id)->update([
                'ap_purchase_receive_dts_flag' => false,
                'person_at' => Auth::user()->name,
                'updated_at'=> Carbon::now(),
            ]);
            $hd = ApPurchaseReceiveHd::find($id);
            $dt = ApPurchaseReceiveDt::where('ap_purchase_receive_hds_id',$id)->get();
            foreach ($dt as $value) {
                DB::table('stc_stockcard')->insert([
                    'stc_stockcard_date' => $hd->ap_purchase_receive_hds_date,
                    'stc_stockcard_docuno' => 'CC-' . $hd->ap_purchase_receive_hds_docuno,
                    'wh_warehouses_id' => $hd->wh_warehouses_id,
                    'stockflag' => -1,
                    'wh_product_lists_id' => $value->wh_product_lists_id,
                    'wh_product_lists_code' => $value->wh_product_lists_code,
                    'wh_product_lists_unit' => $value->wh_product_lists_unit,
                    'stc_stockcard_qty' => $value->ap_purchase_receive_dts_qty,
                    'stc_stockcard_cost' => 
                        ($value->ap_purchase_receive_dts_price ?? 0)
                        - ($value->acc_discount_qty ?? 0),
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
