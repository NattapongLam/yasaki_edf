<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\OtherDistrict;
use App\Models\OtherProvince;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class OtherDistrictController extends Controller
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
        $hd = OtherDistrict::get();
        $province = OtherProvince::where('other_provinces_flag',true)->get();
        return view('others.form-district-create', compact('hd','province'));
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
            'other_districts_name1' => [
                'required',
                'unique:other_districts,other_districts_name1',
            ],
            'other_provinces_id' => ['required'],
        ]);
        $data = [
            'other_provinces_id' => $request->other_provinces_id,
            'other_districts_name1' => $request->other_districts_name1,
            'other_districts_name2' => $request->other_districts_name2,
            'other_districts_flag' => 1,
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        try{
            DB::beginTransaction();
            $insertHD = OtherDistrict::create($data);               
            DB::commit();
            return redirect()->route('districts.create')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $hd = OtherDistrict::find($id);
        $province = OtherProvince::where('other_provinces_flag',true)->get();
        return view('others.form-district-edit', compact('hd','province'));
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
            'other_districts_name1' => ['required'],
            'other_provinces_id' => ['required'],
        ]);
        $flag = $request->other_districts_flag;
        if($flag == true){
            $flag = 1;
        }else{
            $flag = 0;
        }
        $data = [
            'other_provinces_id' => $request->other_provinces_id,
            'other_districts_name1' => $request->other_districts_name1,
            'other_districts_name2' => $request->other_districts_name2,
            'other_districts_flag' => $flag,
            'person_at' => Auth::user()->name,
            'updated_at' => Carbon::now(),
        ];
        try{
            DB::beginTransaction();
            $insertHD = OtherDistrict::where('other_districts_id',$id)->update($data);               
            DB::commit();
            return redirect()->route('districts.create')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
