<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportStockController extends Controller
{
    public function ReportStock(Request $request)
    {
        $hd1 = DB::table('vw_stockcard')->where('wh_warehouses_id',1)->get();
        $hd2 = DB::table('vw_stockcard')->where('wh_warehouses_id',2)->get();
        $hd3 = DB::table('vw_stockcard')->where('wh_warehouses_id',3)->get();
        $hd4 = DB::table('vw_stockcard')->where('wh_warehouses_id',4)->get();
        $hd5 = DB::table('vw_stockcard')->where('wh_warehouses_id',5)->get();
        return view('report.report-stockall', compact('hd1','hd2','hd3','hd4','hd5'));
    }
}
