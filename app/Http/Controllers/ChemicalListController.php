<?php

namespace App\Http\Controllers;

use App\Models\ChemicalFuntion;
use App\Models\ChemicalGroup;
use App\Models\ChemicalList;
use App\Models\ChemicalSub;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ChemicalListController extends Controller
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
        $hd = ChemicalList::leftjoin('chemical_groups','chemical_lists.chemical_groups_id','=','chemical_groups.chemical_groups_id')
        ->leftjoin('chemical_funtions','chemical_lists.chemical_funtions_id','=','chemical_funtions.chemical_funtions_id')
        ->select('chemical_lists.*','chemical_groups.chemical_groups_name','chemical_funtions.chemical_funtions_name')
        ->get();
        return view('chemicalsetup.form-chemical-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = ChemicalGroup::where('chemical_groups_flag',true)->get();
        return view('chemicalsetup.form-chemical-create', compact('groups'));
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
            'chemical_lists_name' => ['required'],
            'chemical_lists_density' => ['required'],
            'chemical_lists_tempstart' => ['required'],
            'chemical_lists_tempend' => ['required'],
            'chemical_groups_id' => ['required'],
            'chemical_funtions_id' => ['required'],
        ]);                
        
        $data = [
            'chemical_groups_id' => $request->chemical_groups_id,
            'chemical_funtions_id' => $request->chemical_funtions_id,
            'chemical_lists_name' => $request->chemical_lists_name,
            'chemical_lists_grade' => $request->chemical_lists_grade,
            'chemical_lists_density' => $request->chemical_lists_density,
            'chemical_lists_remark' => $request->chemical_lists_remark,
            'chemical_lists_detail' => $request->chemical_lists_detail,
            'chemical_lists_tempstart' => $request->chemical_lists_tempstart,
            'chemical_lists_tempend' => $request->chemical_lists_tempend,
            'chemical_lists_substitute' => $request->chemical_lists_substitute,
            'chemical_lists_academic' => $request->chemical_lists_academic,
            'chemical_lists_file3' => $request->chemical_lists_file3,
            'chemical_lists_file4' => $request->chemical_lists_file4,
            'chemical_lists_refcode' => $request->chemical_lists_refcode,
            'chemical_lists_flag' => 1,
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'chemical_funtions_id_1' => $request->chemical_funtions_id_1,
            'chemical_lists_department' => $request->chemical_lists_department,
            'chemical_lists_substance' => $request->chemical_lists_substance,
            'chemical_lists_vendor' => $request->chemical_lists_vendor,
        ];

        // File 1 Upload
        if ($request->hasFile('chemical_lists_file1')) { 
            $data['chemical_lists_file1'] = $request->file('chemical_lists_file1')->storeAs(
                'images/Chemical_File', 
                "IMG_" . Carbon::now()->format('YmdHis') . "_" . Str::random(5) . "." . $request->file('chemical_lists_file1')->extension()
            ); 
        } 
        
        // File 2 Upload
        if ($request->hasFile('chemical_lists_file2')) { 
            $data['chemical_lists_file2'] = $request->file('chemical_lists_file2')->storeAs(
                'images/Chemical_File', 
                "IMG_" . Carbon::now()->format('YmdHis') . "_" . Str::random(5) . "." . $request->file('chemical_lists_file2')->extension()
            );
        }

        try {
            DB::beginTransaction();

            // 1. Insert parent and get the generated ID
            $chemicalListId = DB::table('chemical_lists')->insertGetId($data); 

            // 2. Loop and insert sub-chemical items (if they exist)
            if ($request->has('chemical_subs_listno') && is_array($request->chemical_subs_listno)) {
                foreach ($request->chemical_subs_listno as $key => $value) {
                    DB::table('chemical_subs')->insert([
                        'calibration_lists_id'  => $chemicalListId, // Link to the newly created parent ID
                        'chemical_subs_listno'  => $value,
                        'chemical_subs_name'    => $request->chemical_subs_name[$key] ?? null,
                        'chemical_subs_casno'   => $request->chemical_subs_casno[$key] ?? null,
                        'chemical_subs_ecno'    => $request->chemical_subs_ecno[$key] ?? null,
                        'chemical_subs_qty'     => $request->chemical_subs_qty[$key] ?? null,
                        'chemical_subs_flag'    => 1,
                        'created_at'            => Carbon::now(),
                        'updated_at'            => Carbon::now(),
                    ]);
                }
            }
                        
            DB::commit();
            return redirect()->route('chemicallists.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');

        } catch (\Exception $e) {
            DB::rollBack(); // CRITICAL: Rollback changes if something fails!
            Log::error($e->getMessage());
            
            // dd($e->getMessage()); // Keep for debugging; remove in production
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
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
        $groups = ChemicalGroup::where('chemical_groups_flag',true)->get();
        $hd = ChemicalList::find($id);
        $funtions = ChemicalFuntion::where('chemical_groups_id',$hd->chemical_groups_id)->where('chemical_funtions_flag',true)->get();
        $dt = ChemicalSub::where('calibration_lists_id',$id)->where('chemical_subs_flag',true)->get();
        return view('chemicalsetup.form-chemical-edit', compact('groups','hd','funtions','dt'));
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
            'chemical_lists_name' => ['required'], 
            'chemical_lists_density' => ['required'], 
            'chemical_lists_tempstart' => ['required'], 
            'chemical_lists_tempend' => ['required'], 
            'chemical_groups_id' => ['required'], 
            'chemical_funtions_id' => ['required'], 
        ]); 

        $data = [ 
            'chemical_groups_id' => $request->chemical_groups_id, 
            'chemical_funtions_id' => $request->chemical_funtions_id, 
            'chemical_lists_name' => $request->chemical_lists_name, 
            'chemical_lists_grade' => $request->chemical_lists_grade, 
            'chemical_lists_density' => $request->chemical_lists_density, 
            'chemical_lists_remark' => $request->chemical_lists_remark, 
            'chemical_lists_detail' => $request->chemical_lists_detail, 
            'chemical_lists_tempstart' => $request->chemical_lists_tempstart, 
            'chemical_lists_tempend' => $request->chemical_lists_tempend, 
            'chemical_lists_substitute' => $request->chemical_lists_substitute, 
            'chemical_lists_academic' => $request->chemical_lists_academic, 
            'chemical_lists_file3' => $request->chemical_lists_file3, 
            'chemical_lists_file4' => $request->chemical_lists_file4, 
            'chemical_lists_refcode' => $request->chemical_lists_refcode, 
            'chemical_lists_flag' => 1, 
            'person_at' => Auth::user()->name, 
            'updated_at' => Carbon::now(),
            'chemical_funtions_id_1' => $request->chemical_funtions_id_1,
            // เพิ่มฟิลด์ใหม่ 3 ตัวที่ปรากฏในฟอร์มแก้ไข
            'chemical_lists_department' => $request->chemical_lists_department,
            'chemical_lists_substance' => $request->chemical_lists_substance,
            'chemical_lists_vendor' => $request->chemical_lists_vendor,
        ]; 

        // การจัดการไฟล์แนบ 1 (หากมีการอัปโหลดใหม่เข้ามา)
        if ($request->hasFile('chemical_lists_file1')) { 
            $data['chemical_lists_file1'] = $request->file('chemical_lists_file1')->storeAs(
                'images/Chemical_File', 
                "IMG_" . Carbon::now()->format('YmdHis') . "_" . Str::random(5) . "." . $request->file('chemical_lists_file1')->extension()
            ); 
        } 

        // การจัดการไฟล์แนบ 2 (หากมีการอัปโหลดใหม่เข้ามา)
        if ($request->hasFile('chemical_lists_file2')) { 
            $data['chemical_lists_file2'] = $request->file('chemical_lists_file2')->storeAs(
                'images/Chemical_File', 
                "IMG_" . Carbon::now()->format('YmdHis') . "_" . Str::random(5) . "." . $request->file('chemical_lists_file2')->extension()
            );
        }

        try { 
            DB::beginTransaction(); 

            // 1. อัปเดตข้อมูลตารางหลัก (Parent)
            DB::table('chemical_lists')->where('chemical_lists_id', $id)->update($data); 

            // 2. ลบรายการสารย่อยเก่าออกทั้งหมด เพื่อเตรียมบันทึกชุดปัจจุบันที่ส่งมาจากหน้าฟอร์ม
            DB::table('chemical_subs')->where('calibration_lists_id', $id)->delete();

            // 3. วนลูปบันทึกรายการสารย่อยชุดใหม่ (ถ้าหน้าจอมีข้อมูลส่งมา)
            if ($request->has('chemical_subs_listno') && is_array($request->chemical_subs_listno)) {
                foreach ($request->chemical_subs_listno as $key => $value) {
                    // ข้ามการบันทึกหากไม่มีชื่อสาร
                    if (empty($request->chemical_subs_name[$key])) {
                        continue;
                    }

                    DB::table('chemical_subs')->insert([
                        'calibration_lists_id'  => $id, // ID ตารางหลักที่ทำการอัปเดต
                        'chemical_subs_listno'  => $value,
                        'chemical_subs_name'    => $request->chemical_subs_name[$key] ?? null,
                        'chemical_subs_casno'   => $request->chemical_subs_casno[$key] ?? null,
                        'chemical_subs_ecno'    => $request->chemical_subs_ecno[$key] ?? null,
                        'chemical_subs_qty'     => $request->chemical_subs_qty[$key] ?? null,
                        'chemical_subs_flag'    => 1,
                        'created_at'            => Carbon::now(),
                        'updated_at'            => Carbon::now(),
                    ]);
                }
            }

            DB::commit(); 
            return redirect()->route('chemicallists.index')->with('success', 'บันทึกการแก้ไขข้อมูลเรียบร้อย'); 

        } catch (\Exception $e) { 
            DB::rollBack(); // ย้อนกลับคำสั่งทั้งหมดหากเกิด Error กลางคัน
            Log::error($e->getMessage()); 
            
            // dd($e->getMessage()); // เปิดไว้ตรวจสอบกรณีเจอบั๊กในขั้นตอนพัฒนา
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage()); 
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

    public function confirmDelChemical(Request $request)
    {
        $id = $request->refid;
        try {
            DB::beginTransaction();
            ChemicalList::where('chemical_lists_id', $id)
            ->update([
                'updated_at' => Carbon::now(),
                'chemical_lists_flag' => 0,
                'person_at' => Auth::user()->name,
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
    public function getFunctions($group_id)
    {
        $functions = ChemicalFuntion::where('chemical_groups_id', $group_id)->get();
        return response()->json($functions);
    }
}
