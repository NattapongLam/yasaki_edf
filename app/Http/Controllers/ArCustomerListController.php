<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\OtherCountry;
use Illuminate\Http\Request;
use App\Models\OtherDistrict;
use App\Models\OtherProvince;
use App\Models\ArCustomerList;
use App\Models\ArCustomerGroup;
use App\Models\OtherSubDistrict;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ArCustomerListController extends Controller
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
        $hd = ArCustomerList::get();
        return view('customers.form-customer-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = ArCustomerGroup::where('ar_customer_groups_flag',true)->get();
        $countrys = OtherCountry::where('other_countries_flag',true)->get();
        $provinces = OtherProvince::where('other_provinces_flag',true)->get();
        $types = DB::table('acc_companytype')->get();
        $branchs = DB::table('acc_companybranch')->get();
        return view('customers.form-customer-create', compact('groups','countrys','provinces','types','branchs'));
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
            'ar_customer_groups_id' => ['required'],
            'acc_companytype_id' => ['required'],
            'ar_customer_lists_code' => ['required'],
            'ar_customer_lists_name1' => ['required'],
            'other_countries_id' => ['required'],
            'other_provinces_id' => ['required'],
            'other_districts_id' => ['required'],
            'other_sub_districts_id' => ['required'],
            'ar_customer_lists_address1' => ['required'],
            'ar_customer_lists_tel' => ['required'],
        ]); 
        $data = [
            'ar_customer_groups_id' => $request->ar_customer_groups_id,
            'acc_companytype_id' => $request->acc_companytype_id,
            'ar_customer_lists_code' => $request->ar_customer_lists_code,
            'ar_customer_lists_name1' => $request->ar_customer_lists_name1,
            'ar_customer_lists_name2' => $request->ar_customer_lists_name2,
            'other_countries_id' => $request->other_countries_id,
            'other_provinces_id' => $request->other_provinces_id,
            'other_districts_id' => $request->other_districts_id,
            'other_sub_districts_id' => $request->other_sub_districts_id,
            'ar_customer_lists_address1' => $request->ar_customer_lists_address1,
            'ar_customer_lists_address2' => $request->ar_customer_lists_address2,
            'acc_companybranch_id' => $request->acc_companybranch_id,
            'ar_customer_lists_branchnumber' => $request->ar_customer_lists_branchnumber,
            'ar_customer_lists_taxid' => $request->ar_customer_lists_taxid,
            'ar_customer_lists_credit' => $request->ar_customer_lists_credit,
            'ar_customer_lists_tel' => $request->ar_customer_lists_tel,
            'ar_customer_lists_email' => $request->ar_customer_lists_email,
            'ar_customer_lists_lineid' => $request->ar_customer_lists_lineid,
            'ar_customer_lists_contact' => $request->ar_customer_lists_contact,
            'ar_customer_lists_flag' => 1,
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]; 
        try{
            DB::beginTransaction();
            $insertHD = ArCustomerList::create($data);               
            DB::commit();
            return redirect()->route('customerlists.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $hd = ArCustomerList::find($id);
        $groups = ArCustomerGroup::where('ar_customer_groups_flag',true)->get();
        $countrys = OtherCountry::where('other_countries_flag',true)->get();
        $provinces = OtherProvince::where('other_provinces_flag',true)->get();
        $types = DB::table('acc_companytype')->get();
        $branchs = DB::table('acc_companybranch')->get();
        return view('customers.form-customer-edit', compact('hd','groups','countrys','provinces','types','branchs'));
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
        $flag = $request->ar_customer_lists_flag;
        if ($flag == 'on' || $flag == 'true') {
            $flag = true;
        } else {
            $flag = false;
        }
        $data = [
            'ar_customer_groups_id' => $request->ar_customer_groups_id,
            'acc_companytype_id' => $request->acc_companytype_id,
            'ar_customer_lists_name1' => $request->ar_customer_lists_name1,
            'ar_customer_lists_name2' => $request->ar_customer_lists_name2,
            'other_countries_id' => $request->other_countries_id,
            'other_provinces_id' => $request->other_provinces_id,
            'other_districts_id' => $request->other_districts_id,
            'other_sub_districts_id' => $request->other_sub_districts_id,
            'ar_customer_lists_address1' => $request->ar_customer_lists_address1,
            'ar_customer_lists_address2' => $request->ar_customer_lists_address2,
            'acc_companybranch_id' => $request->acc_companybranch_id,
            'ar_customer_lists_branchnumber' => $request->ar_customer_lists_branchnumber,
            'ar_customer_lists_taxid' => $request->ar_customer_lists_taxid,
            'ar_customer_lists_credit' => $request->ar_customer_lists_credit,
            'ar_customer_lists_tel' => $request->ar_customer_lists_tel,
            'ar_customer_lists_email' => $request->ar_customer_lists_email,
            'ar_customer_lists_lineid' => $request->ar_customer_lists_lineid,
            'ar_customer_lists_contact' => $request->ar_customer_lists_contact,
            'ar_customer_lists_flag' => $flag,
            'person_at' => Auth::user()->name,
            'updated_at' => Carbon::now(),
        ]; 
        try{
            DB::beginTransaction();
            $insertHD = ArCustomerList::where('ar_customer_lists_id',$id)->update($data);               
            DB::commit();
            return redirect()->route('customerlists.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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

    public function getDistricts($province_id)
    {
        $districts = OtherDistrict::where('other_provinces_id', $province_id)->where('other_districts_flag',true)->get();
        return response()->json($districts);
    }

    public function getSubDistricts($district_id)
    {
        $subdistricts = OtherSubDistrict::where('other_districts_id', $district_id)->where('other_sub_districts_flag',true)->get();
        return response()->json($subdistricts);
    }
}
