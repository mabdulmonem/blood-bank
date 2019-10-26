<?php

namespace App\Http\Controllers\Api;

use App\Http\Models\BloodType;
use App\Http\Models\BloodTypeClient;
use App\Http\Models\Category;
use App\Http\Models\City;
use App\Http\Models\Client;
use App\Http\Models\ClientGovernorate;
use App\Http\Models\Contact;
use App\Http\Models\DonationRequest;
use App\Http\Models\Governorate;
use App\Http\Controllers\Controller;
use App\Http\Models\Notification;
use App\Http\Models\Post;
use App\Http\Models\Setting;
use LaravelFCM\Message\Exceptions\InvalidOptionsException;
use function GuzzleHttp\Promise\all;

class MainController extends Controller
{
    /**
     * get All [posts] with [category]
     * search by [category] & [title] & [content]
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function posts()
    {
        $validator = validator()->make(request()->all(),[
           'search' => 'sometimes|required'
        ]);

        $posts = Post::with('category')->with('clients')
            ->where(function ($query){
                /**
                 * search in [title] and [content]
                 */
                if (request()->has('search'))
                    $query->where('title','LIKE','%{'.request('search').'}%')
                        ->orWhere('content','LIKE','%{'.request('search').'}%')->get();
                /**
                 * get single post if has param [post_id]
                 */
                if (request()->has('post_id'))
                    $query->find(request('post_id'));
            })->paginate(10);
        return $posts->isNotEmpty()
            ? json($posts,1)
            : json("عفوا لايوجد مقالات",0);
    }

    /**
     * get All [categories] with [posts]
     *
     * @return Category[]|\Illuminate\Database\Eloquent\Collection
     */
    public function categories()
    {
        return Category::all()->isNotEmpty()
            ? json(Category::with('posts')->get())
            :json('عفوا لايوجد تصنيفات',0);
    }

    /**
     * get all [governorates]
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function governorates()
    {
        return Governorate::all()->isNotEmpty()
            ? json(Governorate::with('cities')->where(function ($query){
                if (request()->has('id'))
                    $query->find(request('id'));
            })->get(),1)
            : json('عفوا لايوجد بيانات',0);
    }

    /**
     * get all [cities]
     * get cities linked with governorates
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function cities()
    {
        return City::all()->isNotEmpty()
            ? json(City::with('governorate')->where(function ($query){
                if (request()->has('governorate_id'))
                    $query->where('governorate_id',request('governorate_id'));
                if (request('id'))
                    $query->find(request('id'));
            })->get(),1)

            : json('عفوا لايوجد بيانات',0);
    }



    /**
     * get all [blood types]
     * get single [blood type] by [blood_type_id] input
     * search in blood types by [name]
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function blood_types()
    {
        return BloodType::all()->isNotEmpty()
            ? json(BloodType::where(function ($query){
                /**
                 * get [blood type ] by [id]
                 */
                if (request()->has('blood_type_id'))
                    $query->where('id',request('blood_type_id'));
                /**
                 * search in [blood Types]
                 */
                if (request()->has('search'))
                    $query->where('name','LIKE', '%{'.request('search') .'}%');

            })->get(), 1)
            : json('عفوا لايوجد بيانات',0);
    }

    /**
     * get donation requests
     * get single donation request by [donation_request_id]
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function donation_requests()
    {
        return DonationRequest::all()->isNotEmpty()
            ? json(DonationRequest::with('city')
                ->with('client')->with('bloodType')->where(function ($query){
                    /**
                     * get donation request by [id]
                     */
                    if (request()->has('donation_request_id'))
                        $query->where('id',request('donation_request_id'));
                })->paginate(10))
            : json('',0,'عفوا لايوجد طالبات تبرع حاليا');
    }

    /**
     * create new [donation request]
     * send notification with firebase
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function creat_donation_request()
    {
        $validator = validator()->make(request()->all(), [
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
            'client_id'=>'required'
        ]);

        if (!$validator->fails()) {
            if ($donation = DonationRequest::create(request()->all())){
                return Notification::create([
                    'title' => 'New Donation Request',
                    'donation_request_id' => $donation->id,
                    'client_id' => request('client_id'),
                    'content' => request('name') . " Order Blood Donation "
                ])
                    ? send_notification(get_notification_receivers(request('blood_type_id'),request('governorate_id')), 'New Donation Request', request('name') . " Order Blood Donation ", true )
                        ? json(['donation_created' => $donation],1,'Message Has Sent')
                        : json(['donation_created' => $donation],1,'Sorry!, Message Has Not Sent')
                    : json(['donation_created' => $donation],1,'You Have an error');
            }
            return  json(null,0,'Sorry! Donations Does Not Created');
        }
        return json($validator->errors(),0);
    }
    /**
     * save all mails come from clients
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function contact()
    {
        $validator = validator()->make(request()->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric|min:11',
            'subject' => 'required',
            'message' => 'required'
        ]);
        if (!$validator->fails()){
            return json(Contact::create(request()->all()),1,"تم إرسال الرسالة بنجاح");
        }
        return json($validator->errors(),0);
    }

    /**
     * get Notification [Settings] by [api_token]
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_notification_settings()
    {
        return json(Client::with(['bloodTypes','governorates'])
            ->where('api_token',request('api_token'))->get(),1);
    }

    /**
     * THIS METHOD NEED SOME FIX
     * update Notification [Settings] by [api_token]
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update_notification_settings()
    {
        $validator = validator(request()->all(),[
            'client_id' => 'sometimes|required',
            'governorate_id' => 'required',
            'blood_type_id' => 'required'
        ]);
        if (!$validator->fails()) {
            $client = Client::with(['bloodTypes','governorates'])->find(request('client_id'));
           if ( $client->bloodTypes()->toggle(request('blood_type_id')) || $client->governorates()->toggle(request('governorate_id')))
               return json(['blood_types' => $client->bloodTypes()->get(),'governorates' => $client->governorates()->get()],1,'تم الحفظ بنجاح');
        }
        return json($validator->errors(),0);
    }

    /**
     * get application [settings]
     *
     * @return mixed
     */
    public function settings()
    {
        return Setting::orderBy('id','DESC')->first();
    }
}
