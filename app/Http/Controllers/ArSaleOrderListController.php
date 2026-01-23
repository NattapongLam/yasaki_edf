<?php

namespace App\Http\Controllers;

use App\Models\AccTypevat;
use App\Models\AccCurrency;
use Illuminate\Http\Request;
use App\Models\ArQuotationHd;
use App\Models\ArSaleorderHd;
use Illuminate\Support\Facades\DB;

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
}
