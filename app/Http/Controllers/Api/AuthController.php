<?php

namespace App\Http\Controllers\Api;

use App\Http\Models\BloodTypeClient;
use App\Http\Models\Client;
use App\Http\Controllers\Controller;
use App\Http\Models\ClientGovernorate;
use App\Http\Models\ClientNotification;
use App\Http\Models\ClientPost;
use App\Http\Models\Contact;
use App\Http\Models\Notification;
use App\Http\Models\Setting;
use App\Http\Models\Token;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * create new user
     * send [sms] message to phone
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register()
    {
        $validator = validator()->make(request()->all(),[
            'name' => 'required',
            'phone' => 'required|min:11|numeric|unique:clients',
            'email'  => 'required|email|unique:clients',
            'password' => 'required|confirmed|min:6',
            'date_of_birth' => 'required|date|before:today',
            'last_donation_date' => 'required|date|before:today',
            'blood_type_id' => 'required',
            'city_id' => 'required'
        ]);
        if (!$validator->fails()){
            request()->merge(['password'=>bcrypt(request('password')), 'rest_code' => rand(1000,9000)  ]);
            $client = Client::create(request()->all());
            $client->api_token = Str::random(60);
            $client->save();
            nexmo(request('phone'),'(' . $client->rest_code . ') كود تفعيل حسابك');
            return json($client,1);
        }
        return json($validator->errors(),0);
    }

    /**
     * auth [user]
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $validator = validator()->make(request()->all(),[
            'phone' => 'required|min:11|numeric',
            'password' => 'required|min:6',
        ]);
        if (!$validator->fails()){
            $client = Client::with('bloodType')->with('city')->where('phone',request('phone'))->first();
            if ($client){
                if (!Hash::check(request("password"),$client->password) )
                    return  json("password is invalid",0);
                else{
                    return  client()->attempt(['phone' => request('phone'), 'password' => request('password')],request()->has('remember') ? true :false)
                        ? json(['api_token'=> $client->api_token, 'client' => $client],1)
                        : json(null,0,'username or password not match');
                }
            }
            return json("no user found",0);
        }
        return json($validator->errors(),0);
    }

    /**
     * send [sms] message to validate client
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function rest_password()
    {
        $validator = validator()->make(request()->all(),[
            'phone' => 'required|min:11|numeric'
        ]);

        if (!$validator->fails()){
            $client = Client::where("phone",request('phone'))->first();
            return ($client) ? json(nexmo(request('phone'),'(' . $client->rest_code . ') كود استرداد كلمة المرور'))
                : json("عفوا هذا الحساب غير موجود",0);
        }
        return json($validator->errors(),0);
    }

    /**
     * set new [password]
     * create new [rest code]
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function new_password()
    {
        $validator = validator()->make(request()->all(),[
            'rest_code' => 'required|min:4|numeric',
            'password' => 'required|confirmed|min:6',
        ]);
        if (!$validator->fails()){
            $client = Client::where('rest_code', request('rest_code'))->first();
            if ($client)
                return $client->update(['password'=> Hash::make(request("password")),'rest_code'=>rand(1000,9000)])
                    ? json("تم تغير كلمة المرر بنجاح", 1)
                    : json("عفوا هناك خطاز حاول مرة اخرى", 0);
            return json("عفوا كود التحقق غير صحيح",0);
        }
        return json($validator->errors(),0);
    }

    /**
     * send [sms] message to verify client account
     * make account verified
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify_account()
    {
        $validator = validator()->make(request()->all(),[
            'rest_code' => 'required|min:4|numeric'
        ]);
        if (!$validator->fails()){
            $client = Client::where("rest_code",request("rest_code"))->first();
            if ($client)
                return $client->update(['is_verified' => 1]) ? json("تم تاكيد حسابك بنجاح",1) : json("عفوا هناك خطأ", 0);
            return json("عفوا كود التأكيد خاطئ",0);
        }
        return json($validator->errors(),0);
    }

    /**
     * get client data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        return Client::with(['city','bloodType'])->find(request('id'))
            ? json(Client::with('bloodType')->with('city')->first(), 1 )
            : json("عفوا هذا المستخدم غير موجدو",0);
    }


    /**
     * allow client to [edit] his [profile]
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit_profile()
    {
        $validator = validator()->make(request()->all(),[
            'id' => 'required|integer|gt:0',
            'name' => 'required',
            'phone' => 'required|min:11|numeric|unique:clients,phone,' . request('id'),
            'email'  => 'required|email|unique:clients,email,' . request('id'),
            'password' => 'required|confirmed|min:6',
            'date_of_birth' => 'required|date|before:today',
            'last_donation_date' => 'required|date|before:today',
            'blood_type_id' => 'required',
            'city_id' => 'required'
        ]);
        if (!$validator->fails()) {
            $client = Client::find(request('id'));
            request()->merge(['password'=>Hash::make(request('password'))]);
            if ($client)
                return $client->update(request()->all()) ? json("تم تحديث بيانتك بنجاح",1)  : json('عفوا هناك خطأ');

            return json("هذا المستخدم غير موجود",0);
        }
        return json($validator->errors(),0);
    }

    /**
     * create new [token] for devices
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function new_token()
    {
        $validator = validator()->make(request()->all(),[
            'token' => 'required',
            'os' => 'required|in:ios,android'
        ]);
        if (! $validator->fails()){
            Token::where('token',request('token'))->delete();
            return json(request()->user()->tokens()->create(request()->all()),1);
        }
        return json($validator->errors(), 0, 'تم التسجيل بنجاح');
    }

    /**
     * Delete Token By [token]
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete_token()
    {
        $validator = validator()->make(request()->all(),[
            'token' => 'required',
        ]);
        return (! $validator->fails())
            ? json(Token::where('token',request('token'))->delete(),1,'تم حذف Token')
            :json($validator->errors(), 0, 'تم التسجيل بنجاح');
    }


    /**
     * get notifications
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function notifications()
    {
        $notification = Notification::with('donationRequest')->with('clients');
        return $notification->count() ?  json($notification->paginate(10), 1)
            : json('عفوا لايوجد اشعارات',0);
    }

    /**
     * get [favourites  Posts] by auth [client]
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function favourites()
    {
        $favourites = Client::with('posts')->find(request('client_id'));
        return $favourites->posts->count()
            ? json($favourites->paginate(10),1)
            : json('عفوا لايوجد منشورات مفضلة',0);
    }

    /**
     * get [favourites  Posts] by auth [client]
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggle_favourites()
    {
        $posts = Client::with('posts')->where('api_token',request('api_token'))->first()->posts();
        if ( $posts->toggle(request('post_id')) )
             return  json($posts->get(),1);
    }



}
