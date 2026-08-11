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
        $hd = null;
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
            if ($request->has('doc_risk_hds_issue')) {
                foreach ($request->doc_risk_hds_issue as $key => $value) {
                    // สมมติว่า Model รายละเอียดคือ DocRiskDt (ปรับชื่อ Model ตามโปรเจกต์ของคุณ)
                    DocRiskDt::create([
                        'doc_risk_hds_id' => $insertHD->id, // Foreign Key เชื่อมกับตาราง Header
                        'doc_risk_hds_issue' => $request->doc_risk_hds_issue[$key] ?? '-',
                        'doc_risk_hds_effect' => $request->doc_risk_hds_effect[$key] ?? '-',
                        'doc_risk_hds_control' => $request->doc_risk_hds_control[$key] ?? '-',
                        'doc_risk_dts_likelihood' => $request->doc_risk_dts_likelihood[$key] ?? '-',
                        'doc_risk_dts_impact' => $request->doc_risk_dts_impact[$key] ?? '-',
                        'doc_risk_dts_score' => $request->doc_risk_dts_score[$key] ?? '-',
                        'doc_risk_dts_violence' => $request->doc_risk_dts_violence[$key] ?? '-',
                        'doc_risk_dts_chance' => $request->doc_risk_dts_chance[$key] ?? '-',
                        'doc_risk_dts_period' => $request->doc_risk_dts_period[$key] ?? '-',
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
        //
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
        //
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
