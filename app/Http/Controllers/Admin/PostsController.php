<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Models\Post;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param PostsDataTable $table
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  view('admin.posts.index',[
            'title' => 'المقالات',
            'posts' => Post::with('category')->with('user')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create',[
            'title'=>'إنشاء مقال',
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store()
    {
        $data = $this->validate(request(),[
            'title' => 'required',
            'status' => 'sometimes|nullable:in,publish,draft',
            'content' => 'sometimes|nullable',
            'category_id' => 'required',
        ]);
        $data['img'] = image('img');
        $data['user_id'] = auth()->id();
        return Post::with('category')->create($data)
            ? redirect(admin_url('posts'))->with('success','تم إنشاء المقال بنجاح')
            :back()->with("error","عفوا لم يتم إالانشاء بنجاح") ;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.posts.show',[
            'title' => 'عرض المقال',
            'post' => Post::with('category')->find($id)
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
        if ($post = Post::with('category')->find($id))
            return view('admin.posts.update',[
                'title' => 'تعديل المقال',
                'post' => $post,
                'categories' => Category::all()
            ]);
        return  back()->with('error','عفوا هذا المقال غير موجود');
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
        if ($post = Post::with('category')->find($id)) {
            $data = $this->validate(request(), [
                'title' => 'required',
                'status' => 'sometimes|nullable:in,publish,draft',
                'content' => 'sometimes|nullable',
                'category_id' => 'required'
            ]);
            $data['img'] = image('img',false,$post->img);
            return $post->update($data)
                ? back()->with('success', 'تم تعديل المقال بنجاح')
                : alert()->error("error", "عفوا لم يتم تعديل بنجاح");
        }
        return back()->with('error', 'هناك خطأ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return ($post = Post::find($id))
            ? $post->delete()
                ? back()->with('success', 'تم حذف المنشور')
                : back()->with('error' , 'لم يت حذف المنشور')
            : back()->with('error' ,'هناك خطأ');
    }
}
