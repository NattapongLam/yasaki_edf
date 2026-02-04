<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\AccTypevat;
use App\Models\AccCurrency;
use Illuminate\Http\Request;
use App\Models\ArQuotationHd;
use App\Models\ArSaleorderDt;
use App\Models\ArSaleorderHd;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ArSaleOrderListController extends Controller
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
        $hd = ArSaleorderHd::leftjoin('ar_saleorder_statuses','ar_saleorder_hds.ar_saleorder_statuses_id','=','ar_saleorder_statuses.ar_saleorder_statuses_id')
        ->get();
        return view('sales.form-saleorder-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $quotation = ArQuotationHd::whereIn('ar_quotation_statuses_id',[1,3])->get();
        $typevats = AccTypevat::whereIN('acc_typevats_id',[1,2,3])->get();
        $currencys = AccCurrency::get();
        $discounts = DB::table('acc_discount')->get();
        return view('sales.form-saleorder-create', compact('quotation','typevats','currencys','discounts'));
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
            'ar_quotation_hds_id' => ['required'],
            'ar_saleorder_hds_date' => ['required'],
            'ar_saleorder_hds_docuno' => ['required'],
        ]);      
        $data = [
            'ar_saleorder_hds_date' => $request->ar_saleorder_hds_date,
            'ar_saleorder_hds_docuno' => $request->ar_saleorder_hds_docuno,
            'ar_saleorder_hds_number' => 0,
            'ar_saleorder_statuses_id' => 1,
            'ar_quotation_hds_id' => $request->ar_quotation_hds_id,
            'ar_customer_lists_id' => $request->ar_customer_lists_id,
            'ar_customer_lists_code' => $request->ar_customer_lists_code,
            'ar_customer_lists_name' => $request->ar_customer_lists_name,
            'ar_customer_lists_address' => $request->ar_customer_lists_address,
            'ar_customer_lists_taxid' => $request->ar_customer_lists_taxid,
            'ar_customer_lists_contact' => $request->ar_customer_lists_contact,
            'ar_customer_lists_tel' => $request->ar_customer_lists_tel,
            'ar_customer_lists_email' => $request->ar_customer_lists_email,
            'ar_customer_lists_credit' => $request->ar_customer_lists_credit,
            'acc_typevats_id' => $request->acc_typevats_id,
            'acc_currencies_id' => $request->acc_currencies_id,
            'acc_discount_id' => $request->acc_discount_id,
            'ar_saleorder_hds_remark' => $request->ar_saleorder_hds_remark,
            'ar_saleorder_hds_base' => $request->ar_saleorder_hds_base,
            'ar_saleorder_hds_vat' => $request->ar_saleorder_hds_vat,
            'ar_saleorder_hds_net' => $request->ar_saleorder_hds_net,
            'ar_saleorder_hds_dis' => $request->ar_saleorder_hds_dis,
            'ar_saleorder_hds_amount' => $request->ar_saleorder_hds_net,
            'person_at' => Auth::user()->name,
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
        ]; 
        try{
            DB::beginTransaction();
            $insertHD = ArSaleorderHd::create($data);   
            foreach ($request->ar_saleorder_dts_listno as $key => $value) {
                ArSaleorderDt::insert([
                    'ar_saleorder_hds_id' => $insertHD->ar_saleorder_hds_id,
                    'ar_saleorder_dts_listno' => $value,
                    'wh_product_lists_id' => $request->wh_product_lists_id[$key],
                    'wh_product_lists_code' => $request->wh_product_lists_code[$key],
                    'wh_product_lists_name' => $request->wh_product_lists_name[$key],
                    'wh_product_lists_unit' => $request->wh_product_lists_unit[$key],
                    'acc_discount_qty' => $request->acc_discount_qty[$key],
                    'ar_saleorder_dts_qty' => $request->ar_saleorder_dts_qty[$key],
                    'ar_saleorder_dts_price' => $request->ar_saleorder_dts_price[$key],
                    'ar_saleorder_dts_base' => $request->ar_saleorder_dts_base[$key],
                    'ar_saleorder_dts_vat' => $request->ar_saleorder_dts_vat[$key],
                    'ar_saleorder_dts_net' => $request->ar_saleorder_dts_net[$key],
                    'ar_saleorder_dts_dis' => $request->ar_saleorder_dts_dis[$key],
                    'ar_saleorder_dts_amount' => $request->ar_saleorder_dts_amount[$key],
                    'ar_saleorder_dts_remark' => $request->ar_saleorder_dts_remark[$key],
                    'person_at' => Auth::user()->name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }     
            if($request->ar_quotation_hds_id <> 0){
                ArQuotationHd::where('ar_quotation_hds_id',$request->ar_quotation_hds_id)
                ->update([
                    'ar_quotation_statuses_id' => 4
                ]);   
            }   
           
            DB::commit();
            return redirect()->route('saleorders.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $quotation = ArQuotationHd::whereIn('ar_quotation_statuses_id',[1,3,4])->get();
        $typevats = AccTypevat::whereIN('acc_typevats_id',[1,2,3])->get();
        $currencys = AccCurrency::get();
        $discounts = DB::table('acc_discount')->get();
        $hd = ArSaleorderHd::find($id);
        $dt = ArSaleorderDt::where('ar_saleorder_hds_id',$id)->get();
        return view('sales.form-saleorder-edit', compact('quotation','typevats','currencys','discounts','hd','dt'));
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
            'ar_saleorder_statuses_id' => 1,
            'ar_quotation_hds_id' => $request->ar_quotation_hds_id,
            'ar_customer_lists_id' => $request->ar_customer_lists_id,
            'ar_customer_lists_code' => $request->ar_customer_lists_code,
            'ar_customer_lists_name' => $request->ar_customer_lists_name,
            'ar_customer_lists_address' => $request->ar_customer_lists_address,
            'ar_customer_lists_taxid' => $request->ar_customer_lists_taxid,
            'ar_customer_lists_contact' => $request->ar_customer_lists_contact,
            'ar_customer_lists_tel' => $request->ar_customer_lists_tel,
            'ar_customer_lists_email' => $request->ar_customer_lists_email,
            'ar_customer_lists_credit' => $request->ar_customer_lists_credit,
            'acc_typevats_id' => $request->acc_typevats_id,
            'acc_currencies_id' => $request->acc_currencies_id,
            'acc_discount_id' => $request->acc_discount_id,
            'ar_saleorder_hds_remark' => $request->ar_saleorder_hds_remark,
            'ar_saleorder_hds_base' => $request->ar_saleorder_hds_base,
            'ar_saleorder_hds_vat' => $request->ar_saleorder_hds_vat,
            'ar_saleorder_hds_net' => $request->ar_saleorder_hds_net,
            'ar_saleorder_hds_dis' => $request->ar_saleorder_hds_dis,
            'ar_saleorder_hds_amount' => $request->ar_saleorder_hds_net,
            'person_at' => Auth::user()->name,
            'updated_at'=> Carbon::now(),
        ];
        try{
            DB::beginTransaction();
            $insertHD = ArSaleorderHd::where('ar_saleorder_hds_id',$id)->update($data);   
            foreach ($request->ar_saleorder_dts_id as $key => $value) {
                ArSaleorderDt::where('ar_saleorder_dts_id',$value)->update([
                    'ar_saleorder_dts_remark' => $request->ar_saleorder_dts_remark[$key],
                    'person_at' => Auth::user()->name,
                    'updated_at' => now(),
                ]);
            }     
            DB::commit();
            return redirect()->route('saleorders.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $prefix = "IV-{$yy}{$mm}-";
        // หาเลขล่าสุดของเดือนนั้น
        $last = DB::table('ar_saleorder_hds')
            ->whereYear('ar_saleorder_hds_date', date('Y', strtotime($date)))
            ->whereMonth('ar_saleorder_hds_date', date('m', strtotime($date)))
            ->where('ar_saleorder_hds_docuno', 'LIKE', $prefix . '%')
            ->orderBy('ar_saleorder_hds_docuno', 'desc')
            ->first();
        if ($last) {
            // ตัดเลขท้าย
            $running = (int)substr($last->ar_saleorder_hds_docuno, -4) + 1;
        } else {
            $running = 1;
        }
        // เติม 0 หน้า เช่น 0001
        $docno = $prefix . str_pad($running, 4, '0', STR_PAD_LEFT);
        return response()->json([
            'docno' => $docno
        ]);
    }

    public function CancelSaleorderDoc(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            ArSaleorderHd::where('ar_saleorder_hds_id',$id)->update([
                'ar_saleorder_statuses_id' => 2,
                'person_at' => Auth::user()->name,
                'updated_at'=> Carbon::now(),
            ]);
            $hd = ArSaleorderHd::find($id);
            $updateHD = ArQuotationHd::where('ar_quotation_hds_id',$hd->ar_quotation_hds_id)
            ->update([
                'ar_quotation_statuses_id' => 1,
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

    public function print($id)
    {
        $hd = ArSaleorderHd::findOrFail($id);
        $dt = ArSaleorderDt::where('ar_saleorder_hds_id',$id)->get();

        return view('sales.form-saleorder-print', compact('hd','dt'));
    }
}
