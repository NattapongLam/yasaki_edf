<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ProfilesController extends Controller
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
        $hd = DB::table('users')->get();
        return view('profiles.form-profiles-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hd = null;
        return view('profiles.form-profiles-create', compact('hd'));
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
            'username' => [
                'required',
                'unique:users,username',
            ],
            'name' => ['required'],
            'password' => ['required'],
        ]);
        try{
            DB::beginTransaction();
                $hd = DB::table('users')->insert([
                    'name' => $request->name,
                    'password' => Hash::make($request->password),
                    'username' => $request->username,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'flag' => 1
                ]);
            DB::commit();
            return redirect()->route('profiles.create')->with('success', 'บันทึกข้อมูลเรียบร้อย');
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
        $emp = User::where('id',$id)->first();
        return view('profile',[
            'emp' => $emp,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = User::where('id',$id)->first();
        $roles = Role::all();
        $permissions = Permission::leftjoin('ms_permissions','permissions.name','=','ms_permissions.ms_permissions_code')->get();
        return view('profiles.form-profiles-edit', compact('users','permissions','roles'));
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
            'password_confirmation' => ['required'],
            'password' => ['required']
        ]);
        $data =[
            'password' => Hash::make($request->password),
        ];
        $emp = User::where('id',$id)->first();
        try {
            DB::beginTransaction();
            User::where('id', $id)->update($data);
            DB::commit();
            Auth::logout();
            return redirect('/')->with('success', 'เปลี่ยนรหัสผ่านสำเร็จ กรุณาเข้าสู่ระบบใหม่');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'แก้ไขข้อมูลไม่สำเร็จ: ' . $e->getMessage());
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

    public function confirmDelProfile(Request $request)
    {
        $id = $request->refid;
        try {
            DB::beginTransaction();
            User::where('id', $id)
            ->update([
                'updated_at' => Carbon::now(),
                'flag' => 0
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
    
    public function updateRolePermission(Request $request, $id)
    {
        $request->validate([
            'role' => ['required'],
        ]);

        $users = User::findOrFail($id);
        $role = Role::where('name', $request->role)->firstOrFail();

        try {
            DB::beginTransaction();
            
            // อัปเดต Role
            $users->syncRoles($role->name);

            // อัปเดต Permission
            if (is_array($request->permission) && count($request->permission)) {
                $permissions = Permission::whereIn('id', $request->permission)->pluck('name')->toArray();
                $users->syncPermissions($permissions);
            } else {
                $users->syncPermissions([]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'บันทึกข้อมูลสิทธิ์สำเร็จ');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'บันทึกข้อมูลสิทธิ์ไม่สำเร็จ: ' . $e->getMessage());          
        }
    }
}
