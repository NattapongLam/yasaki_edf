<?php

namespace App\Http\Controllers;

use App\Models\DocNcr;
use App\Models\DocNcrStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NcrController extends Controller
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
        $hd = DocNcr::leftjoin('doc_ncr_statuses','doc_ncrs.doc_ncr_statuses_id','=','doc_ncr_statuses.doc_ncr_statuses_id')
        ->get();
        return view('dcc.form-ncr-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hd = null;
        return view('dcc.form-ncr-create', compact('hd'));
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
            'doc_ncrs_date' => ['required'],
            'doc_ncrs_docuno' => ['required'],
            'doc_ncrs_person' => ['required'],
            'doc_ncrs_project' => ['required'],
            'doc_ncrs_duedate' => ['required'],
            'doc_ncrs_type' => ['required'],
            'doc_ncrs_process' => ['required'],
            'doc_ncrs_product' => ['required'],
            'doc_ncrs_nonconformity' => ['required'],
        ]);  
        $data = [
            'doc_ncrs_date' => $request->doc_ncrs_date,
            'doc_ncrs_docuno' => $request->doc_ncrs_docuno,
            'doc_ncrs_person' => $request->doc_ncrs_person,
            'doc_ncrs_project' => $request->doc_ncrs_project,
            'doc_ncrs_duedate' => $request->doc_ncrs_duedate,
            'doc_ncrs_type' => $request->doc_ncrs_type,
            'doc_ncrs_process' => $request->doc_ncrs_process,
            'doc_ncrs_product' => $request->doc_ncrs_product,
            'doc_ncrs_nonconformity' => $request->doc_ncrs_nonconformity,
            'doc_ncr_statuses_id' => 1,
            'person_at' => Auth::user()->name,
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
        ];
        try{
            DB::beginTransaction();
            $insertHD = DocNcr::create($data);               
            DB::commit();
            return redirect()->route('ncr.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $hd = DocNcr::leftjoin('doc_ncr_statuses','doc_ncrs.doc_ncr_statuses_id','=','doc_ncr_statuses.doc_ncr_statuses_id')
        ->where('doc_ncrs.doc_ncrs_id',$id)
        ->first();
        $sta = DocNcrStatus::get();
        return view('dcc.form-ncr-edit', compact('hd','sta'));
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
        $hd = DocNcr::find($id);
        if($hd->doc_ncr_statuses_id == 1){
            try{
                DB::beginTransaction();
                DocNcr::where('doc_ncrs_id',$id)
                ->update([
                    'doc_ncr_statuses_id' => $request->doc_ncr_statuses_id,
                    'approved_by' => Auth::user()->name,
                    'approved_date' => $request->approved_date,
                    'approved_remark' => $request->approved_remark
                ]);             
                DB::commit();
                return redirect()->route('ncr.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            }catch(\Exception $e){
                Log::error($e->getMessage());
                dd($e->getMessage());
                return redirect()->back()->with('error', 'เกิดข้อผิดพลาด');
            }  
        }elseif ($hd->doc_ncr_statuses_id == 2) {
            try{
                DB::beginTransaction();
                DocNcr::where('doc_ncrs_id',$id)
                ->update([
                    'doc_ncr_statuses_id' => 4,
                    'doc_ncrs_causes' => $request->doc_ncrs_causes,
                    // 'doc_ncrs_troubleshooting' => $request->doc_ncrs_troubleshooting,
                    // 'doc_ncrs_preventive' => $request->doc_ncrs_preventive,
                    'responsible_at' => Auth::user()->name,
                    'responsible_date' => $request->responsible_date,
                    'doc_ncrs_actionresult' => $request->doc_ncrs_actionresult,
                    'doc_ncrs_actionremark' => $request->doc_ncrs_actionremark,
                ]);             
                DB::commit();
                return redirect()->route('ncr.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            }catch(\Exception $e){
                Log::error($e->getMessage());
                dd($e->getMessage());
                return redirect()->back()->with('error', 'เกิดข้อผิดพลาด');
            }  
        }elseif ($hd->doc_ncr_statuses_id == 4) {
            try{
                DB::beginTransaction();
                DocNcr::where('doc_ncrs_id',$id)
                ->update([
                    'doc_ncr_statuses_id' => 5,                   
                    'recheck_at' => Auth::user()->name,
                    'recheck_date' => $request->recheck_date
                ]);             
                DB::commit();
                return redirect()->route('ncr.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            }catch(\Exception $e){
                Log::error($e->getMessage());
                dd($e->getMessage());
                return redirect()->back()->with('error', 'เกิดข้อผิดพลาด');
            }  
        }elseif ($hd->doc_ncr_statuses_id == 5) {
            try{
                DB::beginTransaction();
                DocNcr::where('doc_ncrs_id',$id)
                ->update([
                    'doc_ncr_statuses_id' => 6,
                    'doc_ncrs_consequencesresult' => $request->doc_ncrs_consequencesresult,
                    'doc_ncrs_consequencesremark' => $request->doc_ncrs_consequencesremark,
                    'close_at' => Auth::user()->name,
                    'close_date' => $request->close_date,
                ]);             
                DB::commit();
                return redirect()->route('ncr.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            }catch(\Exception $e){
                Log::error($e->getMessage());
                dd($e->getMessage());
                return redirect()->back()->with('error', 'เกิดข้อผิดพลาด');
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

    public function CancelNcr(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            DocNcr::where('doc_ncrs_id',$id)->update([
                'doc_ncr_statuses_id' => 7,
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
