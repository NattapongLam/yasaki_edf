<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\MachineryChecksheetDt;
use App\Models\MachineryChecksheetHd;

class MachineryChecksheetController extends Controller
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
        $hd = MachineryChecksheetHd::get();
        return view('machinerysetup.form-machinerychecksheet-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'machinery_checksheet_hds_date' => ['required'],
        ]);    
        $data = [
            'machinery_checksheet_hds_date' => $request->machinery_checksheet_hds_date,
            'machinery_lists_id' => $request->machinery_lists_id,
            'machinery_lists_code' => $request->machinery_lists_code,
            'machinery_lists_name' => $request->machinery_lists_name,
            'machinery_checksheet_hds_remark' => $request->machinery_checksheet_hds_remark,
            'machinery_checksheet_hds_flag' => true,
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now(), 
        ];
        try
        {
            DB::beginTransaction();
            $insertHD = MachineryChecksheetHd::create($data);   
            foreach ($request->machinery_checksheet_dts_listno as $key => $value) {
                MachineryChecksheetDt::insert([
                    'machinery_checksheet_hds_id' => $insertHD->machinery_checksheet_hds_id,
                    'machinery_checksheet_dts_listno' => $request->machinery_checksheet_dts_listno[$key],
                    'machinery_checksheet_dts_remark' => $request->machinery_checksheet_dts_remark[$key],
                    'machinery_checksheet_dts_flag' => true,
                    'person_at' => Auth::user()->name,
                    'created_at'=> Carbon::now(),
                    'updated_at'=> Carbon::now(),
                ]);
            }            
            DB::commit();
            return redirect()->route('machinerychecksheets.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $hd = MachineryChecksheetHd::find($id);
        $dt = MachineryChecksheetDt::where('machinery_checksheet_dts_flag',true)->where('machinery_checksheet_hds_id',$id)->get();
        return view('machinerysetup.form-machinerychecksheet-update', compact('hd','dt'));
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
        try
        {
            DB::beginTransaction();
            $detailIds = $request->machinery_checksheet_dts_id ?? [];
            $actions   = $request->action ?? [];
            foreach ($detailIds as $index => $detailId) {
                $updateData = [];
                for ($i = 1; $i <= 31; $i++) {
                    $field = 'action_' . str_pad($i, 2, '0', STR_PAD_LEFT);
                    $updateData[$field] =
                        isset($actions[$index][$field]) ? 1 : 0;
                }
                MachineryChecksheetDt::where('machinery_checksheet_dts_id', $detailId)->update($updateData);
            }
            DB::commit();
            return redirect()->route('machinerychecksheets.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
