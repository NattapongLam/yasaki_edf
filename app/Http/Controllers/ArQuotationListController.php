<?php

namespace App\Http\Controllers;

use App\Models\AccTypevat;
use App\Models\AccCurrency;
use Illuminate\Http\Request;
use App\Models\ArQuotationHd;
use App\Models\ArCustomerList;
use Illuminate\Support\Facades\DB;

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
        return view('sales.form-quotation-create', compact('customers','typevats','currencys','discounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
