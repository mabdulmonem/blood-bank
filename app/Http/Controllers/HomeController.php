<?php

namespace App\Http\Controllers;

use App\Http\Models\BloodType;
use App\Http\Models\Category;
use App\Http\Models\City;
use App\Http\Models\Client;
use App\Http\Models\ClientPost;
use App\Http\Models\Contact;
use App\Http\Models\DonationRequest;
use App\Http\Models\Governorate;
use App\Http\Models\Notification;
use App\Http\Models\Post;
use App\Http\Models\Report;

class HomeController extends Controller
{
//    /**
//     * Create a new controller instance.
//     *
//     * @return void
//     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('frontend.home',[
            'title'=> 'الرئيسية',
            'posts' => Post::with('user')->with('clients')->with('category')->where('status','publish')->paginate(settings('paginate')),
            'donations' => DonationRequest::with('city')->with('client')->with('bloodType')->paginate(settings('paginate')),
            'cities' => City::with('governorate')->get(),
            'bloodTypes' => BloodType::all()
        ]);
    }

    public function posts()
    {
        return view('frontend.posts',[
            'title' => 'Articles',
            'posts'=>Post::with('category')->with('user')->paginate(settings('paginate'))
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function categories()
    {
        return view('home.categories',[
            'title' => 'التصنيفات',
            'categories' => Category::with('posts')->paginate(settings('paginate')),

        ]);
    }

    /**
     * @param $id
     * @param $title
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category($id,$title)
    {
        $category = Category::with('posts')->findOrFail($id);
        dd($category);
        return view("home.category",[
            'title' => "تصنيف [$category->name]"
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function favourites()
    {
        return view('home.favourites',[
            'title' => 'المفضالات',
            'favourites' => Client::with('posts')->findOrFail(auth()->id())
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function favourite()
    {
        if (client()->check())
            return client()->user()->posts()->toggle(request('post_id'))
                ? json('',1,'Post Saved Successfully')
                : json('', 0,'Sorry, Post Cant Save');
        else
            return json('',500,'You Should Be Signed In To Save Posts');
    }

    /**
     * @param $search
     * @return Post[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function search($search)
    {
        return Post::with('category','user')
            ->where('title','LIKE', '%{'.request('search').'}%')
            ->orWhere('content','LIKE','%{'.request('search').'}%')
            ->get();
    }

    /**
     *
     *
     * @param $id
     * @return Post|Post[]|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function post($id)
    {
        return ($post = Post::with('user')->with('category')->findOrFail($id))
            ? view('frontend.post',[
                'title' => $post->title,
                'post' => $post,
                'posts' => Post::with('category')->where('category_id','=',$post->category_id)
                    ->where('id', '!=',$id)->get()
            ])
            : back()->with('error', 'Sorry This Post Does Not Exists');
    }

    /**
     * @param $title
     * @param $id
     * @return DonationRequest|DonationRequest[]|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function donation($id)
    {
        return ($donation = DonationRequest::with('city')->with('client')->with('bloodType')->findOrFail($id))
            ? view('frontend.donation',[
                'title' => "Show [$donation->name] Donation",
                'donation' => $donation
            ])
            : back()->with('error','Sorry, This Donation Doest Exits');
    }

    /**
     *
     *
     * @return DonationRequest|DonationRequest[]|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function donations()
    {
        return view('frontend.donations',[
            'title' => 'Donation Requests',
            'donations' => DonationRequest::with('city')->with('client')->with('bloodType')->where(function ($query){

            })->paginate(settings('paginate')),
            'cities' => City::with('governorate')->get(),
            'bloodTypes' => BloodType::all()
        ]);
    }

    public function donations_sort()
    {
        return ($donations = DonationRequest::with('city')->with('client')->with('bloodType')
             ->where('blood_type_id','=',request('bloodType_id'))
             ->orWhere('city_id','=',request('city_id'))->paginate(settings('paginate')))
            ? view('frontend.donations-sort',[
                'title' => "Donations Requests",
                'donations' => $donations,
                'cities' => City::with('governorate')->get(),
                'bloodTypes' => BloodType::all()
            ])
            : back()->with('error','Sorry, This Donation Doest Exits');
    }

    public function donation_requests_create_form()
    {
        return view('frontend.donation-form',[
            'title' => 'Create Donation Request',
            'blood_types' => BloodType::all(),
            'cities' => City::with('governorate')->get()
        ]);
    }

    public function donation_requests_create_save()
    {
        $data= $this->validate(request(), [
            'name' => 'required',
            'phone' => 'required|numeric|min:11',
            'hospital_name' => 'required',
            'hospital_address' => 'required',
            'patient_age' => 'sometimes|required',
            'blood_bags_count'=> 'required',
            'details' => 'sometimes|nullable',
            'latitude' => 'sometimes|nullable',
            'longitude' =>'sometimes|nullable',
            'blood_type_id'=> 'required',
            'city_id' => 'required',
        ]);
        $data['client_id'] = client()->id();
        if ($donation = DonationRequest::create($data)){
            return Notification::create([
                'title' => 'New Donation Request',
                'donation_request_id' => $donation->id,
                'client_id' => (client()->id() || auth()->id()),
                'content' => request('name') . " Order Blood Donation "
            ])
                ? send_notification(get_notification_receivers(request('blood_type_id'),request('governorate_id')), 'New Donation Request',
                request('name') . " Order Blood Donation ", true )
                    ? redirect('/')->with('success','Message Has Sent')
                    : redirect('/')->with('error','Sorry!, Message Has Not Sent')
                : back()->with('error','You Have an error');
        }
        return back()->with('error','you have an error');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function save_report()
    {
        $data = $this->validate(request(),[
            'title' => 'sometimes|nullable',
            'content' => 'sometimes|nullable'
        ]);
        $data['client_id'] = auth()->id();
        $data['donation_request_id'] = request('donation_id');

        return Report::create($data)
            ? back()->with('success','تم إرسال شكوتك')
            : back()->with('error','عفوا يرجى المحاولة مره إخرى');
    }

    /**
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contact_form()
    {
        return view('frontend.contact-us',[
            'title' => 'Contact US',
        ]);
    }
    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function contact()
    {
        return Contact::create($this->validate(request(),[
            'name' => 'required',
            'phone'=>'required|numeric|min:11',
            'email' => 'required|email',
            'subject'=>'required',
            'message' => 'required',
        ]))
            ? back()->with('success','تم إرسال الرسالة بنجاح')
            : back()->with('error','عفوا يرجى المحاولة مره اخرى');

    }

    public function about()
    {
        return view('frontend.about-us',[
            'title'=> 'About US'
        ]);
    }

}
