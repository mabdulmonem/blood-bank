<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.settings.main',[
            'title' => 'الأعدادت الرئيسية'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function save()
    {
        $data = $this->validate(request(),[
            'site_name' => 'required',
            'logo' => 'sometimes|nullable',
            'icon' => 'sometimes|nullable',
            'email' => 'sometimes|nullable|email',
            'phone' => 'sometimes|nullable|numeric',
            'description' => 'sometimes|nullable',
            'keywords' => 'sometimes|nullable',
            'status' => 'required|in:open,close',
            'notification_settings_text' =>  'sometimes|nullable',
            'paginate' => 'integer',
            'android_app_link' => 'sometimes|nullable',
            'ios_app_link' => 'sometimes|nullable'
        ]);
        $data['icon'] = image('icon',false,settings('icon'));
        $data['logo'] = image('logo',false,settings('logo'));
        return settings(false,true,$data)
            ? back()->with('success','تم تحديث الأعدادت بنجاح')
            : back()->with('error','عفوا هناك خطأ');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function social_media()
    {
        return view('admin.settings.social-media',[
            'title' => 'إعدادت وسائل التواصل الاجتماعى'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function save_social_media()
    {
        $data = $this->validate(request(),[
            'fb' => 'sometimes|nullable',
            'tw'=> 'sometimes|nullable',
            'youtube'=> 'sometimes|nullable',
            'in'=> 'sometimes|nullable',
            'whats_app'=> 'sometimes|nullable',
        ]);
        return settings(false,true,$data)
            ? back()->with('success','تم تحديث الأعدادت بنجاح')
            : back()->with('error','عفوا هناك خطأ');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return  back();
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
        return  back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return  back();
    }
}
