<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ApVendorList;
use App\Models\OtherCountry;
use Illuminate\Http\Request;
use App\Models\ApVendorGroup;
use App\Models\OtherProvince;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ApVendorListController extends Controller
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
        $hd = ApVendorList::get();
        return view('vendors.form-vendor-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = ApVendorGroup::where('ap_vendor_groups_flag',true)->get();
        $countrys = OtherCountry::where('other_countries_flag',true)->get();
        $provinces = OtherProvince::where('other_provinces_flag',true)->get();
        $types = DB::table('acc_companytype')->get();
        $branchs = DB::table('acc_companybranch')->get();
        return view('vendors.form-vendor-create', compact('groups','countrys','provinces','types','branchs'));
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
            'ap_vendor_groups_id' => ['required'],
            'acc_companytype_id' => ['required'],
            'ap_vendor_lists_code' => ['required'],
            'ap_vendor_lists_name1' => ['required'],
            'other_countries_id' => ['required'],
            'other_provinces_id' => ['required'],
            'other_districts_id' => ['required'],
            'other_sub_districts_id' => ['required'],
            'ap_vendor_lists_address1' => ['required'],
            'ap_vendor_lists_tel' => ['required'],
        ]); 
        $data = [
            'ap_vendor_groups_id' => $request->ap_vendor_groups_id,
            'acc_companytype_id' => $request->acc_companytype_id,
            'ap_vendor_lists_code' => $request->ap_vendor_lists_code,
            'ap_vendor_lists_name1' => $request->ap_vendor_lists_name1,
            'ap_vendor_lists_name2' => $request->ap_vendor_lists_name2,
            'other_countries_id' => $request->other_countries_id,
            'other_provinces_id' => $request->other_provinces_id,
            'other_districts_id' => $request->other_districts_id,
            'other_sub_districts_id' => $request->other_sub_districts_id,
            'ap_vendor_lists_address1' => $request->ap_vendor_lists_address1,
            'ap_vendor_lists_bankname' => $request->ap_vendor_lists_bankname,
            'ap_vendor_lists_banknumber' => $request->ap_vendor_lists_banknumber,
            'acc_companybranch_id' => $request->acc_companybranch_id,
            'ap_vendor_lists_branchnumber' => $request->ap_vendor_lists_branchnumber,
            'ap_vendor_lists_taxid' => $request->ap_vendor_lists_taxid,
            'ap_vendor_lists_credit' => $request->ap_vendor_lists_credit,
            'ap_vendor_lists_tel' => $request->ap_vendor_lists_tel,
            'ap_vendor_lists_email' => $request->ap_vendor_lists_email,
            'ap_vendor_lists_lineid' => $request->ap_vendor_lists_lineid,
            'ap_vendor_lists_contact' => $request->ap_vendor_lists_contact,
            'ap_vendor_lists_flag' => 1,
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]; 
        try{
            DB::beginTransaction();
            $insertHD = ApVendorList::create($data);               
            DB::commit();
            return redirect()->route('vendorlists.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $hd = ApVendorList::find($id);
        $groups = ApVendorGroup::where('ap_vendor_groups_flag',true)->get();
        $countrys = OtherCountry::where('other_countries_flag',true)->get();
        $provinces = OtherProvince::where('other_provinces_flag',true)->get();
        $types = DB::table('acc_companytype')->get();
        $branchs = DB::table('acc_companybranch')->get();
        return view('vendors.form-vendor-edit', compact('hd','groups','countrys','provinces','types','branchs'));
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
            'ap_vendor_groups_id' => ['required'],
            'acc_companytype_id' => ['required'],
            'ap_vendor_lists_code' => ['required'],
            'ap_vendor_lists_name1' => ['required'],
            'other_countries_id' => ['required'],
            'other_provinces_id' => ['required'],
            'other_districts_id' => ['required'],
            'other_sub_districts_id' => ['required'],
            'ap_vendor_lists_address1' => ['required'],
            'ap_vendor_lists_tel' => ['required'],
        ]); 
        $data = [
            'ap_vendor_groups_id' => $request->ap_vendor_groups_id,
            'acc_companytype_id' => $request->acc_companytype_id,
            'ap_vendor_lists_name1' => $request->ap_vendor_lists_name1,
            'ap_vendor_lists_name2' => $request->ap_vendor_lists_name2,
            'other_countries_id' => $request->other_countries_id,
            'other_provinces_id' => $request->other_provinces_id,
            'other_districts_id' => $request->other_districts_id,
            'other_sub_districts_id' => $request->other_sub_districts_id,
            'ap_vendor_lists_address1' => $request->ap_vendor_lists_address1,
            'ap_vendor_lists_bankname' => $request->ap_vendor_lists_bankname,
            'ap_vendor_lists_banknumber' => $request->ap_vendor_lists_banknumber,
            'acc_companybranch_id' => $request->acc_companybranch_id,
            'ap_vendor_lists_branchnumber' => $request->ap_vendor_lists_branchnumber,
            'ap_vendor_lists_taxid' => $request->ap_vendor_lists_taxid,
            'ap_vendor_lists_credit' => $request->ap_vendor_lists_credit,
            'ap_vendor_lists_tel' => $request->ap_vendor_lists_tel,
            'ap_vendor_lists_email' => $request->ap_vendor_lists_email,
            'ap_vendor_lists_lineid' => $request->ap_vendor_lists_lineid,
            'ap_vendor_lists_contact' => $request->ap_vendor_lists_contact,
            'ap_vendor_lists_flag' => 1,
            'person_at' => Auth::user()->name,
            'updated_at' => Carbon::now(),
        ]; 
        try{
            DB::beginTransaction();
            $insertHD = ApVendorList::where('ap_vendor_lists_id',$id)->update($data);               
            DB::commit();
            return redirect()->route('vendorlists.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
