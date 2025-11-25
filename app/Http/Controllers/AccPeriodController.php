<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\AccPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AccPeriodController extends Controller
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
        $hd = AccPeriod::get();
        return view('accounts.form-period-create', compact('hd'));
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
            'acc_companies_year' => ['required'],
            'acc_companies_date1' => ['required'],
            'acc_companies_date2' => ['required'],
        ]);
        $data = [
            'acc_companies_year' => $request->acc_companies_year,
            'acc_companies_date1' => $request->acc_companies_date1,
            'acc_companies_date2' => $request->acc_companies_date2,
            'acc_companies_flag' => 1,
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(), 
            'updated_at' > Carbon::now(), 
        ];
        try{
            DB::beginTransaction();
            $insertHD = AccPeriod::create($data);               
            DB::commit();
            return redirect()->route('periods.create')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $hd = AccPeriod::find($id);
        return view('accounts.form-period-edit', compact('hd'));
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
            'acc_companies_year' => ['required'],
            'acc_companies_date1' => ['required'],
            'acc_companies_date2' => ['required'],
        ]);
        $flag = $request->acc_companies_flag;
        if($flag == true){
            $flag = 1;
        }else{
            $flag = 0;
        }
        $data = [
            'acc_companies_year' => $request->acc_companies_year,
            'acc_companies_date1' => $request->acc_companies_date1,
            'acc_companies_date2' => $request->acc_companies_date2,
            'acc_companies_flag' => $flag,
            'person_at' => Auth::user()->name,
            'updated_at' > Carbon::now(), 
        ];
        try{
            DB::beginTransaction();
            $insertHD = AccPeriod::where('acc_periods_id',$id)->update($data);               
            DB::commit();
            return redirect()->route('periods.create')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
