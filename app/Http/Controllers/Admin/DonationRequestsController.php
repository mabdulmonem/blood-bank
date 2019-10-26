<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\DonationRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class DonationRequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.donation-requests.index',[
            'title' => 'طلبات التبرع',
            'donations' => DonationRequest::with(['bloodType','city'])->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     * @throws ValidationException
     */
    public function store()
    {
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return ($donation = DonationRequest::with('city')->with('client')->with('bloodType')->find($id))
            ? view('admin.donation-requests.show',[
                'title' => "عرض طلب [$donation->name]",
                'donation' => $donation
            ])
            : back()->with('error','عفوا هذا الطلب غير موجود');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return Response
     * @throws ValidationException
     */
    public function update($id)
    {
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        return ($donation = DonationRequest::find($id))
            ? $donation->delete()
                ? back()->with('success','تم حذف الطلب بنجاح')
                : back()->with('error','عفوا هناك خطأ')
            : back()->with('error','عفوا هذا الطلب غير موجود');
    }
}
