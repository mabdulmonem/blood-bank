<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\GovernoratesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Models\Governorate;
use foo\bar;

class GovernoratesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param GovernoratesDataTable $table
     * @return \Illuminate\Http\Response
     */
    public function index(GovernoratesDataTable $table)
    {
        return $table->render('admin.governorates.index',[
            'title' => 'المحافظات'
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
        if ($governorate = Governorate::find($id))
            return view('admin.governorates.update',[
                'title' => "تعديل محافظة [$governorate->name]",
                'governorate' => $governorate
            ]);
        return back()->with('error','عفوا هذه المحافظة غير موجودة');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return void
     */
    public function update( $id)
    {
        if ($governorate = Governorate::find($id)){
            $data = $this->validate(request(),[
                'name' => 'required'
            ]);
            return $governorate->update($data)
                ? back()->with('success', 'تم تحديث المحافظة بنجاح')
                : back()->with('error','عفوا هناك خطأ');
        }
        return back()->with('error','عفوا هذه المحافظة غير موجود');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($governorate = Governorate::find($id))
            return $governorate->delete()
                ? back()->with('success','تم حذف المحافظة بنجاح')
                : back()->with('error','عفوا هناك خطأ');
        return back()->with('error','عفوا هذه المحافظة غير موجود');
    }
}
