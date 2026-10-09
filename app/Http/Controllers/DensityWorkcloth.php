<?php

namespace App\Http\Controllers;

use App\Models\DensityWorkclothDt;
use App\Models\DensityWorkclothHd;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DensityWorkcloth extends Controller
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
        $hd = DensityWorkclothHd::where('density_workcloth_hds_flag',true)->get();
        return view('chemicalsetup.form-density-workcloth-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pd = DB::table('ms_edf_moldlist')
                ->select('product_code', 'product_name')
                ->where('product_code','LIKE','001-%')
                ->groupBy('product_code', 'product_name')
                ->get();
        $formule = DB::table('ms_formule')->get();
        return view('chemicalsetup.form-density-workcloth-create', compact('pd','formule'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         // Validate ข้อมูลเบื้องต้นตามความเหมาะสม
        $request->validate([
            'product_code' => 'required|not_in:-',
            'mlod_code' => 'required|not_in:-',
            'ms_formule_name' => 'required|not_in:-',
            'chemistry_hd_name' => 'required|not_in:-',
        ]);

        // ใช้ Database Transaction เพื่อความปลอดภัย หากเกิดข้อผิดพลาดจะ Rollback ทั้งหมด
        DB::beginTransaction();
        try {
            // ค้นหาชื่อ Product และ Mold เพิ่มเติมถ้าจำเป็น (หรือดึงจาก Request / Ajax)
            $product = DB::table('ms_edf_moldlist')->where('product_code', $request->product_code)->first();
            $mold = DB::table('ms_edf_moldlist')->where('mlod_code', $request->mlod_code)->first();
            $data = [
                'product_code'                 => $request->product_code,
                'product_name'                 => $product ? $product->product_name : null, // ปรับตามฟิลด์จริง
                'mlod_code'                    => $request->mlod_code,
                'mlod_name'                    => $mold ? $mold->mlod_name : null,         // ปรับตามฟิลด์จริง
                'mlod_cavity'                  => $request->mlod_cavity,
                'mlod_area'                    => $request->mlod_area,
                'mlod_pressure'                => $request->mlod_pressure,
                'density_workcloth_hds_flag'   => 1, // ค่าเริ่มต้นหรือสถานะ (ปรับเปลี่ยนได้ตามระบบของคุณ)
                'person_at'                    => auth()->user()->name ?? 'System', // หรือใช้ ID ผู้ใช้งาน
                'chemical_weight'              => $request->chemical_weight,
                'chemical_temp'                => $request->chemical_temp,
                'ms_formule_name'              => $request->ms_formule_name,
                'chemistry_hd_name'            => $request->chemistry_hd_name,
                'total_density'                => $request->total_density,
                'product_sides'                => '-',
                'created_at'                   => Carbon::now(), 
                'updated_at'                   => Carbon::now(),
                'density_workcloth_hds_date'   => $request->density_workcloth_hds_date,
                'machinery_name'               => $request->machinery_name,
                'mlod_volume'                  => $request->mlod_volume,
                'density_workcloth_hds_note'   => $request->density_workcloth_hds_note
            ];
            if ($request->hasFile('density_workcloth_hds_file1')) {
                $data['density_workcloth_hds_file1'] = $request->file('density_workcloth_hds_file1')->storeAs('images/DensityWorkpiece_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('density_workcloth_hds_file1')->extension());
            }
            if ($request->hasFile('density_workcloth_hds_file2')) {
                $data['density_workcloth_hds_file2'] = $request->file('density_workcloth_hds_file2')->storeAs('images/DensityWorkpiece_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('density_workcloth_hds_file2')->extension());
            }
            if ($request->hasFile('density_workcloth_hds_file3')) {
                $data['density_workcloth_hds_file3'] = $request->file('density_workcloth_hds_file3')->storeAs('images/DensityWorkpiece_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('density_workcloth_hds_file3')->extension());
            }
            if ($request->hasFile('density_workcloth_hds_file4')) {
                $data['density_workcloth_hds_file4'] = $request->file('density_workcloth_hds_file4')->storeAs('images/DensityWorkpiece_File', "IMG_" . Carbon::now()->format('Ymdhis') . "_" . Str::random(5) . "." . $request->file('density_workcloth_hds_file4')->extension());
            }
            // 1. บันทึกข้อมูล Header (density_workpiece_hds)
            $header = DensityWorkclothHd::create($data);

            // 2. บันทึกข้อมูล Detail (density_workpiece_dts) ตามจำนวน Cavity ที่ส่งมาเป็น Array
            if ($request->has('cavity') && is_array($request->cavity)) {
                foreach ($request->cavity as $index => $item) {
                    DensityWorkclothDt::create([
                        'density_workcloth_hds_id'      => $header->density_workcloth_hds_id,
                        'density_workcloth_dts_listno'  => $index, // ลำดับที่ (1, 2, 3, ...)
                        'weight_1'                      => $item['weight_1'] ?? 0,
                        'thickness_1'                   => $item['thickness_1'] ?? 0,
                        'thickness_2'                   => $item['thickness_2'] ?? 0,
                        'thickness_3'                   => $item['thickness_3'] ?? 0,
                        'thickness_4'                   => $item['thickness_4'] ?? 0,
                        'thickness_5'                   => $item['thickness_5'] ?? 0,
                        'thickness_6'                   => $item['thickness_6'] ?? 0,
                        'thickness_chemical'            => $item['thickness_chemical'] ?? 0,
                        'volume'                        => $item['volume'] ?? 0,
                        'density'                       => $item['density'] ?? 0,
                        'porosity'                      => $item['porosity'] ?? 0,
                        'created_at'                    => Carbon::now(), 
                        'updated_at'                    => Carbon::now(),
                    ]);
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'บันทึกข้อมูลความหนาแน่นของชิ้นงานเรียบร้อยแล้ว');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' . $e->getMessage())->withInput();
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
        $hd = DensityWorkclothHd::find($id);
        $dt = DensityWorkclothDt::where('density_workcloth_hds_id',$id)->get();
        return view('chemicalsetup.form-density-workcloth-edit', compact('hd','dt'));
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
        DB::beginTransaction();
        try {
            $hd = DensityWorkclothHd::findOrFail($id);
            if ($request->has('cavity') && is_array($request->cavity)) {
                foreach ($request->cavity as $listno => $item) {
                    DensityWorkclothDt::updateOrCreate(
                        [
                            'density_workcloth_hds_id'     => $hd->density_workcloth_hds_id,
                            'density_workcloth_dts_listno' => $listno,
                        ],
                        [
                            'weight_1'                      => $item['weight_1'] ?? 0,
                            'thickness_1'                   => $item['thickness_1'] ?? 0,
                            'thickness_2'                   => $item['thickness_2'] ?? 0,
                            'thickness_3'                   => $item['thickness_3'] ?? 0,
                            'thickness_4'                   => $item['thickness_4'] ?? 0,
                            'thickness_5'                   => $item['thickness_5'] ?? 0,
                            'thickness_6'                   => $item['thickness_6'] ?? 0,
                            'thickness_chemical'            => $item['thickness_chemical'] ?? 0,
                            'volume'                        => $item['volume'] ?? 0,
                            'density'                       => $item['density'] ?? 0,
                            'porosity'                      => $item['porosity'] ?? 0,
                        ]
                    );
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'อัปเดตข้อมูลความหนาแน่นของชิ้นงานเรียบร้อยแล้ว');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาดในการอัปเดตข้อมูล: ' . $e->getMessage())->withInput();
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
    public function confirmDelDensityWorkcloth(Request $request)
    {
        $id = $request->refid;
        try {
            DB::beginTransaction();
            DB::table('density_workcloth_hds')
            ->where('density_workcloth_hds_id',$id)
            ->update([
                'updated_at' => Carbon::now(),
                'density_workcloth_hds_flag' => 0,
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
