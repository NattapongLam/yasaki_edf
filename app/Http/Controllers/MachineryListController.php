<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\MachineryList;
use App\Models\MachineryGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class MachineryListController extends Controller
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
        $hd = MachineryList::get();
        return view('machinerysetup.form-machinerylist-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gb = MachineryGroup::where('machinery_groups_flag',true)->get();
        return view('machinerysetup.form-machinerylist-create', compact('gb'));
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
            'machinery_groups_id' => ['required'],
            'machinery_lists_code' => ['required'],
            'machinery_lists_name1' => ['required'],
        ]);
        $data = [
            'machinery_groups_id' => $request->machinery_groups_id,
            'machinery_lists_code' => $request->machinery_lists_code,
            'machinery_lists_name1' => $request->machinery_lists_name1,
            'machinery_lists_name2' => $request->machinery_lists_name2,
            'machinery_lists_date' => $request->machinery_lists_date,
            'machinery_lists_expirationdate' => $request->machinery_lists_expirationdate,
            'machinery_lists_brand' => $request->machinery_lists_brand,
            'machinery_lists_serialno' => $request->machinery_lists_serialno,
            'machinery_lists_location' => $request->machinery_lists_location,
            'machinery_lists_reamrk' => $request->machinery_lists_reamrk,
            'machinery_lists_flag' => true,
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now(), 
            'machinery_lists_plandate' => $request->machinery_lists_plandate,
            'machinery_lists_nextdate' => $request->machinery_lists_nextdate,
            'machinery_lists_day' => $request->machinery_lists_day,
        ];
        if ($request->hasFile('machinery_lists_file1')) {
            $data['machinery_lists_file1'] = $request->file('machinery_lists_file1')->storeAs('images/Machinery_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('machinery_lists_file1')->extension());
        }
        if ($request->hasFile('machinery_lists_file2')) {
            $data['machinery_lists_file2'] = $request->file('machinery_lists_file2')->storeAs('images/Machinery_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('machinery_lists_file2')->extension());
        }
        if ($request->hasFile('machinery_lists_file3')) {
            $data['machinery_lists_file3'] = $request->file('machinery_lists_file3')->storeAs('images/Machinery_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('machinery_lists_file3')->extension());
        }
        if ($request->hasFile('machinery_lists_file4')) {
            $data['machinery_lists_file4'] = $request->file('machinery_lists_file4')->storeAs('images/Machinery_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('machinery_lists_file4')->extension());
        }
        try{
            DB::beginTransaction();
            $insertHD = MachineryList::create($data);               
            DB::commit();
            return redirect()->route('machinerylists.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $hd = MachineryList::find($id);
        return view('machinerysetup.form-machinerychecksheet-create', compact('hd'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hd = MachineryList::find($id);
        $gb = MachineryGroup::where('machinery_groups_flag',true)->get();
        return view('machinerysetup.form-machinerylist-edit', compact('hd','gb'));
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
        $data = [
            'machinery_groups_id' => $request->machinery_groups_id,
            'machinery_lists_name1' => $request->machinery_lists_name1,
            'machinery_lists_name2' => $request->machinery_lists_name2,
            'machinery_lists_date' => $request->machinery_lists_date,
            'machinery_lists_expirationdate' => $request->machinery_lists_expirationdate,
            'machinery_lists_brand' => $request->machinery_lists_brand,
            'machinery_lists_serialno' => $request->machinery_lists_serialno,
            'machinery_lists_location' => $request->machinery_lists_location,
            'machinery_lists_reamrk' => $request->machinery_lists_reamrk,
            'machinery_lists_flag' => true,
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now(), 
            'machinery_lists_plandate' => $request->machinery_lists_plandate,
            'machinery_lists_nextdate' => $request->machinery_lists_nextdate,
            'machinery_lists_day' => $request->machinery_lists_day,
        ];
        if ($request->hasFile('machinery_lists_file1')) {
            $data['machinery_lists_file1'] = $request->file('machinery_lists_file1')->storeAs('images/Machinery_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('machinery_lists_file1')->extension());
        }
        if ($request->hasFile('machinery_lists_file2')) {
            $data['machinery_lists_file2'] = $request->file('machinery_lists_file2')->storeAs('images/Machinery_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('machinery_lists_file2')->extension());
        }
        if ($request->hasFile('machinery_lists_file3')) {
            $data['machinery_lists_file3'] = $request->file('machinery_lists_file3')->storeAs('images/Machinery_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('machinery_lists_file3')->extension());
        }
        if ($request->hasFile('machinery_lists_file4')) {
            $data['machinery_lists_file4'] = $request->file('machinery_lists_file4')->storeAs('images/Machinery_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('machinery_lists_file4')->extension());
        }
        try{
            DB::beginTransaction();
            $insertHD = MachineryList::where('machinery_lists_id',$id)->update($data);               
            DB::commit();
            return redirect()->route('machinerylists.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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

    public function CancelMachinery(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            MachineryList::where('machinery_lists_id',$id)->update([
                'machinery_lists_flag' => false,
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
