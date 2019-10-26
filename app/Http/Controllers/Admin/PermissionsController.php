<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PermissionsDataTable;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PermissionsDataTable $table)
    {
        return $table->render('admin.users.permissions.index',[
            'title' => 'دور المشرفين'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return back();
//        return view('admin.users.permissions.create',[
//            'title' => 'إضافة دور المشرفين'
//        ]);
    }

    public function store()
    {
        return back();
//        $data = $this->validate(request(),[
//            'name' => 'required|unique:roles'
//        ]);
//
//        if (strpos(request('permission'), ',') !== false){
//            $role = Role::create($data);
//            foreach (explode(',', rtrim(request('permission'))) as $permission){
//                $per = Permission::create(['name' => $permission]);
//                $role->givePermissionTo($per);
//                $per->assignRole($role);
//            }
//        } else{
//            $per = Permission::create(['name' => request('permission')]);
//            $role = Role::create($data);
//            $role->givePermissionTo($per);
//            $per->assignRole($role);
//        }
//        return redirect(admin_url('permissions'))->with('success', 'تم إنشاء الصلاحية بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($role = Role::with('permissions')->find($id)){
            return view('admin.users.permissions.update',[
                'title' => " تعديل دور [$role->name]",
                'role' => $role
            ]);
        }
        return back()->with('error','عفوا هذا الدور غير موجود');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        if ($role = Role::find($id)){
            $data = $this->validate(request(),[
                'name' => 'required|unique:roles,name,'.$id
            ]);
            foreach (request('permissions') as $permission){
                $role->givePermissionTo($permission);
                $permission->assignRole($role->name);
            }
            $role->update($data);
            return back()->with('success', 'تم تحديث الدور المشرفين بنجاح');
        }
        return back()->with('error','عفوا هذا الدور غير موجود');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($role = Role::find($id)){
            return $role->delete()
                ? back()->with('success', 'تم حذف الدور المشرفين بنجاح')
                : back()->with('error','عفوا هناك خطأ');
        }
        return back()->with('error','عفوا هذا الدور غير موجود');
    }

    public function permission_form($id)
    {
        if ($per = Permission::findById($id)){
            return view('admin.users.permissions.permission',[
                'title' => " تعديل صلاحية [$per->name]",
                'per' => $per
            ]);
        }
        return back()->with('error','عفوا هذا الصلاحية غير موجود');
    }

    public function permission($id)
    {
        if ($per = Permission::findById($id)){
            return $per->update($this->validate(request(),[
                'name' => 'required'
            ]))
                ? back()->with('success','تم تحديث الصلاحية بنجاح')
                : back()->with('error','عفوا هناك خطأء');
        }
        return back()->with('error','عفوا هذا الصلاحية غير موجود');
    }
}
