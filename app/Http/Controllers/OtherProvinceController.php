<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\OtherCountry;
use Illuminate\Http\Request;
use App\Models\OtherProvince;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class OtherProvinceController extends Controller
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
        $hd = OtherProvince::get();
        $country = OtherCountry::where('other_countries_flag',true)->get();
        return view('others.form-province-create', compact('hd','country'));
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
            'other_provinces_name1' => [
                'required',
                'unique:other_provinces,other_provinces_name1',
            ],
            'other_countries_id' => ['required'],
        ]);
        $data = [
            'other_countries_id' => $request->other_countries_id,
            'other_provinces_name1' => $request->other_provinces_name1,
            'other_provinces_name2' => $request->other_provinces_name2,
            'other_provinces_flag' => 1,
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        try{
            DB::beginTransaction();
            $insertHD = OtherProvince::create($data);               
            DB::commit();
            return redirect()->route('provinces.create')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $hd = OtherProvince::find($id);
        $country = OtherCountry::where('other_countries_flag',true)->get();
        return view('others.form-province-edit', compact('hd','country'));
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
            'other_provinces_name1' => ['required'],
            'other_countries_id' => ['required'],
        ]);
        $flag = $request->other_countries_flag;
        if($flag == true){
            $flag = 1;
        }else{
            $flag = 0;
        }
        $data = [
            'other_countries_id' => $request->other_countries_id,
            'other_provinces_name1' => $request->other_provinces_name1,
            'other_provinces_name2' => $request->other_provinces_name2,
            'other_provinces_flag' => $flag,
            'person_at' => Auth::user()->name,
            'updated_at' => Carbon::now(),
        ];
        try{
            DB::beginTransaction();
            $insertHD = OtherProvince::where('other_provinces_id',$id)->update($data);               
            DB::commit();
            return redirect()->route('provinces.create')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
