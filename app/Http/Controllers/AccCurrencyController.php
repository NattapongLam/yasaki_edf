<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\AccCurrency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AccCurrencyController extends Controller
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
        $hd = AccCurrency::get();
        return view('accounts.form-currency-create', compact('hd'));
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
            'acc_currencies_code' => ['required'],
            'acc_currencies_name' => ['required'],
            'acc_currencies_rate' => ['required'],
        ]);
        $data = [
            'acc_currencies_code' => $request->acc_currencies_code,
            'acc_currencies_name' => $request->acc_currencies_name,
            'acc_currencies_rate' => $request->acc_currencies_rate,
            'acc_currencies_flag' => 1,
            'person_at' =>  Auth::user()->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),   
        ];
        try{
            DB::beginTransaction();
            $insertHD = AccCurrency::create($data);               
            DB::commit();
            return redirect()->route('currencys.create')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $hd = AccCurrency::find($id);
        return view('accounts.form-currency-edit', compact('hd'));
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
        $request->validate([
            'acc_currencies_code' => ['required'],
            'acc_currencies_name' => ['required'],
            'acc_currencies_rate' => ['required'],
        ]);
        $flag = $request->acc_currencies_flag;
        if($flag == true){
            $flag = 1;
        }else{
            $flag = 0;
        }
        $data = [
            'acc_currencies_code' => $request->acc_currencies_code,
            'acc_currencies_name' => $request->acc_currencies_name,
            'acc_currencies_rate' => $request->acc_currencies_rate,
            'acc_currencies_flag' => $flag,
            'person_at' =>  Auth::user()->name,
            'updated_at' => Carbon::now(),   
        ];
        try{
            DB::beginTransaction();
            $insertHD = AccCurrency::where('acc_currencies_id',$id)->update($data);               
            DB::commit();
            return redirect()->route('currencys.create')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
