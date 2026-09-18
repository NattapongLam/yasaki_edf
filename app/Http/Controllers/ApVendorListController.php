<?php

namespace App\Http\Controllers;

use App\Models\ApVendorGroup;
use App\Models\ApVendorList;
use App\Models\OtherCountry;
use App\Models\OtherProvince;
use App\Models\SupplierEvaluation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $hd = ApVendorList::find($id);
        $list = SupplierEvaluation::where('ap_vendor_lists_id',$id)
            ->where('supplier_evaluations_flag',1)
            ->get();
        return view('vendors.form-vendor-show', compact('hd','list'));
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

    public function storeEvaluation(Request $request)
    {
        $request->validate([
            'ap_vendor_lists_id' => ['required'],
            'supplier' => ['required'],
            'evaluation_date' => ['required', 'date'],
            'goods_services' => ['required'],
            'period_evaluated' => ['required'],
            'score_1' => ['required', 'integer'],
            'score_2' => ['required', 'integer'],
            'score_3' => ['required', 'integer'],
            'score_4' => ['required', 'integer'],
            'score_5' => ['required', 'integer'],
        ]);

        $evaluationData = [
            'ap_vendor_lists_id' => $request->ap_vendor_lists_id,
            'supplier' => $request->supplier,
            'evaluation_date' => $request->evaluation_date,
            'goods_services' => $request->goods_services,
            'period_evaluated' => $request->period_evaluated,
            
            // Score 1
            'score_1' => $request->score_1,
            'score_from_1' => $request->score_from_1,
            'notes_1' => $request->notes_1,
            
            // Score 2
            'score_2' => $request->score_2,
            'score_from_2' => $request->score_from_2,
            'notes_2' => $request->notes_2,
            
            // Score 3
            'score_3' => $request->score_3,
            'score_from_3' => $request->score_from_3,
            'notes_3' => $request->notes_3,
            
            // Score 4
            'score_4' => $request->score_4,
            'score_from_4' => $request->score_from_4,
            'notes_4' => $request->notes_4,
            
            // Score 5
            'score_5' => $request->score_5,
            'score_from_5' => $request->score_from_5,
            'notes_5' => $request->notes_5,
            
            'decision' => $request->decision,
            'follow_up_date' => $request->follow_up_date,
            'supplier_evaluations_flag' => true,
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        try {
            DB::beginTransaction();
            // บันทึกข้อมูลลงตาราง supplier_evaluations (แนะนำให้สร้าง Model SupplierEvaluation มารองรับด้วย)
            DB::table('supplier_evaluations')->insert($evaluationData);
            DB::commit();

            return redirect()->back()->with('success', 'บันทึกแบบประเมินผู้ขายเรียบร้อยแล้ว');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาดในการบันทึกแบบประเมิน: ' . $e->getMessage());
        }
    }
    public function confirmDelVendorEvaluation(Request $request)
    {
        $id = $request->refid;
        try {
            DB::beginTransaction();
            DB::table('supplier_evaluations')
            ->where('supplier_evaluations_id',$id)
            ->update([
                'updated_at' => Carbon::now(),
                'supplier_evaluations_flag' => 0,
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
