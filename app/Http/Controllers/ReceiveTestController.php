<?php

namespace App\Http\Controllers;

use App\Models\ArRequestorderDt;
use App\Models\ArRequestorderHd;
use App\Models\CalibrationList;
use App\Models\ReceiveTestList;
use App\Models\ReceiveTestSub;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ReceiveTestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hd = ArRequestorderHd::leftjoin('ar_requestorder_statuses','ar_requestorder_hds.ar_requestorder_statuses_id','=','ar_requestorder_statuses.ar_requestorder_statuses_id')
        ->where('ar_requestorder_hds.ar_requestorder_statuses_id',5)
        ->get();
        return view('testsamples.form-receivetest-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hd = ArRequestorderHd::leftjoin('ar_requestorder_statuses','ar_requestorder_hds.ar_requestorder_statuses_id','=','ar_requestorder_statuses.ar_requestorder_statuses_id')
        ->leftjoin('receive_test_lists','ar_requestorder_hds.ar_requestorder_hds_id','=','receive_test_lists.ar_requestorder_hds_id')
        ->where('ar_requestorder_hds.ar_requestorder_statuses_id',6)
        ->get();
        return view('testsamples.form-testsamples-list', compact('hd'));
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
            'ar_requestorder_hds_id' => ['required'],
            'receive_test_lists_date' => ['required'],
            'receive_test_lists_dimensions' => ['required'],
            'dimensions_id' => ['required'],
            'receive_test_lists_weight' => ['required'],
            'weight_id' => ['required'],
            'chemistry_hd_id' => ['required'],
        ]);
        $data = [
            'ar_requestorder_hds_id' => $request->ar_requestorder_hds_id,
            'receive_test_lists_date' => $request->receive_test_lists_date,
            'receive_test_lists_dimensions' => $request->receive_test_lists_dimensions,
            'dimensions_id' => $request->dimensions_id,
            'receive_test_lists_weight' => $request->receive_test_lists_weight,
            'weight_id' => $request->weight_id,
            'chemistry_hd_id' => $request->chemistry_hd_id,
            'receive_test_lists_note' => $request->receive_test_lists_note,
            'person_at' => Auth::user()->name,
            'receive_test_lists_flag' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        if ($request->hasFile('receive_test_lists_file1')) {
            $data['receive_test_lists_file1'] = $request->file('receive_test_lists_file1')->storeAs('images/Receivetest_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('receive_test_lists_file1')->extension());
        }
        if ($request->hasFile('receive_test_lists_file2')) {
            $data['receive_test_lists_file2'] = $request->file('receive_test_lists_file2')->storeAs('images/Receivetest_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('receive_test_lists_file2')->extension());
        }
        if ($request->hasFile('receive_test_lists_file3')) {
            $data['receive_test_lists_file3'] = $request->file('receive_test_lists_file3')->storeAs('images/Receivetest_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('receive_test_lists_file3')->extension());
        }
        try{
            DB::beginTransaction();
            $insertHD = ReceiveTestList::create($data);     
            ArRequestorderHd::where('ar_requestorder_hds_id',$request->ar_requestorder_hds_id)->update([
                'ar_requestorder_statuses_id' => 6
            ]);   
            DB::commit();
            return redirect()->route('receive-test.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $hd = ArRequestorderHd::find($id);
        $dt = ArRequestorderDt::where('ar_requestorder_hds_id',$id)->where('ar_requestorder_dts_flag',true)->get();
        $bom = DB::table('chemistry_hd')->where('chemistry_hd_flag',true)->get();
        $cal = CalibrationList::get();
        $pd = ReceiveTestList::where('ar_requestorder_hds_id',$id)->first();
        return view('testsamples.form-testsamples-edit', compact('hd','dt','bom','cal','pd'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hd = ArRequestorderHd::find($id);
        $dt = ArRequestorderDt::where('ar_requestorder_hds_id',$id)->where('ar_requestorder_dts_flag',true)->get();
        $bom = DB::table('chemistry_hd')->where('chemistry_hd_flag',true)->get();
        $cal = CalibrationList::get();      
        return view('testsamples.form-receivetest-edit', compact('hd','dt','bom','cal'));
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
            'result_test_lists_date' => ['required'],
            'result_test_lists_dimensions' => ['required'],
            'result_dimensions_id' => ['required'],
            'result_test_lists_weight' => ['required'],
            'result_weight_id' => ['required'],
            'receive_test_subs_listno' => ['required'],
        ]);
        $data = [
            'result_test_lists_date' => $request->result_test_lists_date,
            'result_test_lists_dimensions' => $request->result_test_lists_dimensions,
            'result_dimensions_id' => $request->result_dimensions_id,
            'result_test_lists_weight' => $request->result_test_lists_weight,
            'result_weight_id' => $request->result_weight_id,
            'result_test_lists_note' => $request->receive_test_lists_note,
            'result_person_at' => Auth::user()->name,
            'updated_at' => Carbon::now(),
            'result_test_lists_temp' => $request->result_test_lists_temp,
            'result_test_lists_moisture' => $request->result_test_lists_moisture,
            'result_test_lists_plate' => $request->result_test_lists_plate,
            'result_test_lists_test' => $request->result_test_lists_test

        ];
        if ($request->hasFile('result_test_lists_file1')) {
            $data['result_test_lists_file1'] = $request->file('result_test_lists_file1')->storeAs('images/Receivetest_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('result_test_lists_file1')->extension());
        }
        if ($request->hasFile('result_test_lists_file2')) {
            $data['result_test_lists_file2'] = $request->file('result_test_lists_file2')->storeAs('images/Receivetest_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('result_test_lists_file2')->extension());
        }
        if ($request->hasFile('result_test_lists_file3')) {
            $data['result_test_lists_file3'] = $request->file('result_test_lists_file3')->storeAs('images/Receivetest_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('result_test_lists_file3')->extension());
        }
        try{
            DB::beginTransaction();
            $insertHD = ReceiveTestList::where('receive_test_lists_id',$id)->update($data);     
            ArRequestorderHd::where('ar_requestorder_hds_id',$request->ar_requestorder_hds_id)->update([
                'ar_requestorder_statuses_id' => 7
            ]);   
            foreach ($request->receive_test_subs_listno as $key => $value) {
                $dtData = [
                    'receive_test_lists_id' => $id,
                    'receive_test_subs_listno' => $value, 
                    'calibration_lists_id' => $request->calibration_lists_id[$key],
                    'receive_test_subs_note' => $request->receive_test_subs_note[$key],
                    'person_at' => Auth::user()->name,
                    'receive_test_lists_flag' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                ReceiveTestSub::insert($dtData);
            }
            DB::commit();
            return redirect()->route('receive-test.create')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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

    public function ReceiveResult(Request $request)
    {
        $hd = ArRequestorderHd::leftjoin('ar_requestorder_statuses','ar_requestorder_hds.ar_requestorder_statuses_id','=','ar_requestorder_statuses.ar_requestorder_statuses_id')
        ->leftjoin('receive_test_lists','ar_requestorder_hds.ar_requestorder_hds_id','=','receive_test_lists.ar_requestorder_hds_id')
        ->leftjoin('chemistry_hd','chemistry_hd.chemistry_hd_id','=','receive_test_lists.chemistry_hd_id')
        ->leftjoin('TestHeaders','ar_requestorder_hds.ar_requestorder_hds_docuno','=','TestHeaders.Lot')
        ->where('ar_requestorder_hds.ar_requestorder_statuses_id',7)
        ->get();
        return view('testsamples.form-testsamples-result', compact('hd'));
    }
}
