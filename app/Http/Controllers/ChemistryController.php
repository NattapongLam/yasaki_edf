<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
        $products = DB::table('chemical_lists')
        ->leftjoin('chemical_groups','chemical_groups.chemical_groups_id','=','chemical_lists.chemical_groups_id')
        ->get();
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
            'chemistry_hd_calculate' => $request->chemistry_hd_calculate,
            'total_density' => $request->total_density,
            'total_adjust' => $request->total_adjust,
            'total_volume' => $request->total_volume,
            'total_wper' => $request->total_wper,
            'total_weght' => $request->total_weght
        ];     
        if ($request->hasFile('chemistry_hd_file1')) { 
            $data['chemistry_hd_file1'] = $request->file('chemistry_hd_file1')->storeAs('images/Chemical_File', "IMG_" . carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('chemistry_hd_file1')->extension()); 
        } 
        if ($request->hasFile('chemistry_hd_file2')) { 
            $data['chemistry_hd_file2'] = $request->file('chemistry_hd_file2')->storeAs('images/Chemical_File', "IMG_" . carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('chemistry_hd_file2')->extension());
        }
        if ($request->hasFile('chemistry_hd_file3')) { 
            $data['chemistry_hd_file3'] = $request->file('chemistry_hd_file3')->storeAs('images/Chemical_File', "IMG_" . carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('chemistry_hd_file3')->extension());
        }
        if ($request->hasFile('chemistry_hd_file4')) { 
            $data['chemistry_hd_file4'] = $request->file('chemistry_hd_file4')->storeAs('images/Chemical_File', "IMG_" . carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('chemistry_hd_file4')->extension());
        }
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
        $hd = DB::table('chemistry_hd')->where('chemistry_hd_id', $id)->first();

        if (!$hd) {
            abort(404, 'Chemistry record not found.');
        }

        $dt = DB::table('chemistry_dt')
            ->leftjoin('chemical_lists', 'chemistry_dt.code', '=', 'chemical_lists.chemical_lists_refcode')
            ->leftjoin('chemical_groups', 'chemical_groups.chemical_groups_id', '=', 'chemical_lists.chemical_groups_id')
            ->leftjoin('chemical_funtions', 'chemical_funtions.chemical_funtions_id', '=', 'chemical_lists.chemical_funtions_id')
            ->where('chemistry_hd_id', $id)
            ->where('flag', 1)->get();

        $laplist = DB::table('TestHeaders')
            ->where('FormulaNumber', $hd->chemistry_hd_name)
            ->get();

        $lap = DB::table('TestHeaders')
            ->where('FormulaNumber', $hd->chemistry_hd_name)
            ->latest('TestID')
            ->first();

        $types = DB::table('chemistry_type')->get();

        $products = DB::table('chemical_lists')
            ->leftjoin('chemical_groups', 'chemical_groups.chemical_groups_id', '=', 'chemical_lists.chemical_groups_id')
            ->get();

        $feeavg = DB::table('vw_formula_feeavg')
            ->where('FormulaNumber', $hd->chemistry_hd_name)->get();

        $datefeeavg = DB::table('vw_formula_datefeeavg')
            ->where('FormulaNumber', $hd->chemistry_hd_name)->get();

        $emptyCollections = [
            'test'     => collect(),
            'roadlist' => collect(),
            'n1labels' => collect(), 'n1u100' => collect(), 'n1c100' => collect(),
            'n1u150'   => collect(), 'n1c150' => collect(), 'n1u200' => collect(),
            'n1c200'   => collect(), 'n1u250' => collect(), 'n1c250' => collect(),
            'n1u300'   => collect(), 'n1c300' => collect(), 'n1u350' => collect(),
            'n1c350'   => collect(), 'n1ufall' => collect(), 'n1cfall' => collect(),
            'n2labels' => collect(), 'n2u100' => collect(), 'n2c100' => collect(),
            'n2u150'   => collect(), 'n2c150' => collect(), 'n2u200' => collect(),
            'n2c200'   => collect(), 'n2u250' => collect(), 'n2c250' => collect(),
            'n2u300'   => collect(), 'n2c300' => collect(), 'n2u350' => collect(),
            'n2c350'   => collect(), 'n2ufall' => collect(), 'n2cfall' => collect(),
            'n3labels' => collect(), 'n3u100' => collect(), 'n3c100' => collect(),
            'n3u150'   => collect(), 'n3c150' => collect(), 'n3u200' => collect(),
            'n3c200'   => collect(), 'n3u250' => collect(), 'n3c250' => collect(),
            'n3u300'   => collect(), 'n3c300' => collect(), 'n3u350' => collect(),
            'n3c350'   => collect(), 'n3ufall' => collect(), 'n3cfall' => collect(),
            'labels'   => collect(),
        ];

        if (!$lap) {
            return view('chemicalsetup.form-chemistrys-show', array_merge($emptyCollections, [
                'hd'          => $hd,
                'dt'          => $dt,
                'lap'         => null,
                'laplist'     => $laplist,
                'feeavg'      => $feeavg,
                'datefeeavg'  => $datefeeavg,
                'types'       => $types,
                'products'    => $products,
                'labels1'     => collect(range(1, 500)),
            ]));
        }

        $test = DB::table('TestHeaders')
            ->leftjoin('TestDetails', 'TestHeaders.TestID', '=', 'TestDetails.TestID')
            ->where('TestHeaders.TestID', $lap->TestID)
            ->get();

        $testIds = DB::table('TestHeaders')
            ->where('TestID', $lap->TestID)
            ->pluck('TestID');

        $roadlist = DB::table('TestRoads')
            ->whereIn('TestID', $testIds)
            ->get();

        // ---- N1 ----
        $frictions1 = DB::table('TestFrictions')
            ->whereIn('TestID', $testIds)
            ->where('SampleSet', 'N1')
            ->orderBy('Listno')
            ->get([
                'Listno',
                'Friction100_u', 'Friction100_c',
                'Friction150_u', 'Friction150_c',
                'Friction200_u', 'Friction200_c',
                'Friction250_u', 'Friction250_c',
                'Friction300_u', 'Friction300_c',
                'Friction350_u', 'Friction350_c',
                'FrictionFall_u', 'FrictionFall_c',
            ]);

        $n1labels  = $frictions1->pluck('Listno');
        $n1u100    = $frictions1->where('Friction100_u',  '>', 0)->pluck('Friction100_u');
        $n1c100    = $frictions1->where('Friction100_c',  '>', 0)->pluck('Friction100_c');
        $n1u150    = $frictions1->where('Friction150_u',  '>', 0)->pluck('Friction150_u');
        $n1c150    = $frictions1->where('Friction150_c',  '>', 0)->pluck('Friction150_c');
        $n1u200    = $frictions1->where('Friction200_u',  '>', 0)->pluck('Friction200_u');
        $n1c200    = $frictions1->where('Friction200_c',  '>', 0)->pluck('Friction200_c');
        $n1u250    = $frictions1->where('Friction250_u',  '>', 0)->pluck('Friction250_u');
        $n1c250    = $frictions1->where('Friction250_c',  '>', 0)->pluck('Friction250_c');
        $n1u300    = $frictions1->where('Friction300_u',  '>', 0)->pluck('Friction300_u');
        $n1c300    = $frictions1->where('Friction300_c',  '>', 0)->pluck('Friction300_c');
        $n1u350    = $frictions1->where('Friction350_u',  '>', 0)->pluck('Friction350_u');
        $n1c350    = $frictions1->where('Friction350_c',  '>', 0)->pluck('Friction350_c');
        $n1ufall   = $frictions1->where('FrictionFall_u', '>', 0)->pluck('FrictionFall_u');
        $n1cfall   = $frictions1->where('FrictionFall_c', '>', 0)->pluck('FrictionFall_c');

        // ---- N2 ----
        $frictions2 = DB::table('TestFrictions')
            ->whereIn('TestID', $testIds)
            ->where('SampleSet', 'N2')
            ->orderBy('Listno')
            ->get([
                'Listno',
                'Friction100_u', 'Friction100_c',
                'Friction150_u', 'Friction150_c',
                'Friction200_u', 'Friction200_c',
                'Friction250_u', 'Friction250_c',
                'Friction300_u', 'Friction300_c',
                'Friction350_u', 'Friction350_c',
                'FrictionFall_u', 'FrictionFall_c',
            ]);

        $n2labels  = $frictions2->pluck('Listno');
        $n2u100    = $frictions2->where('Friction100_u',  '>', 0)->pluck('Friction100_u');
        $n2c100    = $frictions2->where('Friction100_c',  '>', 0)->pluck('Friction100_c');
        $n2u150    = $frictions2->where('Friction150_u',  '>', 0)->pluck('Friction150_u');
        $n2c150    = $frictions2->where('Friction150_c',  '>', 0)->pluck('Friction150_c');
        $n2u200    = $frictions2->where('Friction200_u',  '>', 0)->pluck('Friction200_u');
        $n2c200    = $frictions2->where('Friction200_c',  '>', 0)->pluck('Friction200_c');
        $n2u250    = $frictions2->where('Friction250_u',  '>', 0)->pluck('Friction250_u');
        $n2c250    = $frictions2->where('Friction250_c',  '>', 0)->pluck('Friction250_c');
        $n2u300    = $frictions2->where('Friction300_u',  '>', 0)->pluck('Friction300_u');
        $n2c300    = $frictions2->where('Friction300_c',  '>', 0)->pluck('Friction300_c');
        $n2u350    = $frictions2->where('Friction350_u',  '>', 0)->pluck('Friction350_u');
        $n2c350    = $frictions2->where('Friction350_c',  '>', 0)->pluck('Friction350_c');
        $n2ufall   = $frictions2->where('FrictionFall_u', '>', 0)->pluck('FrictionFall_u');
        $n2cfall   = $frictions2->where('FrictionFall_c', '>', 0)->pluck('FrictionFall_c');

        // ---- N3 ----
        $frictions3 = DB::table('TestFrictions')
            ->whereIn('TestID', $testIds)
            ->where('SampleSet', 'N3')
            ->orderBy('Listno')
            ->get([
                'Listno',
                'Friction100_u', 'Friction100_c',
                'Friction150_u', 'Friction150_c',
                'Friction200_u', 'Friction200_c',
                'Friction250_u', 'Friction250_c',
                'Friction300_u', 'Friction300_c',
                'Friction350_u', 'Friction350_c',
                'FrictionFall_u', 'FrictionFall_c',
            ]);

        $n3labels  = $frictions3->pluck('Listno');
        $n3u100    = $frictions3->where('Friction100_u',  '>', 0)->pluck('Friction100_u');
        $n3c100    = $frictions3->where('Friction100_c',  '>', 0)->pluck('Friction100_c');
        $n3u150    = $frictions3->where('Friction150_u',  '>', 0)->pluck('Friction150_u');
        $n3c150    = $frictions3->where('Friction150_c',  '>', 0)->pluck('Friction150_c');
        $n3u200    = $frictions3->where('Friction200_u',  '>', 0)->pluck('Friction200_u');
        $n3c200    = $frictions3->where('Friction200_c',  '>', 0)->pluck('Friction200_c');
        $n3u250    = $frictions3->where('Friction250_u',  '>', 0)->pluck('Friction250_u');
        $n3c250    = $frictions3->where('Friction250_c',  '>', 0)->pluck('Friction250_c');
        $n3u300    = $frictions3->where('Friction300_u',  '>', 0)->pluck('Friction300_u');
        $n3c300    = $frictions3->where('Friction300_c',  '>', 0)->pluck('Friction300_c');
        $n3u350    = $frictions3->where('Friction350_u',  '>', 0)->pluck('Friction350_u');
        $n3c350    = $frictions3->where('Friction350_c',  '>', 0)->pluck('Friction350_c');
        $n3ufall   = $frictions3->where('FrictionFall_u', '>', 0)->pluck('FrictionFall_u');
        $n3cfall   = $frictions3->where('FrictionFall_c', '>', 0)->pluck('FrictionFall_c');

        $labels = collect([$n1labels, $n2labels, $n3labels])
            ->sortByDesc(fn($x) => $x->count())
            ->first()
            ->values();

        $labels1 = collect(range(1, 500));

        return view('chemicalsetup.form-chemistrys-show', compact(
            'hd', 'dt', 'lap', 'test', 'types', 'products', 'feeavg', 'datefeeavg',
            'n1labels', 'n1u100', 'n1c100', 'n1u150', 'n1c150', 'n1u200', 'n1c200',
            'n1u250', 'n1c250', 'n1u300', 'n1c300', 'n1u350', 'n1c350', 'n1ufall', 'n1cfall',
            'n2labels', 'n2u100', 'n2c100', 'n2u150', 'n2c150', 'n2u200', 'n2c200',
            'n2u250', 'n2c250', 'n2u300', 'n2c300', 'n2u350', 'n2c350', 'n2ufall', 'n2cfall',
            'n3labels', 'n3u100', 'n3c100', 'n3u150', 'n3c150', 'n3u200', 'n3c200',
            'n3u250', 'n3c250', 'n3u300', 'n3c300', 'n3u350', 'n3c350', 'n3ufall', 'n3cfall',
            'labels', 'labels1', 'roadlist', 'laplist'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hd = DB::table('chemistry_hd')->where('chemistry_hd_id',$id)->first();
        $dt = DB::table('chemistry_dt')
        ->leftjoin('chemical_lists','chemistry_dt.code','=','chemical_lists.chemical_lists_refcode')
        ->leftjoin('chemical_groups','chemical_groups.chemical_groups_id','=','chemical_lists.chemical_groups_id')
        ->leftjoin('chemical_funtions','chemical_funtions.chemical_funtions_id','=','chemical_lists.chemical_funtions_id')
        ->where('chemistry_hd_id',$id)
        ->where('flag',1)->get();
        $formule = DB::table('ms_formule')->get();
        $types = DB::table('chemistry_type')->get();
        $products = DB::table('chemical_lists')
        ->leftjoin('chemical_groups','chemical_groups.chemical_groups_id','=','chemical_lists.chemical_groups_id')
        ->get();
        return view('chemicalsetup.form-chemistrys-edit', compact('hd','dt','formule','types','products'));
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
        try{
            DB::beginTransaction();
            if(Auth::user()->username == "A653615" || Auth::user()->username == "A551528" || Auth::user()->username == "adviser"){
                $data = [
                    'chemistry_hd_calculate' => $request->chemistry_hd_calculate,
                    'chemistry_hd_note' => $request->chemistry_hd_note,
                    'chemistry_hd_type' => $request->chemistry_hd_type,
                    'chemistry_hd_save' => Auth::user()->name,
                    'update_at' => Carbon::now(),
                    'chemistry_hd_note' => $request->chemistry_hd_note,
                    'total_density' => $request->total_density,
                    'total_adjust' => $request->total_adjust,
                    'total_volume' => $request->total_volume,
                    'total_wper' => $request->total_wper,
                    'total_weght' => $request->total_weght,
                    'total_cost' => $request->total_cost,
                    'avg_cost' => $request->avg_cost
                ];
                if ($request->hasFile('chemistry_hd_file1')) { 
                    $data['chemistry_hd_file1'] = $request->file('chemistry_hd_file1')->storeAs('images/Chemical_File', "IMG_" . carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('chemistry_hd_file1')->extension()); 
                } 
                if ($request->hasFile('chemistry_hd_file2')) { 
                    $data['chemistry_hd_file2'] = $request->file('chemistry_hd_file2')->storeAs('images/Chemical_File', "IMG_" . carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('chemistry_hd_file2')->extension());
                }
                if ($request->hasFile('chemistry_hd_file3')) { 
                    $data['chemistry_hd_file3'] = $request->file('chemistry_hd_file3')->storeAs('images/Chemical_File', "IMG_" . carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('chemistry_hd_file3')->extension());
                }
                if ($request->hasFile('chemistry_hd_file4')) { 
                    $data['chemistry_hd_file4'] = $request->file('chemistry_hd_file4')->storeAs('images/Chemical_File', "IMG_" . carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('chemistry_hd_file4')->extension());
                }
                DB::table('chemistry_hd')
                    ->where('chemistry_hd_id',$id)
                    ->update($data);
            }else{
                $data = [
                    'chemistry_hd_calculate' => $request->chemistry_hd_calculate,
                    'chemistry_hd_note' => $request->chemistry_hd_note,
                        'chemistry_hd_type' => $request->chemistry_hd_type,
                        'chemistry_hd_save' => Auth::user()->name,
                        'update_at' => Carbon::now(),
                        'chemistry_hd_note' => $request->chemistry_hd_note,
                        'total_density' => $request->total_density,
                        'total_adjust' => $request->total_adjust,
                        'total_volume' => $request->total_volume,
                        'total_wper' => $request->total_wper,
                        'total_weght' => $request->total_weght,
                ];
                if ($request->hasFile('chemistry_hd_file1')) { 
                    $data['chemistry_hd_file1'] = $request->file('chemistry_hd_file1')->storeAs('images/Chemical_File', "IMG_" . carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('chemistry_hd_file1')->extension()); 
                } 
                if ($request->hasFile('chemistry_hd_file2')) { 
                    $data['chemistry_hd_file2'] = $request->file('chemistry_hd_file2')->storeAs('images/Chemical_File', "IMG_" . carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('chemistry_hd_file2')->extension());
                }
                if ($request->hasFile('chemistry_hd_file3')) { 
                    $data['chemistry_hd_file3'] = $request->file('chemistry_hd_file3')->storeAs('images/Chemical_File', "IMG_" . carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('chemistry_hd_file3')->extension());
                }
                if ($request->hasFile('chemistry_hd_file4')) { 
                    $data['chemistry_hd_file4'] = $request->file('chemistry_hd_file4')->storeAs('images/Chemical_File', "IMG_" . carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('chemistry_hd_file4')->extension());
                }
                DB::table('chemistry_hd')
                    ->where('chemistry_hd_id',$id)
                    ->update($data);
            }
            
            foreach ($request->chemistry_dt_id as $key => $value) {
                $pd = DB::table('chemical_lists')->where('chemical_lists_refcode',$request->code[$key])->first();
                DB::table('chemistry_dt')
                ->where('chemistry_dt_id',$value)
                ->update([
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function print($id)
    {
        $hd = DB::table('chemistry_hd')
            ->where('chemistry_hd_id',$id)
            ->first();

        $dt = DB::table('chemistry_dt')
        ->leftJoin('chemical_lists','chemistry_dt.code','=','chemical_lists.chemical_lists_refcode')
        ->leftJoin('chemical_groups','chemical_groups.chemical_groups_id','=','chemical_lists.chemical_groups_id')
        ->where('chemistry_dt.chemistry_hd_id',$id)
        ->where('chemistry_dt.flag',1)
        ->orderBy('no')
        ->select(
            'chemistry_dt.*',
            'chemical_groups.chemical_groups_name as group_name',
            'chemical_groups.chemical_groups_color as group_color'
        )
        ->get();       
        return view('chemicalsetup.form-chemistrys-print', compact('hd','dt'));
    }

    public function confirmDelChemistryDt(Request $request)
    {
        $id = $request->refid;
        try {
            DB::beginTransaction();
            DB::table('chemistry_dt')
            ->where('chemistry_dt_id',$id)
            ->update([
                'update_at' => Carbon::now(),
                'flag' => 0,
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

    public function confirmDelChemistryHd(Request $request)
    {
        $id = $request->refid;
        try {
            DB::beginTransaction();
            DB::table('chemistry_hd')
            ->where('chemistry_hd_id',$id)
            ->update([
                'update_at' => Carbon::now(),
                'chemistry_hd_flag' => 0,
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
