<?php

namespace App\Http\Controllers;

use App\Models\ArInvoiceDt;
use App\Models\ArInvoiceHd;
use Illuminate\Http\Request;
use App\Models\ArQuotationDt;
use App\Models\ArQuotationHd;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ArInvoiceListController extends Controller
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
        $hd = ArInvoiceHd::leftjoin('ar_invoice_statuses','ar_invoice_hds.ar_invoice_statuses_id','=','ar_invoice_statuses.ar_invoice_statuses_id')
        ->leftjoin('ar_quotation_hds','ar_quotation_hds.ar_quotation_hds_id','=','ar_invoice_hds.ar_quotation_hds_id')
        ->get();
        return view('sales.form-invoice-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $quotation = ArQuotationHd::where('ar_quotation_statuses_id',1)->get();
        return view('sales.form-invoice-create', compact('quotation'));
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
            'ar_invoice_hds_date' => ['required'],
            'ar_invoice_hds_docuno' => ['required'],
            'ar_invoice_hds_percent' => ['required'],
            'ar_quotation_dts_listno' => ['required'],
        ]); 
        $data = [
            'ar_invoice_hds_date' => $request->ar_invoice_hds_date,
            'ar_invoice_hds_docuno' => $request->ar_invoice_hds_docuno,
            'ar_invoice_hds_number' => 0,
            'ar_invoice_statuses_id' => 1,
            'ar_quotation_hds_id' => $request->ar_quotation_hds_id,
            'ar_invoice_hds_percent' => $request->ar_invoice_hds_percent,
            'ar_invoice_hds_base' => $request->ar_invoice_hds_base,
            'ar_invoice_hds_vat' => $request->ar_invoice_hds_vat,
            'ar_invoice_hds_net' => $request->ar_invoice_hds_net,
            'ar_invoice_hds_remark' => $request->ar_invoice_hds_remark,
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
         try{
            DB::beginTransaction();
            $insertHD = ArInvoiceHd::create($data);   
            foreach ($request->ar_quotation_dts_listno as $key => $value) {
                ArInvoiceDt::insert([
                    'ar_invoice_hds_id' => $insertHD->ar_invoice_hds_id,
                    'ar_invoice_dts_listno' => $request->ar_invoice_dts_listno[$key],
                    'wh_product_lists_id' => $request->wh_product_lists_id[$key],
                    'wh_product_lists_code' => $request->wh_product_lists_code[$key],
                    'wh_product_lists_name' => $request->wh_product_lists_name[$key],
                    'wh_product_lists_unit' => $request->wh_product_lists_unit[$key],
                    'ar_invoice_dts_remark' => $request->ar_invoice_dts_remark[$key],
                    'ar_invoice_dts_qty' => $request->ar_invoice_dts_qty[$key],
                    'ar_invoice_dts_price' => $request->ar_invoice_dts_price[$key],
                    'ar_invoice_dts_amount' => $request->ar_invoice_dts_amount[$key],
                    'ar_invoice_dts_discount' => $request->ar_invoice_dts_discount[$key],
                    'person_at' => Auth::user()->name,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
            $updateHD = ArQuotationHd::where('ar_quotation_hds_id',$request->ar_quotation_hds_id)
            ->update([
                'ar_quotation_statuses_id' => 3,
            ]);            
            DB::commit();
            return redirect()->route('invoices.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $hd = ArInvoiceHd::find($id);
        $dt = ArInvoiceDt::where('ar_invoice_hds_id',$id)->get();
        $quotation = ArQuotationHd::whereIn('ar_quotation_statuses_id',[1,3])->get();
        return view('sales.form-invoice-edit', compact('quotation','hd','dt'));
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
        $prefix = "IN-{$yy}{$mm}-";
        // หาเลขล่าสุดของเดือนนั้น
        $last = DB::table('ar_invoice_hds')
            ->whereYear('ar_invoice_hds_date', date('Y', strtotime($date)))
            ->whereMonth('ar_invoice_hds_date', date('m', strtotime($date)))
            ->where('ar_invoice_hds_docuno', 'LIKE', $prefix . '%')
            ->orderBy('ar_invoice_hds_docuno', 'desc')
            ->first();
        if ($last) {
            // ตัดเลขท้าย
            $running = (int)substr($last->ar_invoice_hds_docuno, -4) + 1;
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
        $items = ArQuotationDt::where('ar_quotation_dts_flag',true)
                ->where('ar_quotation_hds_id',$request->id)
                ->get();
        return response()->json($items);
    }

    public function CancelInvoicesDoc(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            ArInvoiceHd::where('ar_invoice_hds_id',$id)->update([
                'ar_invoice_statuses_id' => 2,
                'person_at' => Auth::user()->name,
                'updated_at'=> Carbon::now(),
            ]);
            $hd = ArInvoiceHd::find($id);
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
        $hd = ArInvoiceHd::leftjoin('ar_quotation_hds','ar_invoice_hds.ar_quotation_hds_id','=','ar_quotation_hds.ar_quotation_hds_id')
        ->where('ar_invoice_hds_id',$id)->first();
        $dt = ArInvoiceDt::where('ar_invoice_hds_id', $id)->get();
        return view('sales.form-invoice-print', compact('hd', 'dt'));
    }
}
