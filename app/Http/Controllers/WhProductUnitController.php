<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\WhProductUnit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class WhProductUnitController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hd = WhProductUnit::get();
        return view('productsetup.form-productunit-create', compact('hd'));
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
            'wh_product_units_code' => ['required'],
            'wh_product_units_name' => ['required'],
        ]);
        $data = [
            'wh_product_units_code' => $request->wh_product_units_code,
            'wh_product_units_name' => $request->wh_product_units_name,
            'wh_product_units_flag' => 1,
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now(), 
        ];
        try{
            DB::beginTransaction();
            $insertHD = WhProductUnit::create($data);               
            DB::commit();
            return redirect()->route('productunits.create')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $hd = WhProductUnit::find($id);
        return view('productsetup.form-productunit-edit', compact('hd'));
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
        $flag = $request->wh_product_units_flag;
        if($flag == true){
            $flag = 1;
        }else{
            $flag = 0;
        }
        $data = [
            'wh_product_units_code' => $request->wh_product_units_code,
            'wh_product_units_name' => $request->wh_product_units_name,
            'wh_product_units_flag' => $flag,
            'person_at' => Auth::user()->name,
            'updated_at' => Carbon::now(), 
        ];
        try{
            DB::beginTransaction();
            $insertHD = WhProductUnit::create($data);               
            DB::commit();
            return redirect()->route('productunits.create')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
}
