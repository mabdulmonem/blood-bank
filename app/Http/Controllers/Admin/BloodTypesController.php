<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BloodTypesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Models\BloodType;
use foo\bar;

class BloodTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param BloodTypesDataTable $table
     * @return \Illuminate\Http\Response
     */
    public function index(BloodTypesDataTable $table)
    {
        return $table->render('admin.blood-types.index',[
            'title' => 'فصائل الدم'
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        return back();
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
        return ($blood_type = BloodType::find($id))
            ? view('admin.blood-types.update',[
                'title' => "تعديل فصيلة [$blood_type->name]",
                'blood_type' => $blood_type
                ])
            : back()->with('error','عفوا هذة الفصيلة غير موجودة');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update($id)
    {
        if ($blood_types = BloodType::find($id)){
            $data = $this->validate(request(),[
                'name' => 'required'
            ]);

            return $blood_types->update($data)
                ? back()->with('success','تم تحديث بنجاح')
                : back()->with('error','عفوا لم يتم التحديث بنجاح');
        }
        return  back()->with('error','عفوا هذه الفصيلة غير موجودة');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($blood_types = BloodType::find($id))
            return $blood_types->delete()
                ? back()->with('success','تم حذف الفصيلة بنجاح')
                : back()->with('error','عفوا لم يتم حذف الفصيلة');
        return back()->with('error','عفوا هذه الفصيلة غير موجودة');
    }
}
