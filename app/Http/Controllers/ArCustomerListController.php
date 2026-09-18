<?php

namespace App\Http\Controllers;

use App\Models\ArCustomerGroup;
use App\Models\ArCustomerList;
use App\Models\CustomerSatisfactionSurvey;
use App\Models\OtherCountry;
use App\Models\OtherDistrict;
use App\Models\OtherProvince;
use App\Models\OtherSubDistrict;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $hd = ArCustomerList::find($id);
        $list = CustomerSatisfactionSurvey::where('ar_customer_lists_id',$id)
        ->where('customer_satisfaction_surveys_flag',1)
        ->get();
        return view('customers.form-customer-show', compact('hd','list'));
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
    public function storeSurvey(Request $request)
    {
        $request->validate([
            'ar_customer_lists_id' => ['required', 'exists:ar_customer_lists,ar_customer_lists_id'],
            'ar_customer_lists_name' => ['required'],
            'ar_customer_lists_contact' => ['required'],
            'ar_customer_lists_tel' => ['required'],
            'customer_satisfaction_surveys_date' => ['required', 'date'],
        ]);

        $data = [
            'ar_customer_lists_id' => $request->ar_customer_lists_id,
            'ar_customer_lists_name' => $request->ar_customer_lists_name,
            'ar_customer_lists_contact' => $request->ar_customer_lists_contact,
            'ar_customer_lists_tel' => $request->ar_customer_lists_tel,
            'customer_satisfaction_surveys_date' => $request->customer_satisfaction_surveys_date,
            'quality_1' => $request->quality_1,
            'quality_2' => $request->quality_2,
            'quality_3' => $request->quality_3,
            'delivery_1' => $request->delivery_1,
            'delivery_2' => $request->delivery_2,
            'delivery_3' => $request->delivery_3,
            'personnel_1' => $request->personnel_1,
            'personnel_2' => $request->personnel_2,
            'personnel_3' => $request->personnel_3,
            'communication_1' => $request->communication_1,
            'communication_2' => $request->communication_2,
            'communication_3' => $request->communication_3,
            'suggestions_1' => $request->suggestions_1,
            'suggestions_2' => $request->suggestions_2,
            'customer_satisfaction_surveys_flag' => true,
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        try {
            DB::beginTransaction();
            \App\Models\CustomerSatisfactionSurvey::create($data);
            DB::commit();

            return redirect()->back()->with('success', 'บันทึกแบบประเมินความพึงพอใจเรียบร้อยแล้ว');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' . $e->getMessage());
        }
    }

    public function confirmDelCustomerSurvey(Request $request)
    {
        $id = $request->refid;
        try {
            DB::beginTransaction();
            DB::table('customer_satisfaction_surveys')
            ->where('customer_satisfaction_surveys_id',$id)
            ->update([
                'updated_at' => Carbon::now(),
                'customer_satisfaction_surveys_flag' => 0,
            ]);
            DB::commit();                      
            return response()->json([
                'status' => true,
                'message' => 'ยกเลิกเรียบร้อยแล้ว'
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
