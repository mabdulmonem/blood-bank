<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CategoriesDataTable;
use App\Http\Models\Category;
use App\Http\Controllers\Controller;
use foo\bar;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param CategoriesDataTable $table
     * @return void
     */
    public function index(CategoriesDataTable $table)
    {
        return $table->render('admin.categories.index',[
            'title' => 'التصنيفات'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.categories.create',[
            'title' => 'إضافة تصنيف',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     * @throws ValidationException
     */
    public function store()
    {
        return Category::create($this->validate(request(),[
            'name'=> 'required'
        ])) ? back()->with('success','تمت إضافة التصنيف بنجاح')
            : back()->with('error','عفوا هناك خطأ');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        return ($category = Category::find($id))
            ? view('admin.categories.update',[
                'title' => "تعديل تصنيف [$category->name]",
                'category' => $category
            ])
            : back()->with('error','عفوا هذا التصنيف غير موجود');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return void
     * @throws ValidationException
     */
    public function update($id)
    {
        if (($category = Category::find($id)))

            return $category->update($this->validate(request(),[
                'name'=> 'required'
            ])) ? back()->with('success','تم تعديل التصنيف بنجاح')
                : back()->with('error','عفوا هناك خطأ');
        return back()->with('error','عفوا هذا التصنيف غير موجود');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        return ($category = Category::find($id))
            ? $category->delete()
                ? back()->with('success','تم الحذف بنجاح')
                : back()->with('error','عفوا هناك خطأ')
            : back()->with('error','عفوا هذا التصنيف غير موجود');
    }
}
