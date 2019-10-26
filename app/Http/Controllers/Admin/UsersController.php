<?php

namespace App\Http\Controllers\Admin;


use App\Http\Models\BloodType;
use App\Http\Models\City;
use App\Http\Controllers\Controller;
use App\Http\Models\Governorate;
use App\Mail\VerifyUser;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        return view('admin.users.index',[
            'title' => 'المسئولون',
            'users' => User::with('bloodType')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return  view('admin.users.create',[
            'title'=>'تسجيل مسئول جديد',
            'blood_types' => BloodType::all(),
            'cities' => City::all(),
            'governorates' => Governorate::all(),
            'roles' => Role::all()
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
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' =>'required|confirmed|min:6',
            'username' => 'required|unique:users|min:4',
            'phone' => 'required|numeric|unique:users|min:11',
            'city_id' => 'required|gt:0',
            'blood_type_id' =>  'required|gt:0',
        ]);
        $data['password'] = Hash::make(request('password'));
        $data['rest_code'] = rand(1000,9000);
        $data['picture'] = image('picture');

        if ($user =User::create($data)){
            Mail::to(request('email'))->send(new VerifyUser($data));
            $user->givePermissionTo(request('permissions'));
            $user->assignRole(Role::findById(request('role_name'))->name);

            back()->with('success','تمت إضافة مسئول جديد');
        }
        return  back()->with('error','عفوا هناك خطأ');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function users_verify()
    {
        $this->validate(request(),[
            '_token' => 'required',
            'rest_code' => 'required|integer'
        ]);
        if ($user = User::where('rest_code',request('rest_code')) ) {
            return !$user->email_verified_at
                ? $user->update([
                    'email_verified_at' => Carbon::now()
                ])
                    ? redirect(admin_url(''))->with('success','تم تفعيل حسابك')
                    : redirect(admin_url(''))->with('error','عفوا هذا الرابط غير صالح')
                : redirect(admin_url())->with('error','لقد انتهت مدة الرابط');
        }
        return redirect(admin_url(''))->with('error','عفوا هذا الرابط غير صالح');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        return ($user = User::with('city')->with('bloodType')->find($id))
            ? view('admin.users.update',[
                'title' => "تعديل مستخدم [$user->username]",
                'blood_types' => BloodType::where('id','!=',$user->blood_type_id)->get(),
                'user' => $user,
                'cities' => City::with('governorate')->where('id','!=',$user->city_id)->get(),
                'governorates' => Governorate::all(),
                'roles' => Role::where('name' ,'!=',get_role_name($user))->get(),
            ])
            : back()->with('error', 'عفوا هذا المسئول غير موجود');
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
        if ($user = User::with('city')->with('bloodType')->find($id)){
            $data = $this->validate(request(),[
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users,email,'.$id,
                'password' =>'sometimes|nullable|confirmed|min:6',
                'username' => 'required|min:4|unique:users,username,'.$id,
                'phone' => 'required|numeric|min:11|unique:users,phone,'.$id,
                'city_id' => 'required|gt:0',
                'picture' => 'sometimes|nullable',
                'blood_type_id' =>  'required|gt:0',
            ]);
            $data['password'] = request('password') ?  Hash::make(request('password')) : $user->password;
            $data['picture'] = image('picture',false,$user->picture);

            request('role_name') ?  $user->assignRole(Role::findById(request('role_name'))->name) :null;
            return $user->update($data)
                ? back()->with('success','تم تحديث المسئول بنجاح')
                : back()->with('error','عفوا هناك خطأ');
        }
        return back()->with('error', 'عفوا هذا المسئول غير موجود');
    }

    public function user_edit_form()
    {
        return ($user = User::with('city')->with('bloodType')->find(auth()->id()))
            ? view('admin.users.update',[
                'title' => "تعديل مستخدم [$user->username]",
                'blood_types' => BloodType::where('id','!=',$user->blood_type_id)->get(),
                'user' => $user,
                'countries' => City::with('governorate')->where('id','!=',$user->city_id)->get(),
            ])
            : back()->with('error', 'عفوا هذا المسئول غير موجود');
    }

    public function user_edit()
    {
        if ($user = User::with('city')->with('bloodType')->find(auth()->id())){
            $data = $this->validate(request(),[
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users,email,'.auth()->id(),
                'password' =>'sometimes|nullable|confirmed|min:6',
                'username' => 'required|min:4|unique:users,username,'.auth()->id(),
                'phone' => 'required|numeric|min:11|unique:users,phone,'.auth()->id(),
                'city_id' => 'required|gt:0',
                'picture' => 'sometimes|nullable',
                'blood_type_id' =>  'required|gt:0',
            ]);
            $data['password'] = request('password') ?  Hash::make(request('password')) : $user->password;
            $data['picture'] = image('picture',false,$user->picture);
            return $user->update($data)
                ? back()->with('success','تم تحديث المسئول بنجاح')
                : back()->with('error','عفوا هناك خطأ');
        }
        return back()->with('error', 'عفوا هذا المسئول غير موجود');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return ($user = User::find($id))
            ? $user->delete()
                ? back()->with('success','تم حذف المسئول بنجاح')
                : back()->with('error','عفوا هناك خطأ')
            : back()->with('error','عفوا هذا المسئول غير موجود');
    }

    /**
     *
     */
    public function permission()
    {
        if (request()->ajax()){
            return ( $permission = Role::with('permissions')->find(request('id'))  )
                ? json($permission->permissions,1,'تم جلب البيانات بنجاح')
                : json('',0,'هذا الدور لايملك صلاحيات');
        }
        return redirect('/')->with('error','عفوا هذا الرابط غير صالح');
    }

}
