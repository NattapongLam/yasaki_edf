<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\AccCompany;
use App\Models\AccTypevat;
use App\Models\AccCurrency;
use App\Models\ApVendorList;
use Illuminate\Http\Request;
use App\Models\ApPurchaseorderDt;
use App\Models\ApPurchaseorderHd;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ApPurchaseOrderListController extends Controller
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
        $hd = ApPurchaseorderHd::leftjoin('ap_purchaseorder_statuses','ap_purchaseorder_hds.ap_purchaseorder_statuses_id','=','ap_purchaseorder_statuses.ap_purchaseorder_statuses_id')
        ->get();
        return view('purchases.form-purchaseorder-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $typevats = AccTypevat::whereIN('acc_typevats_id',[4,5,6])->get();
        $currencys = AccCurrency::get();
        $discounts = DB::table('acc_discount')->get();
        $requests = DB::table('vw_purchaserequest')->where('pr_total','>',0)->get();
        $vendors =  ApVendorList::where('ap_vendor_lists_flag',true)->get();
        return view('purchases.form-purchaseorder-create', compact('typevats','currencys','discounts','requests','vendors'));
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
            'ap_purchaseorder_hds_date' => ['required'],
            'ap_purchaseorder_hds_docuno' => ['required'],
            'ap_vendor_lists_id' => ['required'],
            'acc_typevats_id' => ['required'],
            'ap_purchaserequest_dts_id' => ['required'],
        ]); 
        $data = [
            'ap_purchaseorder_hds_date' => $request->ap_purchaseorder_hds_date,
            'ap_purchaseorder_hds_docuno' => $request->ap_purchaseorder_hds_docuno,
            'ap_purchaseorder_hds_number' => 0,
            'ap_purchaseorder_statuses_id' => 1,
            'ap_vendor_lists_id' => $request->ap_vendor_lists_id,
            'ap_vendor_lists_code' => $request->ap_vendor_lists_code,
            'ap_vendor_lists_name' => $request->ap_vendor_lists_name,
            'ap_vendor_lists_address' => $request->ap_vendor_lists_address,
            'ap_vendor_lists_taxid' => $request->ap_vendor_lists_taxid,
            'ap_vendor_lists_contact' => $request->ap_vendor_lists_contact,
            'ap_vendor_lists_tel' => $request->ap_vendor_lists_tel,
            'ap_vendor_lists_email' => $request->ap_vendor_lists_email,
            'ap_vendor_lists_credit' => $request->ap_vendor_lists_credit,
            'acc_typevats_id' => $request->acc_typevats_id,
            'acc_currencies_id' => $request->acc_currencies_id,
            'acc_discount_id' => $request->acc_discount_id,
            'acc_discount_qty' => 0,
            'ap_purchaseorder_hds_remark' => $request->ap_purchaseorder_hds_remark,
            'ap_purchaseorder_hds_base' => $request->ap_purchaseorder_hds_base,
            'ap_purchaseorder_hds_vat' => $request->ap_purchaseorder_hds_vat,
            'ap_purchaseorder_hds_net' => $request->ap_purchaseorder_hds_net,
            'ap_purchaseorder_hds_dis' => $request->ap_purchaseorder_hds_dis,
            'ap_purchaseorder_hds_amount' => $request->ap_purchaseorder_hds_net,
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        try{
            DB::beginTransaction();
            $insertHD = ApPurchaseorderHd::create($data);   
            foreach ($request->ap_purchaserequest_dts_id as $key => $value) {
                if (!isset($request->ap_purchaserequest_dts_id[$key])) {
                    continue; // กัน error
                }
                $pd = DB::table('vw_purchaserequest')->where('ap_purchaserequest_dts_id',$value)->first();
                if (!$pd) continue;
                ApPurchaseorderDt::insert([
                    'ap_purchaseorder_hds_id' => $insertHD->ap_purchaseorder_hds_id,
                    'ap_purchaseorder_dts_listno' => $request->ap_purchaseorder_dts_listno[$key],
                    'ap_purchaserequest_dts_id' => $value,
                    'wh_product_lists_id' => $pd->wh_product_lists_id,
                    'wh_product_lists_code' => $pd->wh_product_lists_code,
                    'wh_product_lists_name' => $pd->wh_product_lists_name,
                    'wh_product_lists_unit' => $pd->wh_product_lists_unit,
                    'acc_discount_qty' => $request->acc_discount_qty[$key],
                    'ap_purchaseorder_dts_qty' => $request->ap_purchaseorder_dts_qty[$key],
                    'ap_purchaseorder_dts_price' => $request->ap_purchaseorder_dts_price[$key],
                    'ap_purchaseorder_dts_base' => $request->ap_purchaseorder_dts_base[$key],
                    'ap_purchaseorder_dts_vat' => $request->ap_purchaseorder_dts_vat[$key],
                    'ap_purchaseorder_dts_net' => $request->ap_purchaseorder_dts_net[$key],
                    'ap_purchaseorder_dts_dis' => $request->ap_purchaseorder_dts_dis[$key],
                    'ap_purchaseorder_dts_amount' => $request->ap_purchaseorder_dts_net[$key],
                    'ap_purchaseorder_dts_duedate' => $request->ap_purchaseorder_dts_duedate[$key],
                    'ap_purchaseorder_dts_remark' => $request->ap_purchaseorder_dts_remark[$key],
                    'ap_purchaseorder_dts_flag' => true,
                    'ms_allocate_id' => $pd->ms_allocate_id,
                    'ap_purchaserequest_dts_qty' => $pd->pr_total,
                    'ap_purchaserequest_hds_docuno' => $pd->ap_purchaserequest_hds_docuno,
                    'person_at' => Auth::user()->name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }                
            DB::commit();
            return redirect()->route('purchaseorders.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $typevats = AccTypevat::whereIN('acc_typevats_id',[4,5,6])->get();
        $currencys = AccCurrency::get();
        $discounts = DB::table('acc_discount')->get();
        $requests = DB::table('vw_purchaserequest')->where('pr_total','>',0)->get();
        $vendors =  ApVendorList::where('ap_vendor_lists_flag',true)->get();
        $hd = ApPurchaseorderHd::find($id);
        $dt = ApPurchaseorderDt::where('ap_purchaseorder_hds_id',$id)->get();
        return view('purchases.form-purchaseorder-approved', compact('typevats','currencys','discounts','requests','vendors','hd','dt'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $typevats = AccTypevat::whereIN('acc_typevats_id',[4,5,6])->get();
        $currencys = AccCurrency::get();
        $discounts = DB::table('acc_discount')->get();
        $requests = DB::table('vw_purchaserequest')->where('pr_total','>',0)->get();
        $vendors =  ApVendorList::where('ap_vendor_lists_flag',true)->get();
        $hd = ApPurchaseorderHd::find($id);
        $dt = ApPurchaseorderDt::where('ap_purchaseorder_hds_id',$id)->get();
        return view('purchases.form-purchaseorder-edit', compact('typevats','currencys','discounts','requests','vendors','hd','dt'));
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
                'ap_purchaseorder_statuses_id' => 1,
                'ap_vendor_lists_id' => $request->ap_vendor_lists_id,
                'ap_vendor_lists_code' => $request->ap_vendor_lists_code,
                'ap_vendor_lists_name' => $request->ap_vendor_lists_name,
                'ap_vendor_lists_address' => $request->ap_vendor_lists_address,
                'ap_vendor_lists_taxid' => $request->ap_vendor_lists_taxid,
                'ap_vendor_lists_contact' => $request->ap_vendor_lists_contact,
                'ap_vendor_lists_tel' => $request->ap_vendor_lists_tel,
                'ap_vendor_lists_email' => $request->ap_vendor_lists_email,
                'ap_vendor_lists_credit' => $request->ap_vendor_lists_credit,
                'acc_typevats_id' => $request->acc_typevats_id,
                'acc_currencies_id' => $request->acc_currencies_id,
                'acc_discount_id' => $request->acc_discount_id,
                'ap_purchaseorder_hds_remark' => $request->ap_purchaseorder_hds_remark,
                'ap_purchaseorder_hds_base' => $request->ap_purchaseorder_hds_base,
                'ap_purchaseorder_hds_vat' => $request->ap_purchaseorder_hds_vat,
                'ap_purchaseorder_hds_net' => $request->ap_purchaseorder_hds_net,
                'ap_purchaseorder_hds_dis' => $request->ap_purchaseorder_hds_dis,
                'ap_purchaseorder_hds_amount' => $request->ap_purchaseorder_hds_net,
                'person_at' => Auth::user()->name,
                'updated_at' => Carbon::now(),
            ];
            try{
                DB::beginTransaction();
                ApPurchaseorderHd::where('ap_purchaseorder_hds_id',$id)->update($data);   
                if(!empty($request->ap_purchaseorder_dts_listno)){
                    foreach($request->ap_purchaseorder_dts_listno as $key => $value) {
                       
                        if(!empty($request->ap_purchaseorder_dts_id[$key])){
                            ApPurchaseorderDt::where('ap_purchaseorder_dts_id',$request->ap_purchaseorder_dts_id[$key])->update([
                                'acc_discount_qty' => $request->acc_discount_qty[$key],
                                'ap_purchaseorder_dts_qty' => $request->ap_purchaseorder_dts_qty[$key],
                                'ap_purchaseorder_dts_price' => $request->ap_purchaseorder_dts_price[$key],
                                'ap_purchaseorder_dts_base' => $request->ap_purchaseorder_dts_base[$key],
                                'ap_purchaseorder_dts_vat' => $request->ap_purchaseorder_dts_vat[$key],
                                'ap_purchaseorder_dts_net' => $request->ap_purchaseorder_dts_net[$key],
                                'ap_purchaseorder_dts_dis' => $request->ap_purchaseorder_dts_dis[$key],
                                'ap_purchaseorder_dts_amount' => $request->ap_purchaseorder_dts_net[$key],
                                'ap_purchaseorder_dts_duedate' => $request->ap_purchaseorder_dts_duedate[$key],
                                'ap_purchaseorder_dts_remark' => $request->ap_purchaseorder_dts_remark[$key],
                                'ap_purchaseorder_dts_flag' => true,
                                'person_at' => Auth::user()->name,
                                'updated_at' => now(),
                            ]);                                         
                        }
                        else
                        {  
                            $pd = DB::table('vw_purchaserequest')->where('ap_purchaserequest_dts_id',$request->ap_purchaserequest_dts_id[$key])->first();                             
                            if (!$pd) continue;
                            $insertHD = ApPurchaseorderHd::find($id);  
                            ApPurchaseorderDt::insert([
                                'ap_purchaseorder_hds_id' => $insertHD->ap_purchaseorder_hds_id,
                                'ap_purchaseorder_dts_listno' => $request->ap_purchaseorder_dts_listno[$key],
                                'ap_purchaserequest_dts_id' => $request->ap_purchaserequest_dts_id[$key],
                                'wh_product_lists_id' => $pd->wh_product_lists_id,
                                'wh_product_lists_code' => $pd->wh_product_lists_code,
                                'wh_product_lists_name' => $pd->wh_product_lists_name,
                                'wh_product_lists_unit' => $pd->wh_product_lists_unit,
                                'acc_discount_qty' => $request->acc_discount_qty[$key] ?? 0,
                                'ap_purchaseorder_dts_qty' => $request->ap_purchaseorder_dts_qty[$key],
                                'ap_purchaseorder_dts_price' => $request->ap_purchaseorder_dts_price[$key],
                                'ap_purchaseorder_dts_base' => $request->ap_purchaseorder_dts_base[$key],
                                'ap_purchaseorder_dts_vat' => $request->ap_purchaseorder_dts_vat[$key],
                                'ap_purchaseorder_dts_net' => $request->ap_purchaseorder_dts_net[$key],
                                'ap_purchaseorder_dts_dis' => $request->ap_purchaseorder_dts_dis[$key],
                                'ap_purchaseorder_dts_amount' => $request->ap_purchaseorder_dts_net[$key],
                                'ap_purchaseorder_dts_duedate' => $request->ap_purchaseorder_dts_duedate[$key],
                                'ap_purchaseorder_dts_remark' => $request->ap_purchaseorder_dts_remark[$key],
                                'ap_purchaseorder_dts_flag' => true,
                                'ms_allocate_id' => $pd->ms_allocate_id,
                                'ap_purchaserequest_dts_qty' => $pd->pr_total,
                                'ap_purchaserequest_hds_docuno' => $pd->ap_purchaserequest_hds_docuno,
                                'person_at' => Auth::user()->name,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }
                }                                            
                DB::commit();
                return redirect()->route('purchaseorders.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            }catch(\Exception $e){
                Log::error($e->getMessage());
                dd($e->getMessage());
                return redirect()->back()->with('error', 'เกิดข้อผิดพลาด');
            } 

        }elseif($request->checkdoc == "Approved"){
            try{
                DB::beginTransaction();
                $insertHD = ApPurchaseorderHd::where('ap_purchaseorder_hds_id',$id)
                ->update([
                    'approved_date' => Carbon::now(),
                    'approved_by' => Auth::user()->name,
                    'approved_remark' => $request->approved_remark,
                    'ap_purchaseorder_statuses_id' => 3,
                ]);                              
                DB::commit();
                return redirect()->route('purchaseorders.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $prefix = "PO-{$yy}{$mm}-";
        // หาเลขล่าสุดของเดือนนั้น
        $last = DB::table('ap_purchaseorder_hds')
            ->whereYear('ap_purchaseorder_hds_date', date('Y', strtotime($date)))
            ->whereMonth('ap_purchaseorder_hds_date', date('m', strtotime($date)))
            ->where('ap_purchaseorder_hds_docuno', 'LIKE', $prefix . '%')
            ->orderBy('ap_purchaseorder_hds_docuno', 'desc')
            ->first();
        if ($last) {
            // ตัดเลขท้าย
            $running = (int)substr($last->ap_purchaseorder_hds_docuno, -4) + 1;
        } else {
            $running = 1;
        }
        // เติม 0 หน้า เช่น 0001
        $docno = $prefix . str_pad($running, 4, '0', STR_PAD_LEFT);
        return response()->json([
            'docno' => $docno
        ]);
    }
    
    public function addressText(Request $req)
    {
        $address = $req->address_name;
        $country  = DB::table('other_countries')->where('other_countries_id', $req->country_id)->value('other_countries_name1');
        $province = DB::table('other_provinces')->where('other_provinces_id', $req->province_id)->value('other_provinces_name1');
        $district = DB::table('other_districts')->where('other_districts_id', $req->district_id)->value('other_districts_name1');
        $subdistrict = DB::table('other_sub_districts')->where('other_sub_districts_id', $req->subdistrict_id)->first(['other_sub_districts_name1', 'other_sub_districts_zipcode']);
        if($province == "กรุงเทพมหานคร"){
            $district = "เขต" . $district;
            $subdistricts = "แขวง" . $subdistrict->other_sub_districts_name1;
        }
        else{
            $district = "อำเภอ" . $district;
            $subdistricts = "ตำบล" . $subdistrict->other_sub_districts_name1;
        }
        return response()->json([
            "address" =>  $address . " " . $subdistricts . " " . $district . " " . $province . " " . $subdistrict->other_sub_districts_zipcode . " " . $country
        ]);
    }

    public function CancelPurchaseOrderDoc(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            ApPurchaseorderHd::where('ap_purchaseorder_hds_id',$id)->update([
                'ap_purchaseorder_statuses_id' => 2,
                'person_at' => Auth::user()->name,
                'updated_at'=> Carbon::now(),
            ]);
            ApPurchaseorderDt::where('ap_purchaseorder_hds_id',$id)->update([
                'ap_purchaseorder_dts_flag' => false,
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

    public function CancelPurchaseOrderList(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            ApPurchaseorderDt::where('ap_purchaseorder_dts_id',$id)->update([
                'ap_purchaseorder_dts_flag' => false,
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

    public function print($id)
    {
        $hd = ApPurchaseorderHd::findOrFail($id);
        $dt = ApPurchaseorderDt::where('ap_purchaseorder_hds_id', $id)->where('ap_purchaseorder_dts_flag',true)->get();
        $comp = AccCompany::find(1);
        return view('purchases.form-purchaseorder-print', compact('hd', 'dt','comp'));
    }
}
