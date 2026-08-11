<?php

namespace App\Http\Controllers;

use App\Models\DocCar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CarController extends Controller
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
        $hd = DocCar::leftjoin('doc_statuses','doc_cars.doc_statuses_id','=','doc_statuses.doc_statuses_id')->get();
        return view('dcc.form-car-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hd = null;
        return view('dcc.form-car-create', compact('hd'));
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
            'doc_cars_relevant' => ['required'],
            'doc_cars_date' => ['required'],
            'doc_cars_docuno' => ['required'],
            'doc_cars_type' => ['required'],
            'doc_cars_issuingdep' => ['required'],
            'doc_cars_relevantdep' => ['required'],
            'doc_cars_person' => ['required'],
            'doc_cars_topics' => ['required'],
            'doc_cars_defects' => ['required'],
            'doc_cars_problem' => ['required'],
        ]);  
        $data = [
            'doc_cars_relevant' => $request->doc_cars_relevant,
            'doc_cars_date' => $request->doc_cars_date,
            'doc_cars_docuno' => $request->doc_cars_docuno,
            'doc_cars_type' => $request->doc_cars_type,
            'doc_cars_issuingdep' => $request->doc_cars_issuingdep,
            'doc_cars_relevantdep' => $request->doc_cars_relevantdep,
            'doc_cars_person' => $request->doc_cars_person,
            'doc_cars_topics' => $request->doc_cars_topics,
            'doc_cars_defects' => $request->doc_cars_defects,
            'doc_cars_problem' => $request->doc_cars_problem,
            'doc_statuses_id' => 1,
            'person_at' => Auth::user()->name,
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
        ];
        try{
            DB::beginTransaction();
            $insertHD = DocCar::create($data);               
            DB::commit();
            return redirect()->route('car.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $hd = DocCar::find($id);
        return view('dcc.form-car-edit', compact('hd'));
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
        $hd =  DocCar::find($id);
        if($hd->doc_statuses_id == 1){
            try{
                DB::beginTransaction();
                DocCar::where('doc_cars_id',$id)->update([
                    'doc_statuses_id' => 2,
                    'doc_cars_cause' => $request->doc_cars_cause,
                    'doc_cars_solving' => $request->doc_cars_solving,
                    'doc_cars_preventing' => $request->doc_cars_preventing,
                    'responsible_at' => Auth::user()->name,
                    'responsible_date' => $request->responsible_date,
                ]);               
                DB::commit();
                return redirect()->route('car.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            }catch(\Exception $e){
                Log::error($e->getMessage());
                dd($e->getMessage());
                return redirect()->back()->with('error', 'เกิดข้อผิดพลาด');
            }  
        }elseif ($hd->doc_statuses_id == 2) {
             try{
                DB::beginTransaction();
                DocCar::where('doc_cars_id',$id)->update([
                    'doc_statuses_id' => 3,
                    'review_at' => Auth::user()->name,
                    'review_date' => $request->responsible_date,
                ]);               
                DB::commit();
                return redirect()->route('car.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            }catch(\Exception $e){
                Log::error($e->getMessage());
                dd($e->getMessage());
                return redirect()->back()->with('error', 'เกิดข้อผิดพลาด');
            }  
        }elseif($hd->doc_statuses_id == 3){
            try{
                DB::beginTransaction();
                DocCar::where('doc_cars_id',$id)->update([
                    'doc_statuses_id' => 4,
                    'doc_cars_details' => $request->doc_cars_details,
                    'doc_cars_remark' => $request->doc_cars_remark,
                    'doc_cars_summarize' => $request->doc_cars_summarize,
                    'doc_cars_newdocuno' => $request->doc_cars_newdocuno,
                    'follow_at' => Auth::user()->name,
                    'follow_date' => $request->follow_date
                ]);               
                DB::commit();
                return redirect()->route('car.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            }catch(\Exception $e){
                Log::error($e->getMessage());
                dd($e->getMessage());
                return redirect()->back()->with('error', 'เกิดข้อผิดพลาด');
            }  
        }elseif ($hd->doc_statuses_id == 4) {
            try{
                DB::beginTransaction();
                DocCar::where('doc_cars_id',$id)->update([
                    'doc_statuses_id' => 5,
                    'approved_at' => Auth::user()->name,
                    'approved_date' => $request->approved_date
                ]);               
                DB::commit();
                return redirect()->route('car.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
     public function CancelCar(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            DocCar::where('doc_cars_id',$id)->update([
                'doc_statuses_id' => 6,
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
