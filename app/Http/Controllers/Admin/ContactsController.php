<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ContactsMessagesDataTable;
use App\Http\Models\Contact;
use App\Http\Controllers\Controller;
use App\Mail\Replay;
use foo\bar;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ContactsMessagesDataTable $table
     * @return Response
     */
    public function index(ContactsMessagesDataTable $table)
    {
        return $table->render('admin.contact-messages.index',[
            'title' => 'الرسائل البريدية'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return  back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function store()
    {
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function replay($id)
    {
        return ($mail = Contact::find($id))
            ? view('admin.contact-messages.replay',[
                'title' => "الرد على [$mail->name]",
                'mail' => $mail
            ])
            : back()->with('error','عفوا هناك خطأ');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function replay_save()
    {
        if ($receiver = Contact::find(request('receiver'))){
            $data = $this->validate(request(),[
                'subject' => 'required',
                'message' => ' required'
            ]);
            $data['receiver'] = $receiver;
            Mail::to($receiver->email)->send(new Replay($data));
            return redirect(admin_url("contact-messages/$receiver->id"))->with('success' , 'تم إسال الرسالة');
        }
        return redirect(admin_url("contact-messages/$receiver->id"))->with('error','هناك خطأ');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return ($mail = Contact::find($id))
            ? view('admin.contact-messages.show',[
                'title' => "قراءة بريد [$mail->subject]",
                'mail'=> $mail,
                'quantity' => count($mail->all())
            ])
            : back()->with('عفوا هذه الرسالة غير موجودة');
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
     * @return void
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
        return ($mail = Contact::find($id))
            ? $mail->delete()
                ? back()->with('success','تم الحذف بنجاح')
                : back()->with('error', 'عفوا هناك خطأ')
            : back()->with('error','عفوا هذه الرسالة غير موجودة');
    }
}
