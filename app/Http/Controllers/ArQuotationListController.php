<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\AccTypevat;
use App\Models\AccCurrency;
use Illuminate\Http\Request;
use App\Models\ArQuotationDt;
use App\Models\ArQuotationHd;
use App\Models\WhProductList;
use App\Models\WhProductUnit;
use App\Models\ArCustomerList;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ArQuotationListController extends Controller
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
        $hd = ArQuotationHd::leftjoin('ar_quotation_statuses','ar_quotation_hds.ar_quotation_statuses_id','=','ar_quotation_statuses.ar_quotation_statuses_id')->get();
        return view('sales.form-quotation-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = ArCustomerList::get();
        $typevats = AccTypevat::whereIN('acc_typevats_id',[1,2,3])->get();
        $currencys = AccCurrency::get();
        $discounts = DB::table('acc_discount')->get();
        $products = WhProductList::whereIn('wh_product_types_id',[4,5])->get();
        return view('sales.form-quotation-create', compact('customers','typevats','currencys','discounts','products'));
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
            'ar_quotation_hds_date' => ['required'],
            'ar_quotation_hds_docuno' => ['required'],
            'acc_typevats_id' => ['required'],
            'acc_currencies_id' => ['required'],
            'ar_customer_lists_id' => ['required'],
            'acc_discount_id' => ['required'],
            'wh_product_lists_id' => ['required'],
        ]); 
        $data = [
            'ar_quotation_hds_date' => $request->ar_quotation_hds_date,
            'ar_quotation_hds_docuno' => $request->ar_quotation_hds_docuno,
            'ar_quotation_hds_number' => 0,
            'ar_quotation_statuses_id' => 1,
            'ar_customer_lists_id' => $request->ar_customer_lists_id,
            'ar_customer_lists_code' => $request->ar_customer_lists_code,
            'ar_customer_lists_name' => $request->ar_customer_lists_name,
            'ar_customer_lists_address' => $request->ar_customer_lists_address,
            'ar_customer_lists_contact' => $request->ar_customer_lists_contact,
            'ar_customer_lists_tel' => $request->ar_customer_lists_tel,            
            'ar_customer_lists_email' => $request->ar_customer_lists_email,
            'ar_customer_lists_credit' => $request->ar_customer_lists_credit,
            'acc_typevats_id' => $request->acc_typevats_id,
            'acc_currencies_id' => $request->acc_currencies_id,
            'acc_discount_id' => $request->acc_discount_id,
            'acc_discount_qty' => 0,
            'ar_quotation_hds_remark' => $request->ar_quotation_hds_remark,
            'ar_quotation_hds_base' => $request->ar_quotation_hds_base,
            'ar_quotation_hds_vat' => $request->ar_quotation_hds_vat,
            'ar_quotation_hds_net' => $request->ar_quotation_hds_net,
            'ar_quotation_hds_dis' => $request->ar_quotation_hds_dis,
            'ar_quotation_hds_amount' => $request->ar_quotation_hds_net,
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'ar_customer_lists_taxid' => $request->ar_customer_lists_taxid
        ];
        try{
            DB::beginTransaction();
            $insertHD = ArQuotationHd::create($data);   
            foreach ($request->ar_quotation_dts_listno as $key => $value) {
                if (!isset($request->wh_product_lists_id[$key])) {
                    continue; // กัน error
                }

                $pd = WhProductList::find($request->wh_product_lists_id[$key]);
                if (!$pd) continue;

                $unit = WhProductUnit::find($pd->wh_product_units_id);

                ArQuotationDt::insert([
                    'ar_quotation_hds_id' => $insertHD->ar_quotation_hds_id,
                    'ar_quotation_dts_listno' => $value,
                    'wh_product_lists_id' => $request->wh_product_lists_id[$key],
                    'wh_product_lists_code' => $pd->wh_product_lists_code,
                    'wh_product_lists_name' => $pd->wh_product_lists_name1,
                    'wh_product_lists_unit' => optional($unit)->wh_product_units_name,

                    'acc_discount_qty' => $request->acc_discount_qty[$key] ?? 0,
                    'ar_quotation_dts_qty' => $request->ar_quotation_dts_qty[$key] ?? 0,
                    'ar_quotation_dts_price' => $request->ar_quotation_dts_price[$key] ?? 0,

                    'ar_quotation_dts_base' => $request->ar_quotation_dts_base[$key] ?? 0,
                    'ar_quotation_dts_vat' => $request->ar_quotation_dts_vat[$key] ?? 0,
                    'ar_quotation_dts_net' => $request->ar_quotation_dts_net[$key] ?? 0,
                    'ar_quotation_dts_dis' => $request->ar_quotation_dts_dis[$key] ?? 0,
                    'ar_quotation_dts_amount' => $request->ar_quotation_dts_amount[$key] ?? 0,

                    'ar_quotation_dts_flag' => true,
                    'person_at' => Auth::user()->name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }            
            DB::commit();
            return redirect()->route('quotations.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $customers = ArCustomerList::get();
        $typevats = AccTypevat::whereIN('acc_typevats_id',[1,2,3])->get();
        $currencys = AccCurrency::get();
        $discounts = DB::table('acc_discount')->get();
        $products = WhProductList::whereIn('wh_product_types_id',[4,5])->get();
        $hd = ArQuotationHd::find($id);
        $dt = ArQuotationDt::where('ar_quotation_dts_flag',true)->where('ar_quotation_hds_id',$id)->get();
        return view('sales.form-quotation-edit', compact('customers','typevats','currencys','discounts','products','hd','dt'));
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
        $prefix = "QT-{$yy}{$mm}-";
        // หาเลขล่าสุดของเดือนนั้น
        $last = DB::table('ar_quotation_hds')
            ->whereYear('ar_quotation_hds_date', date('Y', strtotime($date)))
            ->whereMonth('ar_quotation_hds_date', date('m', strtotime($date)))
            ->where('ar_quotation_hds_docuno', 'LIKE', $prefix . '%')
            ->orderBy('ar_quotation_hds_docuno', 'desc')
            ->first();
        if ($last) {
            // ตัดเลขท้าย
            $running = (int)substr($last->ar_quotation_hds_docuno, -4) + 1;
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

}
