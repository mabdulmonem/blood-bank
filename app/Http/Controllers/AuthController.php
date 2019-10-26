<?php

namespace App\Http\Controllers;

use App\Http\Models\BloodType;
use App\Http\Models\City;
use App\Http\Models\Client;
use App\Http\Models\Governorate;
use App\Mail\PasswordUpdated;
use App\Mail\RestPassword;
use App\Mail\VerifyClient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    public function profile($id)
    {
        return (Client::findOrFail($id) && (client()->check() or auth()->check()) && $id == client()->id())
            ? view('frontend.auth.profile',[
                'title'     => '',
                'blood_types' => BloodType::where('id','!=',client()->user()->blood_type_id),
                'cities'   => City::where('id','!=',client()->user()->city_id)
            ])
            :redirect('/')->with('error','Sorry! This link Is Not Valid');
    }

    public function profile_save($id)
    {
        if (client()->check() && $client = Client::findOrFail($id)){
            $data = $this->validate(request(),[
                'name' => 'required',
                'phone' => 'required|numeric|min:11|unique:clients,phone,'.$id,
                'email' => 'required|email|unique:clients,email,'.$id,
                'date_of_birth' => 'required|date|before:today',
                'city_id' => 'required',
                'blood_type_id' => 'required',
                'last_donation_date' => 'required|date',
                'password' => 'required|confirmed|min:6'
            ]);

            $data['password'] = request('password') !== null ? Hash::make(request('password')) : $client->password;

            return ($client->update($data))
                ? redirect('/')->with('success','Your Account has been Updated')
                : back()->with('error','Sorry, You have An error');
        }
        return back();
    }

    public function login_form()
    {
        if (!client()->check())
            return view('frontend.auth.login',[
                'title' => 'Login'
            ]);
        return back();
    }

    public function login()
    {
        if (!client()->check())
        {
            return client()->attempt([
                'phone'=>request('phone'),
                'password'=>request('password')
            ],request()->has('remember') ? true :false)
                ? redirect('/')
                : back()->withErrors([
                    'phone' => 'Sorry! username or password are incorrect',
                ]);
        }
        return redirect('/');
    }

    public function register_form()
    {
        if (!client()->check())
            return view('frontend.auth.register',[
                'title' => 'Register',
                'blood_types' => BloodType::all(),
                'cities' => City::all(),
                'governorates' => Governorate::all()
            ]);
        return back();
    }

    public function register()
    {
        if (!client()->check()){
            $data = $this->validate(request(),[
                'name' => 'required',
                'phone' => 'required|numeric|unique:clients|min:11',
                'email' => 'required|email|unique:clients',
                'date_of_birth' => 'required|date|before:today',
                'city_id' => 'required',
                'blood_type_id' => 'required',
                'last_donation_date' => 'required|date',
                'password' => 'required|confirmed|min:6'
            ]);

            $data['password'] = Hash::make(request('password'));
            $data['rest_code'] = rand(1000,9000);
            $data['api_token'] = Str::random(60);

            if (Client::create($data)) {
                Mail::to(request('email'))->send(new VerifyClient($data));
                return redirect('/')->with('success','Your Account has been created Successfully And Your Activate Link Has Send');
            }
            return back()->with('error','Sorry, ');
        }
        return back();
    }

    public function rest_password_form()
    {
        return view('frontend.auth.rest-password',[
            'title' => 'Rest Password',
        ]);
    }

    public function rest_password()
    {

        $column = is_email(request('user')) ? 'email' : 'phone';
        if ($client = Client::where($column, request('user'))->first()) {
            if ($column === 'email'){
                Mail::to(request('user'))->send(new RestPassword($client));
                return redirect('/')->with('success','Rest Password Link has sent');
            }
            nexmo(request('user'),"Rest Password Code ($client->rest_code)");
            return redirect('/')->with('success','Message Has Sent');
        }
        return back()->with('error','Your Account Doest Exists ');
    }

    public function password_update_form()
    {
       return ($client = Client::where('rest_code',request('rest_code'))->first())
           ?view('frontend.auth.password-update',[
               'title' => 'Change Password',
               'client' => $client
           ])
           : redirect('/')->With('error','sorry This Link is not valid');
    }

    public function password_update()
    {
        $data = $this->validate( request(),[
            'email'=> 'required|email',
            'password' => 'required|confirmed|min:6'
        ]);
        $data['password'] = Hash::make(request('password'));
        if ($client = Client::where('email',request('email'))->first()){
            if ($client->update($data)){
                Mail::to($client->email)->send(new PasswordUpdated($client));
                return redirect('/login')->with('success','Password Has Update');
            } else
                return back()->with('error','You Have Some error');
        }
        return redirect('/')->With('error','sorry This Link is not valid');
    }


    public function verify($rest_code)
    {
        if ($client = Client::where('rest_code',$rest_code)) {
            if ( $client->update(['is_verified'=> 1,'rest_code' => rand(1000,9000)]) ) {
                return (client()->check())
                    ? redirect('/')->with('success','Your Account IS Activate')
                    : redirect('/login')->with('success','Your Account IS Activate');
            }
            return back()->with('error','sorry Your Account Does Not Activate');
        }
        return redirect('/')->with('error','your link is not valid');
    }

    public function logout()
    {
        if (client()->check())
            return client()->logout()
                ? redirect('/login')
                : back();
        return false;
    }

    public function lang($lang)
    {
        if (client()->check())
            return ($client = Client::find(client()->id())) ? $client->update(['lang'=>$lang]) ? back() : back() : back();
        return session()->put('lang',$lang) ? back() : back() ;
    }

}
