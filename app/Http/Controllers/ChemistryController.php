<?php

namespace App\Http\Controllers;

use App\Models\ChemicalDt;
use Carbon\Carbon;
use ChemicalHd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChemistryController extends Controller
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
        $hd = DB::table('chemistry_hd')->where('chemistry_hd_flag',1)->get();
        return view('chemicalsetup.form-chemistrys-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formule = DB::table('ms_formule')->get();
        $types = DB::table('chemistry_type')->get();
        $products = DB::table('chemical_lists')->get();
        return view('chemicalsetup.form-chemistrys-create', compact('formule','types','products'));
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
            'chemistry_hd_date' => ['required'],
            'ms_formule_name' => ['required'],
            'chemistry_hd_name' => ['required'],
            'chemistry_hd_type' => ['required'],
            'no' => ['required'],
        ]); 
        $year = date('Y');

        $last = DB::table('chemistry_hd')
            ->whereYear('chemistry_hd_date',$year)
            ->orderBy('chemistry_hd_number','desc')
            ->first();

        $runNumber = $last ? $last->chemistry_hd_number + 1 : 1;

        $docuno = 'CHEM'.$year.str_pad($runNumber,4,'0',STR_PAD_LEFT);
        $lastId = DB::table('chemistry_hd')->max('chemistry_hd_id');
        $newId = $lastId + 1;
        $data = [
            'chemistry_hd_id' => $newId,
            'chemistry_hd_date' => $request->chemistry_hd_date,
            'ms_formule_name' => $request->ms_formule_name,
            'chemistry_hd_mix' => $request->chemistry_hd_mix,
            'chemistry_hd_qty' => $request->chemistry_hd_qty,
            'chemistry_hd_note' => $request->chemistry_hd_note,
            'chemistry_hd_save' => Auth::user()->name,
            'chemistry_hd_flag' => true,
            'update_at' => Carbon::now(),
            'chemistry_hd_type' => $request->chemistry_hd_type,
            'chemistry_hd_docuno' => $docuno,
            'chemistry_hd_number' => $runNumber,
            'chemistry_hd_name' => $request->chemistry_hd_name,
            'chemistry_hd_calculate' => $request->chemistry_hd_calculate
        ];     
        try{
            DB::beginTransaction();
            DB::table('chemistry_hd')->insert($data);
            foreach ($request->no as $key => $value) {
                $pd = DB::table('chemical_lists')->where('chemical_lists_id',$request->code[$key])->first();
                $lastDtId = DB::table('chemistry_dt')->max('chemistry_dt_id');
                $newDtId = $lastDtId + 1;
                DB::table('chemistry_dt')->insert([
                    'chemistry_dt_id' => $newDtId,
                    'chemistry_hd_id' => $newId,
                    'no' =>  $value,
                    'code' => $pd->chemical_lists_refcode,
                    'material' => $pd->chemical_lists_name,
                    'grade' => $pd->chemical_lists_grade,
                    'density' => $request->density[$key],
                    'adjust' => $request->adjust[$key],
                    'weght' => $request->weght[$key],
                    'weghtper' => $request->weghtper[$key],
                    'weghttotal' => $request->weghttotal[$key],
                    'flag' => true,
                    'update_at' => Carbon::now(),
                ]);
            }  
            DB::commit();
            return redirect()->route('chemistrys.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $hd = DB::table('chemistry_hd')->where('chemistry_hd_id',$id)->first();
        $dt = DB::table('chemistry_dt')
        ->leftjoin('chemical_lists','chemistry_dt.code','=','chemical_lists.chemical_lists_refcode')
        ->leftjoin('chemical_groups','chemical_groups.chemical_groups_id','=','chemical_lists.chemical_groups_id')
        ->leftjoin('chemical_funtions','chemical_funtions.chemical_funtions_id','=','chemical_lists.chemical_funtions_id')
        ->where('chemistry_hd_id',$id)
        ->where('flag',1)->get();
        $lap = DB::table('TestHeaders')
        ->where('FormulaNumber',$hd->chemistry_hd_name)
        ->get();
        $test = DB::table('TestHeaders')
        ->leftjoin('TestDetails','TestHeaders.TestID','=','TestDetails.TestID')
        ->where('TestHeaders.FormulaNumber',$hd->chemistry_hd_name)
        ->get();
        return view('chemicalsetup.form-chemistrys-show', compact('hd','dt','lap','test'));
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
