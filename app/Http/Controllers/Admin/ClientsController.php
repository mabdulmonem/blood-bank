<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Models\Client;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        return view('admin.clients.index',[
            'title' => 'العملاء',
            'clients' => Client::with('city')->get()
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
     * @return Client|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store()
    {
        return back();
        //        $data = $this->validate(request(),[
//            'name' => 'required',
//            'phone' => 'required|numeric|unique:clients|min:11',
//            'email' => 'sometimes|required|email|unique:clients',
//            'password' => 'required|confirmed|min:6',
//            'date_of_birth' => 'sometimes|required|date|before:today',
//            'last_donation_date' => 'sometimes|required|date|before:today',
//            'status' => 'required',
//            'blood_type_id' => 'required',
//            'city_id' => 'required'
//        ]);
//        $data['password'] = Hash::make(request('password'));
//        $data['rest_code'] = rand(1000,9000);
//        $data['api_token'] = Str::random(60);
//
//        return Client::with('city')->with('bloodType')->create($data)
//            ? redirect(admin_url('clients'))->with('success','تم إنشاء العميل بنجاح')
//            : back()->with('error','عفوا هناك خطأ');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return  back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update($id)
    {
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return ($client = Client::find($id))
            ? $client->delete()
                ? back()->with('success', 'تم حذف العميل')
                : back()->with('error' , 'لم يت حذف العميل')
            : back()->with('error' ,'هناك خطأ');
    }

    public function status()
    {
        return ($client = Client::find(request('id')))
            ? $client->update(['status'=>request('status')])
                ? back()->with('success',"$client->name Has been ". ucfirst(request('status')))
                : back('error','عفوا هناك خطأ')
            : back()->with('error','عفوا هذا العميل غير موجود');
    }


}
