<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ChemicalGroup;
use App\Models\ChemicalFuntion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ChemicalGroupController extends Controller
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
        $hd = ChemicalGroup::get();
        return view('chemicalsetup.form-chemicalgroup-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hd = null;
        return view('chemicalsetup.form-chemicalgroup-create', compact('hd'));
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
            'chemical_groups_name' => [
                'required',
                'unique:chemical_groups,chemical_groups_name',
            ],
            'chemical_funtions_listno' => ['required'],
        ]);
        $data = [
            'chemical_groups_name' => $request->chemical_groups_name,
            'chemical_groups_flag' => 1,
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        try{
            DB::beginTransaction();
            $insertHD = ChemicalGroup::create($data);
            foreach ($request->chemical_funtions_listno as $key => $value) {
                ChemicalFuntion::insert([
                    'chemical_funtions_listno' => $value,
                    'chemical_groups_id' => $insertHD->chemical_groups_id,
                    'chemical_funtions_name' => $request->chemical_funtions_name[$key],
                    'chemical_funtions_flag' => 1,
                    'person_at' => Auth::user()->name,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }                      
            DB::commit();
            return redirect()->route('chemicalgroups.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $hd = ChemicalGroup::find($id);
        return view('chemicalsetup.form-chemicalgroup-edit', compact('hd'));
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
            'chemical_groups_name' => $request->chemical_groups_name,
            'chemical_groups_flag' => 1,
            'person_at' => Auth::user()->name,
            'updated_at' => Carbon::now(),
        ];
        try{
            DB::beginTransaction();
            $insertHD = ChemicalGroup::where('chemical_groups_id',$id)->update($data);
            if($request->chemical_funtions_listno){
                foreach ($request->chemical_funtions_listno as $key => $value) {
                    ChemicalFuntion::insert([
                        'chemical_funtions_listno' => $value,
                        'chemical_groups_id' => $insertHD->chemical_groups_id,
                        'chemical_funtions_name' => $request->chemical_funtions_name[$key],
                        'chemical_funtions_flag' => 1,
                        'person_at' => Auth::user()->name,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }          
            }                   
            DB::commit();
            return redirect()->route('chemicalgroups.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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

    public function confirmDelChemicalGroup(Request $request)
    {
        $id = $request->refid;
        try {
            DB::beginTransaction();
            ChemicalGroup::where('chemical_groups_id', $id)
            ->update([
                'updated_at' => Carbon::now(),
                'chemical_groups_flag' => 0,
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

    public function getDataChemicalGroup(Request $request)
    {
        $dt = ChemicalFuntion::where('chemical_groups_id',$request->refid)->get();
        return response()->json(
        [
            'status' => true,
            'dt' => $dt,
        ]);
    }

    public function confirmDelChemicalFuntion(Request $request)
    {
        $id = $request->refid;
        try {
            DB::beginTransaction();
            ChemicalFuntion::where('chemical_funtions_id', $id)
            ->update([
                'updated_at' => Carbon::now(),
                'chemical_funtions_flag' => 0,
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
}
