<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\ChemicalList;
use Illuminate\Http\Request;
use App\Models\ChemicalGroup;
use App\Models\ChemicalFuntion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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
        ];
        if ($request->hasFile('chemical_lists_file1')) {
            $data['chemical_lists_file1'] = $request->file('chemical_lists_file1')->storeAs('img/Chemical_File', "IMG_" . carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('chemical_lists_file1')->extension());
        }
        if ($request->hasFile('chemical_lists_file2')) {
            $data['chemical_lists_file2'] = $request->file('chemical_lists_file2')->storeAs('img/Chemical_File', "IMG_" . carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('chemical_lists_file2')->extension());
        }
        try{
            DB::beginTransaction();
            $insertHD = ChemicalList::create($data);                     
            DB::commit();
            return redirect()->route('chemicallists.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $groups = ChemicalGroup::where('chemical_groups_flag',true)->get();
        $hd = ChemicalList::find($id);
        return view('chemicalsetup.form-chemical-edit', compact('groups','hd'));
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
        ];
        if ($request->hasFile('chemical_lists_file1')) {
            $data['chemical_lists_file1'] = $request->file('chemical_lists_file1')->storeAs('img/Chemical_File', "IMG_" . carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('chemical_lists_file1')->extension());
        }
        if ($request->hasFile('chemical_lists_file2')) {
            $data['chemical_lists_file2'] = $request->file('chemical_lists_file2')->storeAs('img/Chemical_File', "IMG_" . carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('chemical_lists_file2')->extension());
        }
        try{
            DB::beginTransaction();
            $insertHD = ChemicalList::where('chemical_lists_id',$id)->update($data);                     
            DB::commit();
            return redirect()->route('chemicallists.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
