<?php

namespace App\Http\Controllers\Admin;


use App\Http\Models\Report;
use App\Mail\Replay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.reports.index',[
            'title' => 'كل البلاغات',
            'reports' =>Report::with(['donationRequest','client'])->get()
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
    public function store(Request $request)
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
        return ($report = Report::with('client')->with('donationRequest')->find($id))
            ? view('admin.reports.show',[
                'title' => "عرض بلاغ [" . $report->client->name ."]",
                'report' => $report,
                'quantity' => count($report->all())
            ])
            : back()->with('error', 'فوا هذا البلاغ غير موجود') ;
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function replay($id)
    {
        return ($report = Report::with('client')->with('donationRequest')->find($id))
            ? view('admin.reports.replay',[
                'title' => "الرد على بلاغ [" . $report->client->name ."]",
                'report' => $report
            ])
            : back()->with('error', 'فوا هذا البلاغ غير موجود') ;
    }

    public function replay_save($id)
    {
        if ($report = Report::with('client')->with('donationRequest')->find($id)){
            $data = $this->validate(request(),[
                'subject' => 'required',
                'message' => ' required'
            ]);
            $data['report'] = $report;
            Mail::to($report->client->email)->send(new Replay($data));
            return redirect(admin_url("reports/$report->id"))->with('success' , 'تم إسال الرسالة');
        }
        return redirect(admin_url("reports/$report->id"))->with('error','هناك خطأ');
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
        return ($report = Report::find($id))
            ? $report->delete()
                ? back()->with('success','تم حذف الإبلاغ بنجاح')
                : back()->with('error','عفوا هناك خطأ')
            : back()->with('error','عفوا هذه الشكوى غير موجود');
    }
}
