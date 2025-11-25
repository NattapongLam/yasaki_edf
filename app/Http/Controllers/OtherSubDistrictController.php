<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\OtherDistrict;
use App\Models\OtherSubDistrict;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class OtherSubDistrictController extends Controller
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
        $hd = OtherSubDistrict::get();
        $district = OtherDistrict::where('other_districts_flag',true)->get();
        return view('others.form-subdistrict-create', compact('hd','district'));
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
            'other_sub_districts_name1' => [
                'required',
                'unique:other_sub_districts,other_sub_districts_name1',
            ],
            'other_districts_id' => ['required'],
        ]);
        $data = [
            'other_districts_id' => $request->other_districts_id,
            'other_sub_districts_name1' => $request->other_sub_districts_name1,
            'other_sub_districts_name2' => $request->other_sub_districts_name2,
            'other_sub_districts_zipcode' => $request->other_sub_districts_zipcode,
            'other_sub_districts_flag' => 1,
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        try{
            DB::beginTransaction();
            $insertHD = OtherSubDistrict::create($data);               
            DB::commit();
            return redirect()->route('sub-districts.create')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $hd = OtherSubDistrict::find($id);
        $district = OtherDistrict::where('other_districts_flag',true)->get();
        return view('others.form-subdistrict-edit', compact('hd','district'));
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
            'other_sub_districts_name1' => ['required'],
            'other_districts_id' => ['required'],
        ]);
        $flag = $request->other_sub_districts_flag;
        if($flag == true){
            $flag = 1;
        }else{
            $flag = 0;
        }
        $data = [
            'other_districts_id' => $request->other_districts_id,
            'other_sub_districts_name1' => $request->other_sub_districts_name1,
            'other_sub_districts_name2' => $request->other_sub_districts_name2,
            'other_sub_districts_zipcode' => $request->other_sub_districts_zipcode,
            'other_sub_districts_flag' => $flag,
            'person_at' => Auth::user()->name,
            'updated_at' => Carbon::now(),
        ];
        try{
            DB::beginTransaction();
            $insertHD = OtherSubDistrict::where('other_sub_districts_id',$id)->update($data);               
            DB::commit();
            return redirect()->route('sub-districts.create')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
