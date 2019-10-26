<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\City;
use App\Http\Models\Governorate;

class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param CitiesDataTable $table
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.cities.index',[
            'title' => 'المدن',
            'cities' => City::with('governorate')->get()
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
        if ($city = City::with('governorate')->find($id)){
            return view('admin.cities.update',[
                'title' => "تعديل مدينة [$city->name]",
                'city' => $city,
                'governorates' => Governorate::all()
            ]);
        }
        return back()->with('error','عفوا هذة المدينة غير موجودة');
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
        if ($city = City::with('governorate')->find($id)){
            $data = $this->validate(request(),[
                'name' => 'required',
                'governorate_id' => 'required'
            ]);
            return $city->update($data)
                ? back()->with('success','تم تحديث المدينة')
                : back()->with('error','هناك خطأ');
        }
        return back()->with('error','عفوا هذة المدينة غير موجودة');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        if ($city = City::with('governorate')->find($id)){
            return $city->delete()
                ? back()->with('success','تم حذف المدينة')
                : back()->with('error','هناك خطأ');
        }
        return back()->with('error','عفوا هذة المدينة غير موجودة');
    }

    public function cities()
    {
        if (request()->ajax()){
            return ( $cities = Governorate::with('cities')->find(request('id'))  )
                ? json($cities->cities,1,'تم جلب البيانات بنجاح')
                : json('',0,'هذا الدور لايملك صلاحيات');
        }
        return json('',0,"عفوا هناك خطأ");
    }
}
