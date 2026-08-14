<?php

namespace App\Http\Controllers;

use App\Models\DocRiskDt;
use App\Models\DocRiskHd;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RiskController extends Controller
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
        $hd = DocRiskHd::where('doc_risk_hds_flag',true)->get();
        return view('dcc.form-risk-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hd = null;
        return view('dcc.form-risk-create', compact('hd'));
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
            'doc_risk_hds_type' => ['required'],
            'doc_risk_hds_agency' => ['required'],
            'doc_risk_hds_person' => ['required'],
            'doc_risk_hds_date' => ['required'],
        ]);

        try {
            DB::beginTransaction();

            // 1. บันทึกข้อมูลส่วนหัว (Header)
            $insertHD = DocRiskHd::create([
                'doc_risk_hds_type' => $request->doc_risk_hds_type,
                'doc_risk_hds_agency' => $request->doc_risk_hds_agency,
                'doc_risk_hds_person' => $request->doc_risk_hds_person,
                'doc_risk_hds_date' => $request->doc_risk_hds_date,
                'prepared_by' => $request->prepared_by,
                'prepared_date' => $request->prepared_date,
                'approved_by' => $request->approved_by, // เพิ่มเติมถ้ามีฟิลด์นี้ในตาราง
                'approved_date' => $request->approved_date, // เพิ่มเติมถ้ามีฟิลด์นี้ในตาราง
                'doc_risk_hds_flag' => true,
                'person_at' => Auth::user()->name,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]); 

            // 2. วนลูปบันทึกข้อมูลตารางรายละเอียด (Details)
            if ($request->has('doc_risk_dts_issue')) {
                foreach ($request->doc_risk_dts_issue as $key => $value) {
                    // สมมติว่า Model รายละเอียดคือ DocRiskDt (ปรับชื่อ Model ตามโปรเจกต์ของคุณ)
                    DocRiskDt::create([
                        'doc_risk_hds_id' => $insertHD->doc_risk_hds_id, // Foreign Key เชื่อมกับตาราง Header
                        'doc_risk_dts_issue' => $request->doc_risk_dts_issue[$key] ?? '-',
                        'doc_risk_dts_effect' => $request->doc_risk_dts_effect[$key] ?? '-',
                        'doc_risk_dts_control' => $request->doc_risk_dts_control[$key] ?? '-',
                        'doc_risk_dts_likelihood' => $request->doc_risk_dts_likelihood[$key] ?? 0,
                        'doc_risk_dts_impact' => $request->doc_risk_dts_impact[$key] ?? 0,
                        'doc_risk_dts_score' => $request->doc_risk_dts_score[$key] ?? 0,
                        'doc_risk_dts_violence' => $request->doc_risk_dts_violence[$key] ?? '-',
                        'doc_risk_dts_chance' => $request->doc_risk_dts_chance[$key] ?? '-',
                        'doc_risk_dts_period' => $request->doc_risk_dts_period[$key],
                        'doc_risk_dts_responsible' => $request->doc_risk_dts_responsible[$key] ?? '-',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'doc_risk_dts_flag' => true,
                        'person_at' => Auth::user()->name,
                    ]);
                }
            }           

            DB::commit();
            return redirect()->route('risk.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            // ปิด dd($e->getMessage()); ไว้ก่อนเมื่อใช้งานจริง เพื่อให้ redirect กลับไปแสดงข้อความ error ได้ถูกต้อง
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
        $hd = DocRiskHd::find($id);
        $dt = DocRiskDt::where('doc_risk_dts_flag',true)->where('doc_risk_hds_id',$id)->get();
        return view('dcc.form-risk-show', compact('hd','dt'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hd = DocRiskHd::find($id);
        $dt = DocRiskDt::where('doc_risk_dts_flag',true)->where('doc_risk_hds_id',$id)->get();
        return view('dcc.form-risk-edit', compact('hd','dt'));
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
        if($request->checkref == "Edit"){
            // 1. ตรวจสอบข้อมูลเบื้องต้น (Validation) ตามความเหมาะสม
            $request->validate([
                'doc_risk_hds_type' => 'required',
                'doc_risk_hds_agency' => 'required',
                'doc_risk_hds_person' => 'required',
                'doc_risk_hds_date' => 'required|date',
            ]);

            // ใช้ Database Transaction เพื่อความปลอดภัย (ถ้าอันใดอันหนึ่งพัง จะ Rollback ทั้งหมด)
            DB::beginTransaction();

            try {
                // 2. ค้นหาและอัปเดตข้อมูลส่วนหัว (Head)
                $hd = DocRiskHd::findOrFail($id);
                
                // อัปเดตฟิลด์ของ Head ทั้งหมดที่ส่งมาจากฟอร์มยกเว้น Token, Method และข้อมูลของ Details
                $hd->update([
                    'doc_risk_hds_type'    => $request->doc_risk_hds_type,
                    'doc_risk_hds_agency'  => $request->doc_risk_hds_agency,
                    'doc_risk_hds_person'  => $request->doc_risk_hds_person,
                    'doc_risk_hds_date'    => $request->doc_risk_hds_date,
                    'prepared_date'        => $request->prepared_date,
                    // หากมีฟิลด์อื่นๆ ของ Head เพิ่มเติม สามารถใส่ตรงนี้ได้เลย
                ]);

                // 3. จัดการข้อมูลตารางรายละเอียด (Details)
                // วิธีที่นิยมและง่ายที่สุดสำหรับการอัปเดตรายการที่เป็นตาราง คือ "ลบของเก่าทิ้งทั้งหมด แล้ว Insert ใหม่ด้วยค่าปัจจุบัน"
                // (สมมติว่าความสัมพันธ์ใน Model Head คือ public function details() { return $this->hasMany(RiskDetail::class, 'doc_risk_hds_id'); })
                
                $hd->details()->delete(); // ลบรายการรายละเอียดเก่าของเอกสารนี้ทิ้ง

                // ตรวจสอบว่ามีข้อมูลส่งมาในตารางไหม
                if ($request->has('doc_risk_dts_issue') && is_array($request->doc_risk_dts_issue)) {
                    foreach ($request->doc_risk_dts_issue as $index => $issue) {
                        // เช็คว่าช่องประเด็นความเสี่ยงไม่ว่างเปล่า ถึงจะบันทึก
                        if (!empty(trim($issue))) {
                            $hd->details()->create([
                                // 'doc_risk_hds_id' => $hd->doc_risk_hds_id, // (ถ้าใช้ hasMany ตรงนี้ Laravel จะผูกให้อัตโนมัติ)
                                'doc_risk_dts_issue'       => $issue,
                                'doc_risk_dts_effect'      => $request->doc_risk_dts_effect[$index] ?? null,
                                'doc_risk_dts_control'     => $request->doc_risk_dts_control[$index] ?? null,
                                'doc_risk_dts_likelihood'  => $request->doc_risk_dts_likelihood[$index] ?? null,
                                'doc_risk_dts_impact'      => $request->doc_risk_dts_impact[$index] ?? null,
                                'doc_risk_dts_score'       => $request->doc_risk_dts_score[$index] ?? null,
                                'doc_risk_dts_violence'    => $request->doc_risk_dts_violence[$index] ?? null,
                                'doc_risk_dts_chance'      => $request->doc_risk_dts_chance[$index] ?? null,
                                'doc_risk_dts_period'      => $request->doc_risk_dts_period[$index] ?? null,
                                'doc_risk_dts_responsible' => $request->doc_risk_dts_responsible[$index] ?? null,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                                'doc_risk_dts_flag' => true,
                                'person_at' => Auth::user()->name,
                            ]);
                        }
                    }
                }

                DB::commit();

                return redirect()->route('risk.index')->with('success', 'บันทึกข้อมูลการประเมินความเสี่ยงสำเร็จเรียบร้อยแล้ว');

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' . $e->getMessage())->withInput();
            }
        }elseif($request->checkref == "Review"){
            DB::beginTransaction();
            try {
                $hd = DocRiskHd::findOrFail($id);
                $hd->update([
                    'approved_by'    => Auth::user()->name,
                    'approved_dat'  => $request->approved_dat,
                ]);
                DB::commit();
                return redirect()->route('risk.index')->with('success', 'บันทึกข้อมูลการประเมินความเสี่ยงสำเร็จเรียบร้อยแล้ว');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' . $e->getMessage())->withInput();
            }
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

    public function CancelRisk(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            DocRiskHd::where('doc_risk_hds_id',$id)->update([
                'doc_risk_hds_flag' => false,
                'person_at' => Auth::user()->name,
                'updated_at'=> Carbon::now(),
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'ยกเลิกรายการเรียบร้อยแล้ว'
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function CancelRiskrow(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            DocRiskDt::where('doc_risk_dts_id',$id)->update([
                'doc_risk_dts_flag' => false,
                'person_at' => Auth::user()->name,
                'updated_at'=> Carbon::now(),
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'ยกเลิกรายการเรียบร้อยแล้ว'
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
